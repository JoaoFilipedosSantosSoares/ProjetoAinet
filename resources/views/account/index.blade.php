@component('layouts.main-content')
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

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="rounded-2xl border border-zinc-300 px-4 py-3 text-sm font-semibold text-zinc-900 transition hover:bg-zinc-100">
                    Sair da conta
                </button>
            </form>

        </div>


        <div class="space-y-6">
            <section id="profile-panel" class="space-y-6">
                <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm">
                    <div class="flex flex-col gap-4 border-b border-zinc-200 p-6 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-foreground">Informações Pessoais</h2>
                            <p class="text-muted-foreground">Os teus dados e preferências para futuras encomendas</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button type="submit" class="rounded-2xl bg-zinc-950 px-4 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800">Guardar</button>
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

        </div>
    </div>
    </div>
</main>

@endcomponent