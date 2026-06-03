@component('layouts.main-content', ['title' => 'A Minha Conta'])
@php
$user = $user ?? auth()->user();
$orders = $orders ?? [];
$logoutUrl = \Illuminate\Support\Facades\Route::has('logout') ? route('logout') : url('/sair');
$accountUpdateUrl = \Illuminate\Support\Facades\Route::has('account.update') ? route('account.update') : url('/conta');
$hasUpdateRoute = \Illuminate\Support\Facades\Route::has('account.update');
$profileName = old('name', data_get($user, 'name', ''));
$profileNif = old('nif', data_get($user, 'nif', ''));
$profilePaymentMethod = old('paymentMethod', data_get($user, 'paymentMethod', ''));
$profileShippingAddress = old('shippingAddress', data_get($user, 'shippingAddress', ''));
@endphp

<main class="min-h-screen bg-background">
    <div class="container mx-auto px-4 py-12">
        <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-foreground">A Minha Conta</h1>
                <p class="text-muted-foreground">Gere o teu perfil e encomendas</p>
            </div>

            @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="rounded-2xl border border-zinc-300 px-4 py-3 text-sm font-semibold text-zinc-900 transition hover:bg-zinc-100">
                    Sair da conta
                </button>
            </form>
            @else
            <form action="{{ route('account.login') }}" method="POST" class="space-y-4">
                @csrf
                <button type="submit" class="w-full rounded-2xl border border-zinc-300  px-4 py-3 text-sm font-semibold text-zinc-900 hover:bg-zinc-100">Entrar</button>
            </form>
            @endauth

        </div>

        <div class="space-y-6">
            <div class="flex flex-col gap-2 rounded-3xl border border-zinc-200 bg-white p-4 shadow-sm sm:p-6">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-2 text-sm font-semibold text-zinc-900">
                        <span class="rounded-full bg-zinc-100 px-3 py-1">Perfil</span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" class="tab-button rounded-2xl border border-zinc-300 bg-zinc-950 px-4 py-3 text-sm font-semibold text-white transition" data-tab="profile">Perfil</button>
                        <button type="button" class="tab-button rounded-2xl border border-zinc-300 bg-white px-4 py-3 text-sm font-semibold text-zinc-900 transition" data-tab="orders">Encomendas ({{ count($orders) }})</button>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <section id="profile-panel" class="space-y-6">
                    <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm">
                        <div class="flex flex-col gap-4 border-b border-zinc-200 p-6 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h2 class="text-xl font-semibold text-foreground">Informações Pessoais</h2>
                                <p class="text-muted-foreground">Os teus dados para futuras encomendas</p>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <button type="button" id="edit-profile-button" class="rounded-2xl border border-zinc-300 bg-white px-4 py-3 text-sm font-semibold text-zinc-900 transition hover:bg-zinc-100">Editar</button>
                                <button type="button" id="cancel-edit-button" class="hidden rounded-2xl border border-zinc-300 bg-white px-4 py-3 text-sm font-semibold text-zinc-900 transition hover:bg-zinc-100">Cancelar</button>
                                <button type="submit" form="profile-form" id="save-profile-button" class="hidden rounded-2xl bg-zinc-950 px-4 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800">Guardar</button>
                            </div>
                        </div>

                        <form id="profile-form" action="{{ $accountUpdateUrl }}" method="{{ $hasUpdateRoute ? 'POST' : 'POST' }}" class="space-y-6 p-6">
                            @if ($hasUpdateRoute)
                            @csrf
                            @method('PATCH')
                            @endif

                            <div class="grid gap-6 md:grid-cols-2">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-zinc-900">Nome Completo</label>
                                    <div class="relative">
                                        <input
                                            type="text"
                                            name="name"
                                            value="{{ $profileName }}"
                                            readonly
                                            data-editable="true"
                                            class="profile-input w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 pr-10 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" />
                                        <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-zinc-500">Nome</span>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-zinc-900">Email</label>
                                    <p class="rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 text-sm text-zinc-700">{{ data_get($user, 'email') }}</p>
                                    <p class="text-xs text-muted-foreground">O email não pode ser alterado</p>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-zinc-900">NIF</label>
                                    <div class="relative">
                                        <input
                                            type="text"
                                            name="nif"
                                            value="{{ $profileNif }}"
                                            readonly
                                            data-editable="true"
                                            maxlength="9"
                                            class="profile-input w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 pr-10 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
                                            placeholder="123456789" />
                                        <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-zinc-500">NIF</span>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-zinc-900">Método de Pagamento</label>
                                    <div class="relative">
                                        <input
                                            type="text"
                                            name="paymentMethod"
                                            value="{{ $profilePaymentMethod }}"
                                            readonly
                                            data-editable="true"
                                            class="profile-input w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 pr-10 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
                                            placeholder="IBAN ou MB Way" />
                                        <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-zinc-500">Pag.</span>
                                    </div>
                                </div>

                                <div class="space-y-2 md:col-span-2">
                                    <label class="block text-sm font-medium text-zinc-900">Morada de Envio</label>
                                    <div class="relative">
                                        <input
                                            type="text"
                                            name="shippingAddress"
                                            value="{{ $profileShippingAddress }}"
                                            readonly
                                            data-editable="true"
                                            class="profile-input w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 pr-10 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
                                            placeholder="Rua, número, código postal, cidade" />
                                        <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-zinc-500">Morada</span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>

                <section id="orders-panel" class="hidden space-y-6">
                    @if (count($orders) === 0)
                    <div class="rounded-3xl border border-zinc-200 bg-white p-10 text-center shadow-sm">
                        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-zinc-100 text-zinc-700">
                            🧾
                        </div>
                        <h2 class="text-2xl font-semibold text-foreground">Ainda não tens encomendas</h2>
                        <p class="mt-3 text-muted-foreground">As tuas encomendas aparecerão aqui</p>
                        <a href="{{ url('/catalogo') }}" class="mt-8 inline-flex rounded-2xl bg-zinc-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800">Explorar Catálogo</a>
                    </div>
                    @else
                    <div class="space-y-4">
                        @foreach ($orders as $order)
                        <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm">
                            <div class="flex flex-col gap-4 border-b border-zinc-200 p-6 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-base font-semibold text-foreground">Encomenda #{{ \Illuminate\Support\Str::limit((string) data_get($order, 'id', ''), 8, '') }}</p>
                                    <p class="text-sm text-muted-foreground">
                                        {{ data_get($order, 'createdAt') ? \Illuminate\Support\Carbon::parse(data_get($order, 'createdAt'))->format('d/m/Y') : '' }}
                                    </p>
                                </div>
                                <div>
                                    @if (data_get($order, 'status') === 'pending')
                                    <span class="inline-flex items-center rounded-full border border-zinc-300 px-3 py-1 text-xs font-semibold text-zinc-700">Pendente</span>
                                    @elseif (data_get($order, 'status') === 'closed')
                                    <span class="inline-flex items-center rounded-full bg-emerald-500 px-3 py-1 text-xs font-semibold text-white">Concluída</span>
                                    @elseif (data_get($order, 'status') === 'canceled')
                                    <span class="inline-flex items-center rounded-full bg-rose-500 px-3 py-1 text-xs font-semibold text-white">Cancelada</span>
                                    @else
                                    <span class="inline-flex items-center rounded-full bg-zinc-100 px-3 py-1 text-xs font-semibold text-zinc-700">{{ ucfirst(data_get($order, 'status', '')) }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="space-y-4 p-6">
                                @foreach (data_get($order, 'items', []) as $item)
                                <div class="flex items-center justify-between text-sm text-zinc-700">
                                    <span>{{ data_get($item, 'imageName', 'Produto') }} - {{ data_get($item, 'color', '') }} - {{ data_get($item, 'size', '') }} x{{ data_get($item, 'quantity', 1) }}</span>
                                    <span>{{ number_format(data_get($item, 'totalPrice', 0), 2, ',', '.') }}€</span>
                                </div>
                                @endforeach

                                <div class="flex items-center justify-between border-t border-zinc-200 pt-2 font-medium">
                                    <span>Total</span>
                                    <span class="text-primary">{{ number_format(data_get($order, 'total', 0), 2, ',', '.') }}€</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </section>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-button');
        const profilePanel = document.getElementById('profile-panel');
        const ordersPanel = document.getElementById('orders-panel');
        const editButton = document.getElementById('edit-profile-button');
        const cancelButton = document.getElementById('cancel-edit-button');
        const saveButton = document.getElementById('save-profile-button');
        const editableFields = document.querySelectorAll('[data-editable="true"]');
        const form = document.getElementById('profile-form');

        function setActiveTab(tab) {
            tabButtons.forEach(button => {
                const isActive = button.dataset.tab === tab;
                button.classList.toggle('bg-zinc-950', isActive);
                button.classList.toggle('text-white', isActive);
                button.classList.toggle('bg-white', !isActive);
                button.classList.toggle('text-zinc-900', !isActive);
            });
            profilePanel.classList.toggle('hidden', tab !== 'profile');
            ordersPanel.classList.toggle('hidden', tab !== 'orders');
        }

        function setEditing(enabled) {
            editableFields.forEach(field => {
                field.readOnly = !enabled;
                field.classList.toggle('bg-white', enabled);
                field.classList.toggle('bg-zinc-50', !enabled);
            });
            editButton.classList.toggle('hidden', enabled);
            cancelButton.classList.toggle('hidden', !enabled);
            saveButton.classList.toggle('hidden', !enabled);
        }

        tabButtons.forEach(button => {
            button.addEventListener('click', () => setActiveTab(button.dataset.tab));
        });

        if (editButton) {
            editButton.addEventListener('click', () => setEditing(true));
        }

        if (cancelButton) {
            cancelButton.addEventListener('click', () => {
                setEditing(false);
                form.reset();
            });
        }

        setActiveTab('profile');
        setEditing(false);
    });
</script>
@endcomponent