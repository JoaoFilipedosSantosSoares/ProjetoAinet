<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Exibe a página de login.
     */
    public function login(): View
    {
        return view('account.login.index');
    }

    /**
     * Exibe a página de registo.
     */
    public function register(): View
    {
        return view('account.register.index');
    }

    /**
     * Exibe a página de recuperação de palavra-passe.
     */
    public function forgotPassword(): View
    {
        return view('account.login.forgot-password');
    }

    /**
     * Processa a tentativa de autenticação (Submissão do formulário - POST).
     * Esta lógica funde e mantém o carrinho do utilizador visitante de forma automática.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('cart.index'))
                ->with('success', 'Sessão iniciada! O teu carrinho está à tua espera.');
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registos.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Sessão terminada com sucesso. Volte sempre!');
    }
}