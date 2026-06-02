<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
       /*  $allOrders = Order::where('status', '=', 'pending')->paginate(20); */
        $allOrders = Order::where('status', '!=', 'closed')->paginate(20);
        return view('orders.index')->with('orders', $allOrders);
    }

    public function update(Request $request, Order $order)
    {
        $order->update(['status' => 'pending']);
        return redirect()->back()->with('success', 'Order updated successfully.');
    }
}
