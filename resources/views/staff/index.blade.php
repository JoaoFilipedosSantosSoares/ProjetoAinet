@component('layouts.main-content')
<div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">

    {{-- Elemento do Topo --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-zinc-900 md:text-4xl">Gestão de Equipa</h1>
            <p class="mt-2 text-sm text-zinc-600">Lista completa de todos os trabalhadores da FunShirt.</p>
        </div>
        <div>
            <button class="inline-flex items-center justify-center rounded-xl bg-zinc-950 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-zinc-800 shadow-sm">
                + Adicionar Membro
            </button>
        </div>
    </div>

    <form method="GET" action="#" class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between bg-zinc-50 p-4 rounded-2xl border border-zinc-200">
        <div class="flex flex-1 flex-col gap-4 sm:flex-row sm:items-center">
            <div class="relative flex-1">
                <input type="text" name="search" value="{{ $filterBySearch }}" placeholder="Pesquisar por nome ou e-mail..."
                    class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2 text-sm text-zinc-900 placeholder-zinc-400 focus:border-zinc-950 focus:outline-none">
            </div>

            <div class="w-full sm:w-48">
                <select name="type" class="w-full rounded-xl border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none">
                    <option value="">Todos os Cargos</option>
                    <option value="F" {{ $filterByType === 'F' ? 'selected' : '' }}>Funcionário</option>
                    <option value="A" {{ $filterByType === 'A' ? 'selected' : '' }}>Administrador</option>
                </select>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button type="submit" class="rounded-xl bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-800 transition">
                Filtrar
            </button>
        </div>
    </form>

    <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left text-sm text-zinc-500">
                <thead class="bg-zinc-50 text-xs font-semibold uppercase tracking-wider text-zinc-700 border-b border-zinc-200">
                    <tr>
                        <th class="px-6 py-4">Staff</th>
                        <th class="px-6 py-4">E-mail</th>
                        <th class="px-6 py-4">Cargo</th>
                        <th class="px-6 py-4">Estado</th>
                        <th class="px-6 py-4 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 bg-white">
                    @forelse($users as $user)
                    <tr class="hover:bg-zinc-50 transition">

                        <td class="whitespace-nowrap px-6 py-4 font-medium text-zinc-900">
                            <div class="flex items-center gap-3">
                                <img src="{{ $user->getPhotoFullUrlAttribute() }}" alt="Avatar" class="h-10 w-10 rounded-full border border-zinc-200 bg-zinc-100" />
                                <span>{{ $user->name }}</span>
                            </div>
                        </td>

                        <td class="whitespace-nowrap px-6 py-4 text-zinc-600">
                            {{ $user->email }}
                        </td>

                        <td class="whitespace-nowrap px-6 py-4">
                            @if($user->user_type === 'A')
                            <span class="inline-flex items-center rounded-md bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700 ring-1 ring-zinc-700/10">Admin</span>
                            @else
                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-zinc-700/10">Funcionário</span>
                            @endif
                        </td>

                        <td class="whitespace-nowrap px-6 py-4">
                            @if($user->blocked)
                            <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700">Bloqueado</span>
                            @else
                            <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700">Ativo</span>
                            @endif
                        </td>

                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-2">

                                <form method="POST" action="/staff/index/{{ $user->id }}/block" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-zinc-200 bg-white transition hover:bg-zinc-100 shadow-sm"
                                        title="{{ $user->blocked ? 'Desbloquear' : 'Bloquear' }} Utilizador">
                                        @if($user->blocked)
                                        <img src="/img/unlock.png" alt="Desbloquear" class="h-4 w-4" />
                                        @else
                                        <img src="/img/padlock.png" alt="Bloquear" class="h-4 w-4" />
                                        @endif
                                    </button>
                                </form>

                                <form method="POST" action="/staff/index/{{ $user->id }}" class="inline"
                                    onsubmit="return confirm('Tem a certeza que deseja eliminar o utilizador {{ $user->name }}?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-red-100 bg-red-50 transition hover:bg-red-100 shadow-sm"
                                        title="Eliminar Utilizador">
                                        <img src="/img/close.png" alt="Eliminar" class="h-4 w-4" />
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-sm text-zinc-500 bg-zinc-50">
                            Nenhum funcionário ou administrador encontrado.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="border-t border-zinc-200 px-6 py-4 bg-zinc-50">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endcomponent