<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

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
}
