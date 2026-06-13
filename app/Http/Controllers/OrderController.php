<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_Item;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Storage;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class OrderController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            // Apenas Funcionários/Admins podem listar todas as encomendas
            new Middleware('can:viewAny,App\Models\Order', only: ['index']),

            // Apenas quem tem permissão pode ver os detalhes de uma encomenda da logística
            new Middleware('can:view,order', only: ['show']),

            // Apenas quem tem permissão (Funcionários) pode alterar o estado no update
            new Middleware('can:update,order', only: ['update']),
        ];
    }

    public function index(Request $request): View
    {
        $user = Auth::user();
        $filterBySearch = $request->query('search');
        $filterByStatus = $request->query('status');
        $filterByCustomer = $request->query('customer');

        $ordersQuery = Order::query();

        if ($user->user_type === 'F') {
            $ordersQuery->where('status', '=', 'pending');
        } else {
            if (!empty($filterByStatus)) {
                $ordersQuery->where('status', '=', $filterByStatus);
            }
        }

        if (!empty($filterBySearch)) {
            $ordersQuery->where('id', '=', $filterBySearch);
        }

        if ($user->user_type === 'A' && !empty($filterByCustomer)) {
            $ordersQuery->whereHas('customer.user', function ($query) use ($filterByCustomer) {
                $query->where('name', 'like', "%{$filterByCustomer}%")
                    ->orWhere('email', 'like', "%{$filterByCustomer}%");
            });
        }

        $orders = $ordersQuery
            ->with('customer.user')
            ->orderBy('date', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('orders.index', compact('orders', 'filterBySearch', 'filterByStatus', 'filterByCustomer'));
    }

    public function show(Order $order): View
    {
        $order->load('order_items.tshirt_image');
        return view('orders.show', compact('order'));
    }

    public function downloadReceipt(Order $order): RedirectResponse|StreamedResponse
    {
        // 2. MUDANÇA AQUI: Substitui $this->authorize() por Gate::authorize()
        Gate::authorize('view', $order);

        // 3. Verifica se a encomenda tem um recibo associado na base de dados
        if (empty($order->receipt_url)) {
            return redirect()->back()
                ->with('alert-type', 'danger')
                ->with('alert-msg', 'Esta encomenda ainda não possui um recibo disponível.');
        }

        // 4. Define o caminho correto dentro do storage privado
        $filePath = 'pdf_receipts/' . $order->receipt_url;

        // 5. Verifica se o ficheiro físico existe mesmo no disco privado
        if (!Storage::exists($filePath)) {
            return redirect()->back()
                ->with('alert-type', 'danger')
                ->with('alert-msg', 'O ficheiro do recibo não foi encontrado no servidor.');
        }

        // 6. Faz o download seguro do ficheiro privado
        return Storage::download($filePath, "recibo-encomenda-{$order->id}.pdf");
    }

    /**
     * Prepara os dados do checkout calculando os preços e totais antes de renderizar a View.
     */
    public function checkout()
    {
        $user = Auth::user();

        if (in_array($user->user_type, ['A', 'E'])) {
            return redirect()->route('cart.index')->with('error', 'Administradores e funcionários não podem efetuar compras.');
        }

        $cartItems = session()->get('cart', []);
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'O seu carrinho está vazio.');
        }

        $priceRules = Price::first();
        $grandTotal = 0;

        // Calcula os preços de forma idêntica ao storeCheckout para manter integridade total
        foreach ($cartItems as $id => &$item) {
            $isCatalog = (bool) ($item['isCatalogImage'] ?? false);
            $qty = (int) ($item['quantity'] ?? 1);

            if (!$priceRules) {
                $unitPrice = $isCatalog ? ($qty >= 5 ? 20.00 : 25.00) : ($qty >= 5 ? 40.00 : 50.00);
            } else {
                if ($qty >= $priceRules->qty_discount) {
                    $unitPrice = $isCatalog ? $priceRules->unit_price_catalog_discount : $priceRules->unit_price_own_discount;
                } else {
                    $unitPrice = $isCatalog ? $priceRules->unit_price_catalog : $priceRules->unit_price_own;
                }
            }

            // Injeta os valores calculados diretamente no array do item para a View consumir de forma limpa
            $item['unit_price'] = $unitPrice;
            $item['sub_total'] = $unitPrice * $qty;
            
            $grandTotal += $item['sub_total'];
        }
        unset($item); // Quebra a referência por segurança do PHP

        return view('orders.checkout', compact('cartItems', 'grandTotal', 'priceRules'));
    }

    public function storeCheckout(Request $request)
    {
        $user = Auth::user();

        if (in_array($user->user_type, ['A', 'E'])) {
            return redirect()->route('cart.index')->with('error', 'Acesso negado.');
        }

        $cartItems = session()->get('cart', []);
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'O seu carrinho está vazio.');
        }

        // 1. VALIDAÇÃO ESTRETA CONFORME O ENUNCIADO
        $request->validate([
            'address' => 'required|string|max:255',
            'nif' => 'nullable|digits:9',
            // Aceita exatamente "Visa", "PayPal" ou "MB WAY" (sensível a maiúsculas)
            'payment_type' => 'required|in:Visa,PayPal,MB WAY',
            'notes' => 'nullable|string|max:1000',
            'payment_ref' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    switch ($request->payment_type) {
                        case 'VISA':
                            if (!preg_match('/^4[0-9]{15}$/', $value)) {
                                $fail('O número do cartão Visa deve conter exatamente 16 dígitos e começar com 4.');
                            }
                            break;
                        case 'MB WAY':
                            // 9 dígitos e OBRIGATORIAMENTE iniciado por 9
                            if (!preg_match('/^9[0-9]{8}$/', $value)) {
                                $fail('O número de telemóvel MB WAY deve conter exatamente 9 dígitos e começar com 9.');
                            }
                            break;
                        case 'PayPal':
                            // E-mail válido
                            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                $fail('O formato do e-mail PayPal é inválido.');
                            }
                            break;
                    }
                },
            ],
        ]);

        $priceRules = Price::first();
        $grandTotal = 0;
        $itemsToSave = [];

        foreach ($cartItems as $id => $item) {
            $isCatalog = (bool) $item['isCatalogImage'];
            $qty = (int) $item['quantity'];

            if (!$priceRules) {
                $unitPrice = $isCatalog ? ($qty >= 5 ? 20.00 : 25.00) : ($qty >= 5 ? 40.00 : 50.00);
            } else {
                if ($qty >= $priceRules->qty_discount) {
                    $unitPrice = $isCatalog ? $priceRules->unit_price_catalog_discount : $priceRules->unit_price_own_discount;
                } else {
                    $unitPrice = $isCatalog ? $priceRules->unit_price_catalog : $priceRules->unit_price_own;
                }
            }

            $subTotal = $unitPrice * $qty;
            $grandTotal += $subTotal;

            $itemsToSave[] = [
                'tshirt_image_id' => $item['tshirt_image_id'],
                'color_code' => $item['color'],
                'size' => $item['size'],
                'qty' => $qty,
                'unit_price' => $unitPrice,
                'sub_total' => $subTotal,
            ];
        }

        // VALIDAÇÃO EXTRA DO VALOR SEGUNDO O ENUNCIADO (0.01 até 999999.99)
        if ($grandTotal < 0.01 || $grandTotal > 999999.99) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['payment_ref' => 'O valor total da encomenda excede os limites permitidos para pagamento.']);
        }

        try {
            // Limpa espaços que o utilizador possa ter digitado na referência
            $cleanReference = str_replace(' ', '', $request->payment_ref);

            $response = Http::withOptions([
                'verify' => false,
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => 0
                ],
            ])->post('https://ainet-payments-api.vercel.app/api/payments', [
                        'type' => $request->payment_type, // "Visa", "MB WAY" ou "PayPal"
                        'reference' => $cleanReference,        // Chave EXATA do enunciado
                        'value' => (float) number_format($grandTotal, 2, '.', ''), // Número com até 2 casas decimais
                    ]);

            // Se a API responder com erro (status code diferente de 2xx)
            if ($response->failed()) {
                $apiError = $response->json()['message'] ?? 'Validation failed';
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['payment_ref' => "<b>Erro de Pagamento:</b> {$apiError}"]);
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['payment_ref' => 'Não foi possível contactar a plataforma externa de pagamentos. Tente novamente mais tarde.']);
        }

        // 4. GRAVAÇÃO NA BASE DE DADOS (TRANSAÇÃO ATÓMICA)
        $order = DB::transaction(function () use ($user, $request, $grandTotal, $itemsToSave) {

            // Como a API deu OK, salvamos como 'paid' (ou 'pending' se a tua BD exigir)
            $newOrder = Order::create([
                'status' => 'pending',
                'customer_id' => $user->customer->id ?? null,
                'date' => now()->toDateString(),
                'total_price' => $grandTotal,
                'notes' => $request->notes,
                'nif' => $request->nif,
                'address' => $request->address,
                'payment_type' => $request->payment_type, // Salva o texto exato validado
                'payment_ref' => $request->payment_ref,
            ]);

            // Associa os itens à encomenda
            foreach ($itemsToSave as $itemData) {
                $itemData['order_id'] = $newOrder->id;
                Order_item::create($itemData);
            }

            return $newOrder;
        });

        // 5. LIMPAR CARRINHO E REDIRECIONAR
        session()->forget('cart');

        return redirect()->route('account.index')
            ->with('status', 'order-placed-success')
            ->with('order_id', $order->id);
    }

    public function confirm(Request $request): RedirectResponse
    {
        $request->validate([
            'payment_type' => 'required|in:VISA,MB WAY,PAYPAL',
            'payment_ref' => 'required|string',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('alert-type', 'warning')
                ->with('alert-msg', 'O seu carrinho está vazio.');
        }

        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['subtotal'];
        }

        $paymentPayload = [
            'provider' => strtolower($request->payment_type),
            'merchant_key' => 'chave_do_teu_enunciado_aqui',
            'amount' => $totalPrice,
            'data' => [
                'reference' => $request->payment_ref
            ]
        ];

        try {
            $response = Http::post('https://ainet-payments-api.vercel.app/api/payments', $paymentPayload);

            if ($response->failed()) {
                $errorMessage = $response->json()['message'] ?? 'O pagamento foi recusado pela entidade bancária.';
                return redirect()->back()->withInput()->withErrors(['payment' => $errorMessage]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['payment' => 'Erro ao estabelecer comunicação com o servidor de pagamentos externa.']);
        }

        $newOrder = DB::transaction(function () use ($request, $cart, $totalPrice) {
            $order = Order::create([
                'customer_id' => Auth::user()->customer->id,
                'status' => 'pago',
                'date' => now()->toDateString(),
                'total_price' => $totalPrice,
                'notes' => $request->notes,
            ]);

            foreach ($cart as $item) {
                Order_Item::create([
                    'order_id' => $order->id,
                    'tshirt_image_id' => $item['image_id'],
                    'color_code' => $item['color_code'],
                    'size' => $item['size'],
                    'qty' => $item['qty'],
                    'unit_price' => $item['unit_price'],
                    'sub_total' => $item['subtotal']
                ]);
            }

            return $order;
        });

        session()->forget('cart');

        $url = route('orders.show', ['order' => $newOrder]);
        $htmlMessage = "A encomenda <a href='$url'><u>#{$newOrder->id}</u></a> foi submetida e paga com sucesso!";

        return redirect()->route('orders.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:closed,canceled,pending,paid',
            'reason_for_cancellation' => 'nullable|string|max:1000',
        ]);

        if ($request->status === 'canceled' && Auth::user()->user_type !== 'A') {
            return redirect()->back()
                ->with('alert-type', 'error')
                ->with('alert-msg', 'Apenas administradores podem anular encomendas.');
        }

        $updateData = [
            'status' => $request->status,
        ];

        if ($request->status === 'canceled') {
            $currentReason = $order->reason_for_cancellation;

            if (!empty($request->reason_for_cancellation)) {
                $timestamp = now()->format('d/m/Y H:i');
                $break = !empty($currentReason) ? "\n\n" : "";
                $updateData['reason_for_cancellation'] = $currentReason . $break . "[Cancelado em {$timestamp}] " . $request->reason_for_cancellation;
            }
        }

        $order->update($updateData);

        $message = $request->status === 'canceled'
            ? "Encomenda <b>#{$order->id}</b> foi anulada com sucesso."
            : "Encomenda <b>#{$order->id}</b> marcada como concluída!";

        return redirect()->route('orders.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $message);
    }
}