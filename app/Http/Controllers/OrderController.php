<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_Item;
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
            // Só entra no index se passar no viewAny da OrderPolicy
            new Middleware('can:viewAny,App\Models\Order', only: ['index']),
            
            // Só entra no formulário ou na confirmação se passar no create da OrderPolicy
            new Middleware('can:create,App\Models\Order', only: ['checkout', 'confirm']),
            
            // Só entra no show se passar no método view da OrderPolicy para a $order específica
            new Middleware('can:view,order', only: ['show']),
            
            // Só entra no updateStatus se passar no método update da OrderPolicy para a $order específica
            new Middleware('can:update,order', only: ['updateStatus']),
        ];
    }

    public function index(Request $request): View
    {
        $filterBySearch = $request->query('search');
        $user = Auth::user();
        
        $ordersQuery = Order::query();

        if ($user->user_type === 'C') {
            $ordersQuery->where('customer_id', $user->id);
        }

        if ($filterBySearch !== null) {
            $ordersQuery->where('id', '=', $filterBySearch);
        }

        $orders = $ordersQuery
            ->with('customer.user')
            ->orderBy('date', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('orders.index', compact('orders', 'filterBySearch'));
    }

    public function show(Order $order): View
    {
        $order->load('orderItems.tshirtImage', 'customer.user');
        
        return view('orders.show')->with('order', $order);
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pendente,pago,em processamento,enviado,cancelado'
        ]);

        if (in_array($order->status, ['cancelado', 'enviado'])) {
            return redirect()->back()->with('error', 'Não é possível alterar o estado de uma encomenda finalizada.');
        }

        $order->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Estado atualizado.');
    }

    public function checkout(): View|RedirectResponse
    {
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

        return view('orders.checkout')
            ->with('cart', $cart)
            ->with('totalPrice', $totalPrice);
    }

    // NÃO TENHO A CERTEZA SE ISTO ESTÁ CORRETO
    public function confirm(Request $request): RedirectResponse
    {
        $request->validate([
            'payment_type' => 'required|in:VISA,MC,PAYPAL,MBWAY',
            'payment_ref'  => 'required|string',
            'notes'        => 'nullable|string|max:1000',
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
                'customer_id'  => Auth::user()->customer->id, // Mantido exatamente o teu original
                'status'       => 'pago',
                'date'         => now()->toDateString(),
                'total_price'  => $totalPrice,
                'notes'        => $request->notes,
            ]);

            foreach ($cart as $item) {
                Order_Item::create([
                    'order_id'        => $order->id,
                    'tshirt_image_id' => $item['image_id'],
                    'color_code'      => $item['color_code'],
                    'size'            => $item['size'],
                    'qty'             => $item['qty'],
                    'unit_price'      => $item['unit_price'],
                    'sub_total'       => $item['subtotal']
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
            'status' => 'required|in:pendente,pago,em processamento,enviado,cancelado'
        ]);

        if (in_array($order->status, ['cancelado', 'enviado'])) {
            return redirect()->back()
                ->with('alert-type', 'warning')
                ->with('alert-msg', "Não é possível alterar o estado da encomenda <b>#{$order->id}</b> porque ela já se encontra no estado: {$order->status}");
        }

        DB::transaction(function () use ($request, $order) {
            $order->update([
                'status' => $request->status
            ]);
        });

        $url = route('orders.show', ['order' => $order]);
        $htmlMessage = "O estado da encomenda <a href='$url'><u>#{$order->id}</u></a> foi atualizado com sucesso para <b>{$request->status}</b>!";

        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }
}
