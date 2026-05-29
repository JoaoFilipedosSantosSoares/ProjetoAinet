<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
       /*  $allOrders = Order::where('status', '=', 'pending')->get(); */
        $allOrders = Order::where('status', '!=', 'closed')->get();
        return view('orders.index')->with('orders', $allOrders);
    }
}
