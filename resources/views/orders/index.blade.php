@component('layouts.main-content', ['type' => 'Encomendas'])
<main class="min-h-screen bg-background">
    <div class="container mx-auto px-4 py-12">
        <div
            class="mb-8 flex flex-col gap-4 rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-foreground">Encomendas Pendentes</h1>
                <p class="text-muted-foreground">Aqui estão as encomendas que ainda precisam de estampagem e envio.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('catalog.index') }}"
                    class="rounded-2xl border border-zinc-300 bg-white px-4 py-3 text-sm font-semibold text-zinc-900 transition hover:bg-zinc-100">Ver
                    Catálogo</a>

            </div>
        </div>

        <form method="GET" action="{{ route('orders.index') }}"
            class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center">
            <label class="sr-only" for="search">Pesquisar por ID</label>
            <input id="search" name="search" type="text" value=""
                placeholder="Pesquisar encomenda por ID"
                class="w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 sm:max-w-md" />
            <button type="submit"
                class="inline-flex justify-center rounded-2xl bg-zinc-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800">Pesquisar</button>
        </form>

        <div class="space-y-6">
            @each('orders.partials.cards', $orders, 'order')
        </div>

        <div class="mt-6">
            {{ $orders->links('pagination::tailwind') }}
        </div>
    </div>
</main>
@endcomponent