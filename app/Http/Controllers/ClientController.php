<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index(Request $request): View
    {
        $filterBySearch = $request->query('search');

        $clientsQuery = User::where('user_type', 'C');

        if ($filterBySearch !== null) {
            $clientsQuery->where(function ($q) use ($filterBySearch) {
                $q->where('name', 'like', "%$filterBySearch%")
                    ->orWhere('email', 'like', "%$filterBySearch%");
            });
        }

        $clients = $clientsQuery
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('clients.index', compact('clients', 'filterBySearch'));
    }


    public function show(User $user)
    {
        if ($user->user_type !== 'C') {
            return redirect()->route('clients.index')
                ->with('error', 'O utilizador selecionado não é um cliente.');
        }

        $user->load('customer');

        return view('clients.show', compact('user'));
    }

    public function destroy(User $user)
    {
        if ($user->user_type !== 'C') {
            return redirect()->route('clients.index')->with('error', 'Ação inválida.');
        }

        $customerRecord = $user->customer;
        $fileName = $user->photo_url;

        $hasHistory = $customerRecord && (
            $customerRecord->orders()->exists() ||
            $customerRecord->tshirt_images()->exists()
        );

        if ($hasHistory) {
            if ($customerRecord) {
                $customerRecord->nif = null;
                $customerRecord->delete();
            }
            $user->delete();
        } else {
            $customerRecord?->forceDelete();
            $user->forceDelete();
        }

        if ($fileName && Storage::disk('public')->exists('photos/' . $fileName)) {
            Storage::disk('public')->delete('photos/' . $fileName);
        }
        return redirect()->route('clients.index')->with('success', "Cliente " . $user->name . " apagado(a).");
    }

    public function myOrders(Request $request): View
    {
        $customerRecord = $request->user()?->customer;

        if (!$customerRecord) {
            $orders = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 20);
            return view('orders.my', compact('orders'));
        }

        $orders = Order::where('customer_id', $customerRecord->id)
            ->where('status', 'closed')
            ->orderBy('created_at', 'desc') 
            ->paginate(20)
            ->withQueryString();

        return view('orders.my', compact('orders'));
    }
}
