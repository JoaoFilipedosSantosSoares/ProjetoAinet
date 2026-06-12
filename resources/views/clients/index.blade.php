@component('layouts.main-content')
<div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">

    {{-- Cabeçalho da Página --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-zinc-900 md:text-4xl">Gestão de Clientes (Modo de Teste)</h1>
            <p class="mt-2 text-sm text-zinc-600">Lista completa de todos os clientes registados na FunShirt.</p>
        </div>
    </div>

    {{-- Mensagens de Estado (Alertas Flash) --}}
    @if(session('error'))
    <div class="mb-6 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-semibold text-red-600 shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 shrink-0">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
        </svg>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    @if(session('success'))
    <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-semibold text-emerald-600 shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 shrink-0">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    {{-- Barra de Pesquisa --}}
    <form method="GET" action="/clients" class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between bg-zinc-50 p-4 rounded-2xl border border-zinc-200">
        <div class="flex flex-1 flex-col gap-4 sm:flex-row sm:items-center">
            <div class="relative flex-1">
                <input type="text" name="search" value="{{ $filterBySearch ?? '' }}" placeholder="Pesquisar cliente por nome ou e-mail..."
                    class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2 text-sm text-zinc-900 placeholder-zinc-400 focus:border-zinc-950 focus:outline-none">
            </div>
        </div>

        <div class="flex items-center gap-2">
            <form method="GET" action="/clients" class="...">
                <input type="text" name="search" value="{{ $filterBySearch ?? '' }}" placeholder="Pesquisar...">

                <button type="submit">Pesquisar</button>
            </form>
            <a href="/clients" class="rounded-xl bg-zinc-200 px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-300 transition">
                Limpar
            </a>
        </div>
    </form>

    {{-- Tabela de Clientes --}}
    <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left text-sm text-zinc-500">
                <thead class="bg-zinc-50 text-xs font-semibold uppercase tracking-wider text-zinc-700 border-b border-zinc-200">
                    <tr>
                        <th class="px-6 py-4">Cliente</th>
                        <th class="px-6 py-4">E-mail</th>
                        <th class="px-6 py-4">NIF</th>
                        <th class="px-6 py-4">Estado</th>
                        <th class="px-6 py-4 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 bg-white">
                    @forelse($clients as $client)
                    <tr class="hover:bg-zinc-50 transition">

                        {{-- Nome e Foto --}}
                        <td class="whitespace-nowrap px-6 py-4 font-medium text-zinc-900">
                            <div class="flex items-center gap-3">
                                <img src="{{ $client->getPhotoFullUrlAttribute() }}" alt="Avatar" class="h-10 w-10 rounded-full border border-zinc-200 bg-zinc-100" />
                                <span>{{ $client->name }}</span>
                            </div>
                        </td>

                        {{-- E-mail --}}
                        <td class="whitespace-nowrap px-6 py-4 text-zinc-600">
                            {{ $client->email }}
                        </td>

                        {{-- NIF --}}
                        <td class="whitespace-nowrap px-6 py-4 text-zinc-600">
                            {{ $client->customer->nif ?? 'N/D' }}
                        </td>

                        {{-- Estado --}}
                        <td class="whitespace-nowrap px-6 py-4">
                            @if($client->blocked)
                            <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-red-600/10">Bloqueado</span>
                            @else
                            <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/20">Ativo</span>
                            @endif
                        </td>

                        {{-- Ações com URLs Diretos --}}
                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-2">

                                {{-- Ver Detalhes (/clients/ID) --}}
                                <a href="/clients/{{ $client->id }}"
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-zinc-200 bg-white transition hover:bg-zinc-100 shadow-sm"
                                    title="Ver Perfil de {{ $client->name }}">
                                    <img src="/img/edit.png" alt="Ver" class="h-4 w-4" />
                                </a>

                                {{-- Bloquear (/clients/ID/block) --}}
                                <form method="POST" action="/clients/{{ $client->id }}/block" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-zinc-200 bg-white transition hover:bg-zinc-100 shadow-sm"
                                        title="{{ $client->blocked ? 'Desbloquear' : 'Bloquear' }} Cliente">
                                        @if($client->blocked)
                                        <img src="/img/unlock.png" alt="Desbloquear" class="h-4 w-4" />
                                        @else
                                        <img src="/img/padlock.png" alt="Bloquear" class="h-4 w-4" />
                                        @endif
                                    </button>
                                </form>

                                {{-- Eliminar (/clients/ID) --}}
                                <form method="POST" action="/clients/{{ $client->id }}" class="inline"
                                    onsubmit="return confirm('Tem a certeza que deseja eliminar a conta do cliente {{ $client->name }}?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-red-100 bg-red-50 transition hover:bg-red-100 shadow-sm"
                                        title="Eliminar Cliente">
                                        <img src="/img/close.png" alt="Eliminar" class="h-4 w-4" />
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-sm text-zinc-500 bg-zinc-50">
                            Nenhum cliente encontrado no sistema.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($clients, 'hasPages') && $clients->hasPages())
        <div class="border-t border-zinc-200 px-6 py-4 bg-zinc-50">
            {{ $clients->links() }}
        </div>
        @endif
    </div>
</div>
@endcomponent