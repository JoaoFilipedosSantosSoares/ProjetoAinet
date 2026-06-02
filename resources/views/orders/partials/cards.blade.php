<div class="rounded-3xl border border-zinc-200 bg-white shadow-sm">
    <div class="flex flex-col gap-4 border-b border-zinc-200 p-6 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm uppercase tracking-[0.2em] text-muted-foreground">Pedido {{ $order->status }}</p>
            <h2 class="text-xl font-semibold text-foreground">Encomenda #{{ $order->id }}</h2>
            <p class="mt-2 text-sm text-muted-foreground">
                Cliente: {{ $order->customer_id }}
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <span
                class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">Pendente</span>
            <span class="text-sm font-semibold text-zinc-900">€{{ number_format($order->total_price, 2) }}</span>
        </div>
    </div>

    <div class="grid gap-4 p-6 sm:grid-cols-[1.2fr_0.8fr]">
        <div class="space-y-4">
            <div class="rounded-3xl border border-zinc-200 bg-zinc-50 p-4">
                <p class="text-sm font-semibold text-foreground">imagem da tshirt</p>
                <p class="mt-1 text-sm text-muted-foreground">Tamanho: grande · Quantidade: 10 · P.
                    unitário: 10€</p>
                <p class="mt-2 text-sm font-medium text-zinc-900">Sub-total: €{{ number_format($order->total_price, 2) }}</p>
            </div>
        </div>

        <div class="space-y-4">
            <div class="rounded-3xl border border-zinc-200 bg-white p-4 shadow-sm">
                <div class="space-y-2">
                    <p class="text-sm text-muted-foreground">Notas</p>
                    <p class="rounded-2xl bg-zinc-50 p-4 text-sm text-zinc-700">{{ $order->notes }}</p>
                </div>
            </div>

            <form action="1" method="POST" class="space-y-3 rounded-3xl">
                @csrf
                @method('PATCH')
                <button type="submit" href="{{ route('orders.update', $order) }}" class="inline-flex w-full justify-center rounded-2xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700">
                    Marcar como Concluída
                </button>
            </form>
        </div>
    </div>
</div>