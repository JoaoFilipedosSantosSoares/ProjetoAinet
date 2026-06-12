@component('layouts.main-content')
<div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">

    {{-- Cabeçalho da Página --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight text-zinc-900 md:text-4xl">Configurações do Sistema</h1>
        <p class="mt-2 text-sm text-zinc-600">Administração global do Catálogo, Cores, Categorias e Regras de Preços da FunShirt.</p>
    </div>

    {{-- Bloco Superior: Configuração de Preços de Referência e Descontos --}}
    <div class="mb-12 rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
        <div class="border-b border-zinc-200 pb-4 mb-6">
            <h2 class="text-lg font-bold text-zinc-900">Preços e Descontos por Quantidade</h2>
            <p class="text-xs text-zinc-500">Define o valor base de venda e as tranches de desconto aplicadas no carrinho.</p>
        </div>

        {{-- COMENTADO: Form de Preços --}}
        {{-- <form method="POST" action="#" class="grid gap-6 md:grid-cols-3"> --}}
        {{-- @csrf --}}
        {{-- @method('PUT') --}}
        <div class="grid gap-6 md:grid-cols-3">
            
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-700 mb-2">Preço Unitário Catalogo (€)</label>
                <input type="number" step="0.01" name="unit_price_catalog" value="{{ $prices->unit_price_catalog ?? '25.00' }}" 
                    class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-700 mb-2">Preço Unitário Personalizada (€)</label>
                <input type="number" step="0.01" name="unit_price_own" value="{{ $prices->unit_price_own ?? '30.00' }}" 
                    class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-700 mb-2">Quantidade p/ Desconto (Unidades)</label>
                <input type="number" name="qty_discount" value="{{ $prices->qty_discount ?? '5' }}" 
                    class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none">
            </div>

            <div class="md:col-span-3 flex justify-end">
                <button type="button" class="rounded-xl bg-zinc-950 px-4 py-2.5 text-sm font-semibold text-white hover:bg-zinc-800 transition shadow-sm">
                    Salvar Alterações de Preço
                </button>
            </div>
        </div>
        {{-- </form> --}}
    </div>

    {{-- Grelha de Duas Colunas: 1. Categorias | 2. Cores --}}
    <div class="mb-12 grid gap-8 lg:grid-cols-2">
        
        {{-- SECÇÃO: CATEGORIAS --}}
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-zinc-200 pb-4 mb-4">
                    <div>
                        <h2 class="text-lg font-bold text-zinc-900">Categorias</h2>
                        <p class="text-xs text-zinc-500">Géneros das estampas oficiais do catálogo.</p>
                    </div>
                </div>

                {{-- COMENTADO: Form Criar Categoria --}}
                {{-- <form method="POST" action="#" class="mb-4 flex gap-2"> --}}
                {{-- @csrf --}}
                <div class="mb-4 flex gap-2">
                    <input type="text" name="name" placeholder="Nova categoria (ex: Desporto)..." 
                        class="flex-1 rounded-xl border border-zinc-300 bg-white px-4 py-2 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none">
                    <button type="button" class="rounded-xl bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-800 transition">
                        +
                    </button>
                </div>
                {{-- </form> --}}

                <div class="overflow-hidden rounded-xl border border-zinc-200 max-h-64 overflow-y-auto">
                    <table class="w-full border-collapse text-left text-sm text-zinc-500">
                        <tbody class="divide-y divide-zinc-200 bg-white">
                            @forelse($categories as $category)
                            <tr class="hover:bg-zinc-50 transition">
                                <td class="px-4 py-3 font-medium text-zinc-900">{{ $category->name }}</td>
                                <td class="px-4 py-3 text-right">
                                    {{-- COMENTADO: Form Eliminar Categoria --}}
                                    {{-- <form method="POST" action="#" class="inline" onsubmit="return confirm('Eliminar esta categoria?');"> --}}
                                    {{-- @csrf --}}
                                    {{-- @method('DELETE') --}}
                                    <button type="button" class="inline-flex h-7 w-7 items-center justify-center rounded-lg border border-red-100 bg-red-50 hover:bg-red-100 transition shadow-sm">
                                        <img src="/img/close.png" alt="Eliminar" class="h-3 w-3" />
                                    </button>
                                    {{-- </form> --}}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="p-4 text-center text-xs text-zinc-400">Nenhuma categoria registada.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- SECÇÃO: CORES --}}
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-zinc-200 pb-4 mb-4">
                    <div>
                        <h2 class="text-lg font-bold text-zinc-900">Cores Disponíveis</h2>
                        <p class="text-xs text-zinc-500">Palete de cores das t-shirts de algodão base.</p>
                    </div>
                </div>

                {{-- COMENTADO: Form Criar Cor --}}
                {{-- <form method="POST" action="#" class="mb-4 grid grid-cols-3 gap-2"> --}}
                {{-- @csrf --}}
                <div class="mb-4 grid grid-cols-3 gap-2">
                    <input type="text" name="code" placeholder="Código (ex: FFF)" class="rounded-xl border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none">
                    <input type="text" name="name" placeholder="Nome (ex: Branco)" class="rounded-xl border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none">
                    <button type="button" class="rounded-xl bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-800 transition">
                        + Cor
                    </button>
                </div>
                {{-- </form> --}}

                <div class="overflow-hidden rounded-xl border border-zinc-200 max-h-64 overflow-y-auto">
                    <table class="w-full border-collapse text-left text-sm text-zinc-500">
                        <tbody class="divide-y divide-zinc-200 bg-white">
                            @forelse($colors as $color)
                            <tr class="hover:bg-zinc-50 transition">
                                <td class="px-4 py-3 font-medium text-zinc-900 flex items-center gap-3">
                                    <span class="h-5 w-5 rounded-full border border-zinc-300 shadow-xs" style="background-color: #{{ $color->code }}"></span>
                                    <span>{{ $color->name }}</span>
                                </td>
                                <td class="px-4 py-3 text-xs text-zinc-400">#{{ $color->code }}</td>
                                <td class="px-4 py-3 text-right">
                                    {{-- COMENTADO: Form Eliminar Cor --}}
                                    {{-- <form method="POST" action="#" class="inline" onsubmit="return confirm('Eliminar esta cor?');"> --}}
                                    {{-- @csrf --}}
                                    {{-- @method('DELETE') --}}
                                    <button type="button" class="inline-flex h-7 w-7 items-center justify-center rounded-lg border border-red-100 bg-red-50 hover:bg-red-100 transition shadow-sm">
                                        <img src="/img/close.png" alt="Eliminar" class="h-3 w-3" />
                                    </button>
                                    {{-- </form> --}}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="p-4 text-center text-xs text-zinc-400">Nenhuma cor registada.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- SECÇÃO: CATÁLOGO DE IMAGENS OFICIAIS --}}
    <div class="mb-4 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold text-zinc-900">Catálogo Oficial de Designs</h2>
            <p class="text-sm text-zinc-500">Imagens públicas partilhadas disponíveis para todos os clientes comprarem.</p>
        </div>
        <div>
            {{-- COMENTADO: Link para criar nova imagem --}}
            {{-- <a href="{{ route('management.catalog.create') }}" class="..."> --}}
            <button type="button" class="inline-flex items-center justify-center rounded-xl bg-zinc-950 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-zinc-800 shadow-sm">
                + Nova Imagem Catálogo
            </button>
            {{-- </a> --}}
        </div>
    </div>

    {{-- Filtro de Catálogo --}}
    {{-- COMENTADO: Form de Filtragem do Catálogo --}}
    {{-- <form method="GET" action="#" class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between bg-zinc-50 p-4 rounded-2xl border border-zinc-200"> --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between bg-zinc-50 p-4 rounded-2xl border border-zinc-200">
        <div class="flex flex-1 flex-col gap-4 sm:flex-row sm:items-center">
            <div class="relative flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Pesquisar imagem por nome ou descrição..."
                    class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2 text-sm text-zinc-900 placeholder-zinc-400 focus:border-zinc-950 focus:outline-none">
            </div>

            <div class="w-full sm:w-48">
                <select name="category_id" class="w-full rounded-xl border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none">
                    <option value="">Todas as Categorias</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button type="button" class="rounded-xl bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-800 transition">
                Filtrar Catálogo
            </button>
        </div>
    </div>
    {{-- </form> --}}

    {{-- Tabela do Catálogo --}}
    <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left text-sm text-zinc-500">
                <thead class="bg-zinc-50 text-xs font-semibold uppercase tracking-wider text-zinc-700 border-b border-zinc-200">
                    <tr>
                        <th class="px-6 py-4">Design</th>
                        <th class="px-6 py-4">Categoria</th>
                        <th class="px-6 py-4">Descrição</th>
                        <th class="px-6 py-4 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 bg-white">
                    @forelse($catalogImages as $image)
                    <tr class="hover:bg-zinc-50 transition">
                        
                        <td class="whitespace-nowrap px-6 py-4 font-medium text-zinc-900">
                            <div class="flex items-center gap-4">
                                {{-- Corrigido: Aponta exatamente para o mesmo caminho do teu catálogo público --}}
                                <img src="{{ asset('storage/tshirt_images/' . $image->image_url) }}" 
                                    alt="{{ $image->name }}" 
                                    class="h-12 w-12 rounded-xl border border-zinc-200 bg-zinc-100 object-contain" />
                                <span class="font-semibold">{{ $image->name }}</span>
                            </div>
                        </td>

                        <td class="whitespace-nowrap px-6 py-4 text-zinc-600">
                            <span class="inline-flex items-center rounded-md bg-zinc-100 px-2.5 py-0.5 text-xs font-medium text-zinc-800">
                                {{ $image->category->name ?? 'Sem Categoria' }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-zinc-500 max-w-xs truncate">
                            {{ $image->description ?? 'Sem descrição definida.' }}
                        </td>

                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-2">
                                {{-- COMENTADO: Botão Editar Metadados --}}
                                {{-- <a href="#" class="..."> --}}
                                <button type="button" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-zinc-200 bg-white transition hover:bg-zinc-100 shadow-sm" title="Editar informações">
                                    <img src="/img/edit.png" alt="Editar" class="h-4 w-4" />
                                </button>
                                {{-- </a> --}}

                                {{-- COMENTADO: Form Eliminar Imagem do Catálogo --}}
                                {{-- <form method="POST" action="#" class="inline" onsubmit="return confirm('Eliminar estampa?');"> --}}
                                {{-- @csrf --}}
                                {{-- @method('DELETE') --}}
                                <button type="button" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-red-100 bg-red-50 transition hover:bg-red-100 shadow-sm" title="Eliminar Estampa">
                                    <img src="/img/close.png" alt="Eliminar" class="h-4 w-4" />
                                </button>
                                {{-- </form> --}}
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-sm text-zinc-500 bg-zinc-50">
                            Nenhum design encontrado no catálogo oficial.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($catalogImages->hasPages())
        <div class="border-t border-zinc-200 px-6 py-4 bg-zinc-50">
            {{ $catalogImages->links() }}
        </div>
        @endif
    </div>

</div>
@endcomponent