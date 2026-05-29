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
                <a href="{{ route('account.login') }}"
                    class="rounded-2xl bg-zinc-950 px-4 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800">Alterar
                    Senha</a>
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
            <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm">
                <div
                    class="flex flex-col gap-4 border-b border-zinc-200 p-6 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.2em] text-muted-foreground">Pedido pendente</p>
                        <h2 class="text-xl font-semibold text-foreground">Encomenda #1</h2>
                        <p class="mt-2 text-sm text-muted-foreground">
                            Cliente: mega fixe · Data: data boa
                        </p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <span
                            class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">Pendente</span>
                        <span class="text-sm font-semibold text-zinc-900">30€</span>
                    </div>
                </div>

                <div class="grid gap-4 p-6 sm:grid-cols-[1.2fr_0.8fr]">
                    <div class="space-y-4">
                        <div class="rounded-3xl border border-zinc-200 bg-zinc-50 p-4">
                            <p class="text-sm font-semibold text-foreground">imagem da tshirt</p>
                            <p class="mt-1 text-sm text-muted-foreground">Tamanho: grande · Quantidade: 10 · P.
                                unitário: 10€</p>
                            <p class="mt-2 text-sm font-medium text-zinc-900">Sub-total: 30€</p>
                        </div>
                    </div>

                    <div class="space-y-4 rounded-3xl border border-zinc-200 bg-white p-4 shadow-sm">
                        <div class="space-y-2">
                            <p class="text-sm text-muted-foreground">Notas</p>
                            <p class="rounded-2xl bg-zinc-50 p-4 text-sm text-zinc-700">sem notas</p>
                        </div>

                        <form action="1" method="POST" class="space-y-3">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="inline-flex w-full justify-center rounded-2xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700">Marcar
                                como Concluída</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endcomponent