@component('layouts.main-content')
@php
$accountUpdateUrl = \Illuminate\Support\Facades\Route::has('account.update') ? route('account.update') : url('/conta');
$hasUpdateRoute = \Illuminate\Support\Facades\Route::has('account.update');
$profileName = old('name', data_get($user, 'name', ''));
$profileNif = old('nif', data_get($user, 'nif', ''));
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
            @if (session('status') === 'profile-information-updated')
            <div class="mb-4 rounded-2xl bg-green-50 p-4 text-sm font-medium text-green-800 border border-green-200">
                As tuas informações de perfil foram atualizadas com sucesso!
            </div>
            @endif

            <section id="profile-panel" class="space-y-6">

                <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm">
                    <div class="flex flex-col gap-4 border-b border-zinc-200 p-6 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-foreground">Informações Pessoais</h2>
                            <p class="text-muted-foreground">Os teus dados e preferences para futuras encomendas</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button type="submit" form="profile-form" class="rounded-2xl bg-zinc-950 px-4 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800">
                                Guardar
                            </button>
                        </div>
                    </div>
                    <form id="profile-form" action="{{ route('user-profile-information.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6 p-6">
                        @csrf
                        @method('PUT')

                        <div class="mb-8 border-b border-zinc-100 pb-6">
                            <label class="block text-sm font-medium text-zinc-900 mb-4">Foto de Perfil</label>
                            <div class="flex items-center gap-6">
                                <div class="relative h-24 w-24 overflow-hidden rounded-full border border-zinc-200 bg-zinc-100">
                                    @if(auth()->user()->photo_url)
                                    <img src="{{ auth()->user()->getPhotoFullUrlAttribute() }}" alt="Foto de perfil" class="h-full w-full object-cover">
                                    @else
                                    <div class="flex h-full w-full items-center justify-center text-zinc-400">
                                        <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    @endif
                                </div>

                                <div class="space-y-1">
                                    <input
                                        type="file"
                                        name="photo"
                                        id="photo"
                                        accept="image/*"
                                        class="text-sm text-zinc-500 file:mr-4 file:rounded-2xl file:border-0 file:bg-zinc-950 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white file:transition hover:file:bg-zinc-800" />
                                    <p class="text-xs text-muted-foreground">PNG, JPG ou WEBP até 2MB.</p>

                                    @error('photo', 'updateProfileInformation')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-zinc-900">Nome Completo</label>
                                <div class="relative">
                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ old('name', auth()->user()->name) }}"
                                        data-editable="true"
                                        class="profile-input w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 pr-10 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" />
                                </div>
                                @error('name', 'updateProfileInformation')
                                <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-zinc-900">Email</label>
                                <input
                                    type="text"
                                    name="email"
                                    value="{{ old('name', auth()->user()->email) }}"
                                    readonly
                                    data-editable="true"
                                    class="profile-input w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 pr-10 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" />
                                <p class="text-xs text-muted-foreground">O email não pode ser alterado</p>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-zinc-900">NIF</label>
                                <div class="relative">
                                    <input
                                        type="text"
                                        name="nif"
                                        value="{{ old('nif', auth()->user()->customer?->nif) }}"
                                        data-editable="true"
                                        maxlength="9"
                                        class="profile-input w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 pr-10 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
                                        placeholder="123456789" />
                                </div>
                                @error('nif', 'updateProfileInformation')
                                <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-zinc-900">Método de Pagamento</label>
                                <div class="relative">
                                    <select
                                        name="paymentMethod"
                                        data-editable="true"
                                        class="profile-input w-full appearance-none rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 pr-10 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                                        <option value="" disabled {{ empty(auth()->user()->customer?->default_payment_type) ? 'selected' : '' }}>Selecione um método</option>
                                        <option value="MBway" {{ old('paymentMethod', auth()->user()->customer?->default_payment_type) == 'MBway' ? 'selected' : '' }}>MB WAY</option>
                                        <option value="Paypal" {{ old('paymentMethod', auth()->user()->customer?->default_payment_type) == 'Paypal' ? 'selected' : '' }}>PAYPAL</option>
                                        <option value="Visa" {{ old('paymentMethod', auth()->user()->customer?->default_payment_type) == 'Visa' ? 'selected' : '' }}>VISA</option>
                                    </select>

                                    <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-zinc-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                                @error('paymentMethod', 'updateProfileInformation')
                                <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-zinc-900">Referência de Pagamento</label>
                                <div class="relative">
                                    <input
                                        type="text"
                                        name="paymentRef"
                                        value="{{ old('paymentRef', auth()->user()->customer?->default_payment_ref) }}"
                                        data-editable="true"
                                        class="profile-input w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 pr-10 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
                                        placeholder="Nº Telemóvel (MB WAY), Email (PayPal) ou Cartão (VISA)" />
                                </div>
                                @error('paymentRef', 'updateProfileInformation')
                                <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-zinc-900">Morada de Envio</label>
                                <div class="relative">
                                    <input
                                        type="text"
                                        name="morada"
                                        value="{{ old('shippingAddress', auth()->user()->customer?->address) }}"
                                        data-editable="true"
                                        class="profile-input w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 pr-10 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
                                        placeholder="Rua, número, código postal, cidade" />
                                </div>
                                @error('shippingAddress', 'updateProfileInformation')
                                <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</main>
@endcomponent