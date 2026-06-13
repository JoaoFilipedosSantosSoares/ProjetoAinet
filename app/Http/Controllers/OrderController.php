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
            // Se for Admin (A), pode filtrar por qualquer estado selecionado
            if (!empty($filterByStatus)) {
                $ordersQuery->where('status', '=', $filterByStatus);
            }
        }

        // Filtro por ID (comum a ambos)
        if (!empty($filterBySearch)) {
            $ordersQuery->where('id', '=', $filterBySearch);
        }

        // Filtro por Cliente (Apenas para Admin - Pesquisa por Nome ou Email do User)
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

    // public function updateStatus(Request $request, Order $order): RedirectResponse
    // {
    //     $request->validate([
    //         'status' => 'required|in:pendente,pago,em processamento,enviado,cancelado'
    //     ]);

    //     if (in_array($order->status, ['cancelado', 'enviado'])) {
    //         return redirect()->back()->with('error', 'Não é possível alterar o estado de uma encomenda finalizada.');
    //     }

    //     $order->update(['status' => $request->status]);
    //     return redirect()->back()->with('success', 'Estado atualizado.');
    // }

    public function checkout()
    {
        $user = Auth::user();

        // Requisito: Apenas Clientes. Administradores (A) e Funcionários (E) não têm acesso.
        if (in_array($user->user_type, ['A', 'E'])) {
            return redirect()->route('cart.index')->with('error', 'Administradores e funcionários não podem efetuar compras.');
        }

        $cartItems = session()->get('cart', []);
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'O seu carrinho está vazio.');
        }

        $priceRules = Price::first();

        return view('orders.checkout', compact('cartItems', 'priceRules'));
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

        // Validação estrita dos dados obrigatórios de faturação/envio e pagamento
        $request->validate([
            'address' => 'required|string|max:255',
            'nif' => 'nullable|digits:9',
            'payment_type' => 'required|in:VISA,MB WAY,PAYPAL',
            'notes' => 'nullable|string|max:1000',
            'payment_ref' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    switch ($request->payment_type) {
                        case 'VISA':
                            // Verifica se são exatamente 16 dígitos e começam com 4
                            if (!preg_match('/^4[0-9]{15}$/', $value)) {
                                $fail('O número do cartão Visa deve conter exatamente 16 dígitos e começar com 4.');
                            }
                            break;
                        case 'MB WAY':
                            // Verifica se são exatamente 9 dígitos
                            if (!preg_match('/^[0-9]{9}$/', $value)) {
                                $fail('O número de telemóvel MB WAY deve conter exatamente 9 dígitos.');
                            }
                            break;
                        case 'PAYPAL':
                            // Verifica formato de email
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

        // Replicar integralmente a informação para garantir a imutabilidade histórica
        foreach ($cartItems as $id => $item) {
            $isCatalog = (bool) $item['isCatalogImage'];
            $qty = (int) $item['quantity'];

            // Determinar o preço unitário do momento exato da compra
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

        // Simulação do Pagamento
        $paymentSuccess = true;
        if (strlen($request->payment_ref) < 3) {
            $paymentSuccess = false;
        }

        if (!$paymentSuccess) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['payment_ref' => 'O pagamento simulado foi recusado pela entidade emissora. Verifique os dados inseridos.']);
        }

        // Mapeamento ortográfico EXATO exigido pela tua Base de Dados (CHECK constraint)
        $formPaymentType = $request->payment_type;
        $dbPaymentType = match ($formPaymentType) {
            'VISA' => 'Visa',
            'MB WAY' => 'MB WAY',
            'PAYPAL' => 'PayPal',
            default => $formPaymentType
        };

        // Gravação na Base de Dados dentro de uma transação atómica
        $order = DB::transaction(function () use ($user, $request, $grandTotal, $itemsToSave, $dbPaymentType) {

            // Regista a Encomenda no estado correto esperado pelo Modelo e BD ('pending')
            $newOrder = Order::create([
                'status' => 'pending', // <--- Alterado de volta para 'pending' para passar no CHECK constraint
                'customer_id' => $user->customer->id ?? null,
                'date' => now()->toDateString(),
                'total_price' => $grandTotal,
                'notes' => $request->notes,
                'nif' => $request->nif,
                'address' => $request->address,
                'payment_type' => $dbPaymentType,
                'payment_ref' => $request->payment_ref,
            ]);

            // Associa as linhas imutáveis à encomenda gerada
            foreach ($itemsToSave as $itemData) {
                $itemData['order_id'] = $newOrder->id;
                Order_item::create($itemData);
            }

            return $newOrder;
        });

        // Limpa o carrinho de compras da sessão do utilizador
        session()->forget('cart');

        // Redireciona para o teu histórico de encomendas com as chaves padrão de sessão
        return redirect()->route('home')
            ->with('alert-type', 'success')
            ->with('alert-msg', "Encomenda <b>#{$order->id}</b> registada com sucesso!");
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

        // Chamada à API de pagamentos externa
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
                'customer_id' => Auth::user()->customer->id, // Mantido exatamente o teu original
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
        // dd($request->all());
        // 1. Validação estrita
        // 1. Validação adaptada para o campo 'notes' que vem do teu HTML
        $request->validate([
            'status' => 'required|in:closed,canceled,pending,paid',
            'reason_for_cancellation'  => 'nullable|string|max:1000',
        ]);

        // 2. Proteção para garantir que apenas Administradores anulam encomendas
        if ($request->status === 'canceled' && Auth::user()->user_type !== 'A') {
            return redirect()->back()
                ->with('alert-type', 'error')
                ->with('alert-msg', 'Apenas administradores podem anular encomendas.');
        }

        // 3. Preparar os dados para o update
        $updateData = [
            'status' => $request->status,
        ];

        // Se for um cancelamento, fazemos a gestão do texto na coluna 'reason_for_cancellation'
        if ($request->status === 'canceled') {
            $currentReason = $order->reason_for_cancellation;

            // Lemos o $request->reason_for_cancellation porque é aí que o teu form está a injetar o "teste"
            if (!empty($request->reason_for_cancellation)) {
                $timestamp = now()->format('d/m/Y H:i');
                $break = !empty($currentReason) ? "\n\n" : "";

                // Concatena o novo motivo na coluna certa da BD
                $updateData['reason_for_cancellation'] = $currentReason . $break . "[Cancelado em {$timestamp}] " . $request->reason_for_cancellation;
            }
        }

        // 4. Atualiza os dados na Base de Dados
        $order->update($updateData);

        // 5. Mensagens de feedback
        $message = $request->status === 'canceled'
            ? "Encomenda <b>#{$order->id}</b> foi anulada com sucesso."
            : "Encomenda <b>#{$order->id}</b> marcada como concluída!";

        return redirect()->route('orders.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $message);
    }
}
