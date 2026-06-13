<div class="rounded-3xl border border-zinc-200 bg-white shadow-sm">
    <div class="flex flex-col gap-4 border-b border-zinc-200 p-6 sm:flex-row sm:items-center sm:justify-between">
        <div>
            @php
                $statusText = match ($order->status) {
                    'pending' => 'Pendente',
                    'closed' => 'Concluída',
                    'canceled' => 'Cancelada',
                    default => ucfirst($order->status)
                };

                $badgeClasses = match ($order->status) {
                    'pending' => 'bg-amber-100 text-amber-800',
                    'closed' => 'bg-emerald-100 text-emerald-800',
                    'canceled' => 'bg-red-100 text-red-800',
                    default => 'bg-zinc-100 text-zinc-800'
                };
            @endphp

            <p class="text-sm uppercase tracking-[0.2em] text-muted-foreground">
                Pedido: {{ $statusText }}
            </p>
            <h2 class="text-xl font-semibold text-foreground">Encomenda #{{ $order->id }}</h2>
            <p class="mt-2 text-sm text-muted-foreground">
                Cliente: {{ $order->customer->user?->name ?? 'Cliente Eliminado' }}
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $badgeClasses }}">
                {{ $statusText }}
            </span>
            <span class="text-sm font-semibold text-zinc-900">€{{ number_format($order->total_price, 2) }}</span>
        </div>
    </div>

    <div class="grid gap-4 p-6 sm:grid-cols-[1.2fr_0.8fr]">
        <div class="space-y-4">
            <div class="rounded-3xl border border-zinc-200 bg-zinc-50 p-4">
                @foreach ($order->order_items as $item)
    <div class="mb-4">
        @if(isset($item->tshirt_image->customer_id))
            <img src="{{ route('tshirt_images.show', ['filename' => $item->tshirt_image->image_url]) }}"
                alt="{{ $item->tshirt_image->name ?? 'T-shirt personalizada' }}"
                class="mb-2 h-32 w-32 rounded-lg object-cover" />
        @else
            <img src="{{ asset('storage/tshirt_images/' . ($item->tshirt_image->image_url ?? 'default.png')) }}"
                alt="{{ $item->tshirt_image->name ?? 'Imagem Apagada' }}"
                class="mb-2 h-32 w-32 rounded-lg object-cover" />
        @endif

        <p class="mt-1 text-sm text-muted-foreground">
            Tamanho: {{ $item->size }} · 
            Quantidade: {{ $item->qty ?? $item->quantity }} · 
            P. unitário: {{ number_format($item->unit_price, 2, ',', '.') }}€
        </p>
    </div>
@endforeach
                <p class="mt-2 text-sm font-medium text-zinc-900">Sub-total:
                    €{{ number_format($order->total_price, 2) }}</p>
            </div>
        </div>

        <div class="space-y-4">
            <div class="rounded-3xl border border-zinc-200 bg-white p-4 shadow-sm">
                <div class="space-y-2">
                    <p class="text-sm text-muted-foreground">Notas</p>
                    <p class="rounded-2xl bg-zinc-50 p-4 text-sm text-zinc-700">
                        {{ $order->notes ?? 'Sem observações.' }}</p>
                </div>
            </div>
            @if ($order->status === 'canceled')
                <div class="rounded-3xl border border-zinc-200 bg-white p-4 shadow-sm">
                    <div class="space-y-2">
                        <p class="text-sm text-muted-foreground">Motivo da Anulação</p>
                        <p class="rounded-2xl bg-zinc-50 p-4 text-sm text-zinc-700">
                            {{ $order->reason_for_cancellation ?? 'Sem observações.' }}</p>
                    </div>
                </div>
            @endif

            @if($order->receipt_url)
                <a href="{{ route('orders.receipt', $order) }}"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-zinc-300 bg-white px-5 py-3 text-sm font-semibold text-zinc-700 shadow-sm transition hover:bg-zinc-50 focus:outline-none">
                    <svg class="h-4 w-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Descarregar Recibo PDF
                </a>
            @else
                <div class="text-center text-xs text-zinc-400 italic py-2">
                    Nenhum recibo PDF associado a esta encomenda.
                </div>
            @endif

            @if(in_array($order->status, ['pending']))
                <form action="{{ route('orders.update', $order) }}" method="POST" class="space-y-3 rounded-3xl">
                    @csrf
                    @method('PATCH')

                    <input type="hidden" name="status" value="closed">

                    <button type="submit"
                        class="inline-flex w-full items-center justify-center rounded-2xl bg-[#144226] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#0e2f1b]">
                        Marcar como Concluída
                    </button>
                </form>
                @if(auth()->user()->user_type === 'A')
                    <button type="button" onclick="openCancelModal({{ $order->id }})"
                        class="inline-flex w-full items-center justify-center rounded-2xl border border-red-200 bg-red-50 px-5 py-3 text-sm font-semibold text-red-700 transition hover:bg-red-100 shadow-sm">
                        Anular / Cancelar Encomenda
                    </button>
                @endif
            @endif
        </div>
    </div>
</div>