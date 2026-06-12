<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;

class ClientController extends Controller
{
    /**
     * Lista todos os clientes.
     */
    public function index(Request $request): View
    {
        // Captura os dados do formulário de clientes
        $filterBySearch = $request->query('search');

        // Traz APENAS clientes ('C')
        $clientsQuery = User::where('user_type', 'C');

        // Se houver pesquisa, filtra por nome ou email
        if ($filterBySearch !== null) {
            $clientsQuery->where(function ($q) use ($filterBySearch) {
                $q->where('name', 'like', "%$filterBySearch%")
                    ->orWhere('email', 'like', "%$filterBySearch%");
            });
        }

        // Ordena, pagina e mantém a Query String no URL
        $clients = $clientsQuery
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        // Envia exatamente as mesmas variáveis para a view de clientes
        return view('clients.index', compact('clients', 'filterBySearch'));
    }

    /**
     * Mostra o perfil detalhado de um cliente específico.
     */
    public function show(User $user)
    {
        // Segurança: Se tentarem meter o ID de um Admin/Funcionário no URL de clientes
        if ($user->user_type !== 'C') {
            return redirect()->route('clients.index')
                ->with('error', 'O utilizador selecionado não é um cliente.');
        }

        // Se o cliente tiver uma relação com a tabela 'customer' (para NIF, morada, etc.)
        $user->load('customer');

        return view('clients.show', compact('user'));
    }

    /**
     * Bloqueia ou desbloqueia a conta de um cliente.
     */
    public function toggleBlock(User $user)
    {
        if ($user->user_type !== 'C') {
            return redirect()->route('clients.index')
                ->with('error', 'Ação inválida.');
        }

        // Inverte o estado de bloqueio (ajusta o nome da coluna conforme a tua BD, ex: 'blocked' ou 'active')
        $user->blocked = !$user->blocked;
        $user->save();

        $status = $user->blocked ? 'bloqueado' : 'desbloqueado';

        return redirect()->back()
            ->with('success', "O cliente {$user->name} foi {$status} com sucesso.");
    }

    /**
     * Remove o cliente do sistema (com Soft Delete ou Force Delete).
     */
    public function destroy(User $user)
    {
        if ($user->user_type !== 'C') {
            return redirect()->route('clients.index')
                ->with('error', 'Ação inválida.');
        }

        // Se usares Soft Deletes e quiseres libertar o e-mail para não dar erro se ele se quiser registar de novo:
        $user->email = $user->email . '//deleted//' . now()->timestamp;

        if ($user->customer) {
            $user->customer->nif = null; // Liberta o NIF para não bloquear futuros registos
            $user->customer->save();
        }
        $user->save();

        // Faz o Soft Delete (ou ->forceDelete() se quiseres apagar de vez)
        $user->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Conta de cliente eliminada com sucesso.');
    }
}
