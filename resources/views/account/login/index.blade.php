@component('layouts.main-content')

<main class="min-h-screen bg-background">
    <div class="container mx-auto flex min-h-[calc(100vh-200px)] items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <div class="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm">
                <x-auth-header
                    title="Bem-vindo de volta"
                    description="Entra na tua conta para continuar" />

                <div class="p-6">


                    <form action="{{ route('login') }}" method="POST" class="se-y-4">
                        @csrf


                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-zinc-900">Email</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400">✉️</span>
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email') }}"
                                    placeholder="o.teu@email.com"
                                    required
                                    class="w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 pl-10 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="relative">
                                <flux:input
                                    name="password"
                                    :label="__('Password')"
                                    type="password"
                                    required
                                    autocomplete="current-password"
                                    :placeholder="__('Password')"
                                    viewable />
                            </div>
                        </div>

                        <button type="submit" class="w-full rounded-2xl bg-zinc-950 px-4 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800">Entrar</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.querySelector('.password-input');
        const toggleButton = document.querySelector('.password-toggle');

        if (!passwordInput || !toggleButton) {
            return;
        }

        toggleButton.addEventListener('click', function() {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            toggleButton.textContent = isPassword ? '🙈' : '👁️';
            toggleButton.setAttribute('aria-label', isPassword ? 'Esconder palavra-passe' : 'Mostrar palavra-passe');
        });
    });
</script>
@endcomponent