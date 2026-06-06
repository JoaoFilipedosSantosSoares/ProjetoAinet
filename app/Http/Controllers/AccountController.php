<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AccountController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            // As páginas de login, registo e recuperar pass só dão para quem NÃO tem login feito (convidados)
            new Middleware('guest', only: ['login', 'register', 'forgotPassword']),

            // Todos os outros métodos exigem utilizador autenticado
            new Middleware('auth', except: ['login', 'register', 'forgotPassword']),
            new Middleware('verified', except: ['login', 'register', 'forgotPassword']),

            // MÓDULO G1 (ADMIN): Só o Admin pode listar e ver utilizadores
            new Middleware('can:viewAny,App\Models\User', only: ['adminUsers']),

            // MÓDULO G1 (ADMIN): Só o Admin pode bloquear/apagar contas. 
            // A UserPolicy garante automaticamente que o admin NÃO se pode bloquear/apagar a si próprio!
            new Middleware('can:delete,user', only: ['destroy', 'toggleBlock']),
        ];
    }

    // ===========================================================================
    // =================================AREA GUEST================================
    // ===========================================================================

    public function login()
    {
        return view('account.login.index');
    }

    public function register()
    {
        return view('account.register.index');
    }

    public function forgotPassword()
    {
        return view('account.login.forgot-password');
    }

    // ===========================================================================
    // =============================AREA AUTENTICADA==============================
    // ===========================================================================

    public function index()
    {
        $user = Auth::user();
        $orders = null;
        
        // Se o utilizador logado for um Cliente ('C'), carregamos o seu histórico
        if ($user->user_type === 'C') {

            $orders = Order::where('customer_id', $user->id)
                ->orderBy('date', 'desc')
                ->paginate(10)
                ->withQueryString();
        }

        // Passamos os dados usando o compact() que o teu professor tanto usa no index
        return view('account.index', compact('user', 'orders'));
    }

    public function editProfile(): View
    {
        $user = Auth::user();
        return view('account.profile')->with('user', $user);
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

        $htmlMessage = "O seu perfil foi atualizado com sucesso!";
        return redirect()->back()
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    // ===========================================================================
    // ===============================AREA ADMIN==================================
    // ===========================================================================

    public function adminUsers(Request $request): View
    {
        $filterByType = $request->query('type');
        $filterBySearch = $request->query('search');
        
        $usersQuery = User::query();

        if ($filterByType !== null) {
            $usersQuery->where('user_type', $filterByType);
        }

        if ($filterBySearch !== null) {
            $usersQuery->where(function($q) use ($filterBySearch) {
                $q->where('name', 'like', "%$filterBySearch%")
                  ->orWhere('email', 'like', "%$filterBySearch%");
            });
        }

        $users = $usersQuery
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('account.admin.users', compact('users', 'filterByType', 'filterBySearch'));
    }

    public function toggleBlock(User $user): RedirectResponse
    {
        // Inverte o estado atual do campo blocked (0 vira 1, e 1 vira 0)
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

    public function destroy(User $user): RedirectResponse
    {
        try {
            DB::transaction(function () use ($user) {
                // Se o cliente tiver relações pesadas que impeçam a remoção direta na BD SQLite,
                // segue a mesma estrutura de proteção por catch do professor
                $user->delete();
            });

            $alertType = 'success';
            $alertMsg = "O utilizador <b>{$user->name}</b> foi eliminado com sucesso!";
            
            return redirect()->route('account.adminUsers')
                ->with('alert-type', $alertType)
                ->with('alert-msg', $alertMsg);
        } catch (\Exception $error) {
            return redirect()->back()
                ->with('alert-type', 'danger')
                ->with('alert-msg', "Não foi possível eliminar o utilizador porque existem registos associados (ex: encomendas).");
        }
    }
}
