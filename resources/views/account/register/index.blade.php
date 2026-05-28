@component('layouts.main-content', ['title' => 'Registar'])
    @php
        $redirect = request()->query('redirect', '/');
        $registerUrl = \Illuminate\Support\Facades\Route::has('register') ? route('register') : url('/registar');
        $loginUrl = \Illuminate\Support\Facades\Route::has('login') ? route('login', ['redirect' => $redirect]) : url('/entrar' . ($redirect !== '/' ? '?redirect=' . urlencode($redirect) : ''));
    @endphp

    <main class="min-h-screen bg-background">
        <div class="container mx-auto flex min-h-[calc(100vh-200px)] items-center justify-center px-4 py-12">
            <div class="w-full max-w-md">
                <div class="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm">
                    <div class="border-b border-zinc-200 p-6 text-center">
                        <h1 class="text-2xl font-bold text-foreground">Criar Conta</h1>
                        <p class="mt-2 text-sm text-muted-foreground">Regista-te para começar a criar t-shirts incríveis</p>
                    </div>

                    <div class="p-6">
                        @if (session('error'))
                            <div class="mb-4 rounded-2xl bg-rose-50 p-4 text-sm text-rose-700">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="mb-4 rounded-2xl bg-rose-50 p-4 text-sm text-rose-700">
                                <ul class="space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ $registerUrl }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="redirect" value="{{ $redirect }}" />

                            <div class="space-y-2">
                                <label for="name" class="block text-sm font-medium text-zinc-900">Nome Completo *</label>
                                <div class="relative">
                                    <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400">👤</span>
                                    <input
                                        id="name"
                                        name="name"
                                        type="text"
                                        value="{{ old('name') }}"
                                        placeholder="O teu nome"
                                        required
                                        class="w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 pl-10 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
                                    />
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label for="email" class="block text-sm font-medium text-zinc-900">Email *</label>
                                <div class="relative">
                                    <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400">✉️</span>
                                    <input
                                        id="email"
                                        name="email"
                                        type="email"
                                        value="{{ old('email') }}"
                                        placeholder="o.teu@email.com"
                                        required
                                        class="w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 pl-10 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
                                    />
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label for="password" class="block text-sm font-medium text-zinc-900">Palavra-passe *</label>
                                <div class="relative">
                                    <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400">🔒</span>
                                    <input
                                        id="password"
                                        name="password"
                                        type="password"
                                        placeholder="Mínimo 6 caracteres"
                                        required
                                        class="password-input w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 pl-10 pr-10 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
                                    />
                                    <button
                                        type="button"
                                        class="password-toggle absolute right-3 top-1/2 -translate-y-1/2 text-zinc-500 transition hover:text-zinc-900"
                                        aria-label="Mostrar palavra-passe"
                                    >
                                        👁️
                                    </button>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label for="password_confirmation" class="block text-sm font-medium text-zinc-900">Confirmar Palavra-passe *</label>
                                <div class="relative">
                                    <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400">🔒</span>
                                    <input
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        type="password"
                                        placeholder="Repete a palavra-passe"
                                        required
                                        class="w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 pl-10 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
                                    />
                                </div>
                            </div>

                            <div class="border-t border-zinc-200 pt-4">
                                <p class="mb-3 text-sm text-muted-foreground">Campos opcionais (podes preencher mais tarde)</p>

                                <div class="space-y-4">
                                    <div class="space-y-2">
                                        <label for="nif" class="block text-sm font-medium text-zinc-900">NIF</label>
                                        <div class="relative">
                                            <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400">💳</span>
                                            <input
                                                id="nif"
                                                name="nif"
                                                type="text"
                                                value="{{ old('nif') }}"
                                                placeholder="123456789"
                                                maxlength="9"
                                                class="w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 pl-10 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
                                            />
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <label for="paymentMethod" class="block text-sm font-medium text-zinc-900">Método de Pagamento</label>
                                        <div class="relative">
                                            <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400">💳</span>
                                            <input
                                                id="paymentMethod"
                                                name="paymentMethod"
                                                type="text"
                                                value="{{ old('paymentMethod') }}"
                                                placeholder="IBAN ou referência MB Way"
                                                class="w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 pl-10 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
                                            />
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <label for="shippingAddress" class="block text-sm font-medium text-zinc-900">Morada de Envio</label>
                                        <div class="relative">
                                            <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400">📍</span>
                                            <input
                                                id="shippingAddress"
                                                name="shippingAddress"
                                                type="text"
                                                value="{{ old('shippingAddress') }}"
                                                placeholder="Rua, número, código postal, cidade"
                                                class="w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 pl-10 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="w-full rounded-2xl bg-zinc-950 px-4 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800">Criar Conta</button>
                        </form>

                        <div class="mt-6 text-center">
                            <p class="text-sm text-muted-foreground">
                                Já tens conta?
                                <a href="{{ $loginUrl }}" class="text-primary hover:underline">Entra aqui</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.querySelector('.password-input');
            const toggleButton = document.querySelector('.password-toggle');

            if (!passwordInput || !toggleButton) {
                return;
            }

            toggleButton.addEventListener('click', function () {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                toggleButton.textContent = isPassword ? '🙈' : '👁️';
                toggleButton.setAttribute('aria-label', isPassword ? 'Esconder palavra-passe' : 'Mostrar palavra-passe');
            });
        });
    </script>
@endcomponent
