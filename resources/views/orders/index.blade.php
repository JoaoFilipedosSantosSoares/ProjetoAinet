@component('layouts.main-content', ['type' => 'Encomendas'])
<main class="min-h-screen bg-background">
    <div class="container mx-auto px-4 py-12">
        <div
            class="mb-8 flex flex-col gap-4 rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-foreground">Encomendas</h1>
                <p class="text-muted-foreground">Aqui estão as encomendas que ainda precisam de estampagem e envio.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('catalog.index') }}"
                    class="rounded-2xl border border-zinc-300 bg-white px-4 py-3 text-sm font-semibold text-zinc-900 transition hover:bg-zinc-100">Ver
                    Catálogo</a>

            </div>
        </div>

        <form method="GET" action="{{ route('orders.index') }}"
            class="mb-6 flex flex-col gap-4 bg-white p-4 rounded-2xl border border-zinc-200 shadow-sm md:flex-row md:items-end">

            {{-- Filtro 1: Pesquisa por ID (Visível para os dois) --}}
            <div class="flex flex-col gap-1.5 flex-1">
                <label class="text-xs font-bold text-zinc-700 uppercase tracking-wider" for="search">ID
                    Encomenda</label>
                <input id="search" name="search" type="text" value="{{ request('search') }}" placeholder="Ex: 1420"
                    class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-zinc-400 focus:bg-white" />
            </div>

            {{-- CONDICIONAL: Filtros exclusivos para Administrador --}}
            @can('admin')
            {{-- Filtro 2: Estado da Encomenda --}}
            <div class="flex flex-col gap-1.5 w-full md:w-48">
                <label class="text-xs font-bold text-zinc-700 uppercase tracking-wider" for="status">Estado</label>
                <select id="status" name="status"
                    class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-zinc-400 focus:bg-white cursor-pointer">
                    <option value="">Todos os Estados</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendente (Pending)
                    </option>
                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Concluída (Closed)
                    </option>
                    <option value="canceled" {{ request('status') === 'canceled' ? 'selected' : '' }}>Cancelada (Canceled)
                    </option>
                </select>
            </div>

            {{-- Filtro 3: Quem encomendou (Nome/Email) --}}
            <div class="flex flex-col gap-1.5 flex-1">
                <label class="text-xs font-bold text-zinc-700 uppercase tracking-wider" for="customer">Cliente</label>
                <input id="customer" name="customer" type="text" value="{{ request('customer') }}"
                    placeholder="Nome ou e-mail do cliente..."
                    class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-zinc-400 focus:bg-white" />
            </div>
            @endcan

            {{-- Botões de Ação --}}
            <div class="flex gap-2 w-full md:w-auto">
                <button type="submit"
                    class="flex-1 md:flex-initial inline-flex justify-center items-center rounded-xl bg-zinc-950 px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-zinc-800 h-10 shadow-sm">
                    Filtrar
                </button>
                <a href="{{ route('orders.index') }}"
                    class="flex-1 md:flex-initial inline-flex justify-center items-center rounded-xl border border-zinc-300 bg-white px-6 py-2.5 text-sm font-semibold text-zinc-900 transition hover:bg-zinc-100 h-10">
                    Limpar
                </a>
            </div>
        </form>

        <div class="space-y-6">
            @each('orders.partials.cards', $orders, 'order')
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
</main>

@if(auth()->user()->user_type === 'A')
<div id="cancelOrderModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-zinc-950/40 p-4 backdrop-blur-sm">
    <div class="w-full max-w-md rounded-3xl border border-zinc-200 bg-white p-6 shadow-xl">
        <div class="flex flex-col gap-1.5 border-b border-zinc-100 pb-3">
            <h3 class="text-xl font-bold text-zinc-900">Anular Encomenda <span id="modalOrderId"></span></h3>
            <p class="text-xs text-muted-foreground">Esta ação irá alterar permanentemente o estado da encomenda para cancelada.</p>
        </div>

        <form id="cancelOrderForm" method="POST" class="mt-4 space-y-4">
            @csrf
            @method('PATCH')

            <input type="hidden" name="status" value="canceled">

            <div class="flex flex-col gap-1.5">
                <label for="cancel_reason" class="text-xs font-bold text-zinc-700 uppercase tracking-wider">Motivo da Anulação (Opcional)</label>
                <textarea id="cancel_reason" name="reason_for_cancellation" rows="3"
                    placeholder="Indique a razão do cancelamento..."
                    class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-zinc-400 focus:bg-white"></textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeCancelModal()"
                    class="flex-1 inline-flex justify-center items-center rounded-xl border border-zinc-300 bg-white px-4 py-2.5 text-sm font-semibold text-zinc-900 transition hover:bg-zinc-100 h-11">
                    Voltar atrás
                </button>
                <button type="submit"
                    class="flex-1 inline-flex justify-center items-center rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700 h-11 shadow-sm">
                    Confirmar Anulação
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCancelModal(orderId) {
        const modal = document.getElementById('cancelOrderModal');
        const form = document.getElementById('cancelOrderForm');
        const titleSpan = document.getElementById('modalOrderId');
        
        form.action = `/orders/${orderId}`; 
        titleSpan.innerText = `#${orderId}`;
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeCancelModal() {
        const modal = document.getElementById('cancelOrderModal');
        document.getElementById('cancel_reason').value = '';
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>
@endif
@endcomponent