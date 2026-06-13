<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AccountController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('verified'),
        ];
    }

    public function index(): View
    {
        $user = Auth::user();
        $orders = null;
        $cancelledOrders = collect(); // Coleção vazia por defeito

        if ($user->user_type === 'C') {
            $customerId = $user->customer?->id;

            if ($customerId) {
                // 1. Encomendas Concluídas/Fechadas
                $orders = Order::where('customer_id', $customerId)
                    ->where('status', 'closed')
                    ->orderBy('id', 'desc')
                    ->paginate(10)
                    ->withQueryString();

                // 2. Encomendas Canceladas (não paginadas, ou paginadas se preferires)
                $cancelledOrders = Order::where('customer_id', $customerId)
                    ->where('status', 'canceled')
                    ->orderBy('id', 'desc')
                    ->get();
            }
        }

        return view('account.index', compact('user', 'orders', 'cancelledOrders'));
    }

    public function editProfile(): View
    {
        return view('account.profile')->with('user', Auth::user());
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        DB::transaction(function () use ($request, $user) {
            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();
        });

        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', "O seu perfil foi atualizado com sucesso!");
    }
    public function toggleBlock(User $user): RedirectResponse
    {
        DB::transaction(function () use ($user) {
            $user->blocked = !$user->blocked;
            $user->save();
        });

        $status = $user->blocked ? 'bloqueado' : 'desbloqueado';
        $htmlMessage = "Utilizador <b>{$user->name}</b> foi {$status} com sucesso!";

        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }
}
