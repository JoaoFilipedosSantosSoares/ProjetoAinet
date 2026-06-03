<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::where('status', '=', 'pending');

        if ($request->filled('search')) {
            $query->where('id', '=', $request->search);
        }

        $allOrders = $query->paginate(10);
        return view('orders.index')->with('orders', $allOrders);
    }

    public function update(Order $order)
    {
        $order->update(['status' => 'closed']);
        return redirect()->back()->with('success', 'Order updated successfully.');
    }
}
