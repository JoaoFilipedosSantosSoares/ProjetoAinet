@component('layouts.main-content')

<main class="min-h-screen bg-background">
    <div class="container mx-auto flex min-h-[calc(100vh-200px)] items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <div class="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm">
                <x-auth-header
                    title="Bem-vindo de volta"
                    description="Entra na tua conta para continuar" />

                <div class="p-6">

                    <form action="{{ route('login') }}" method="POST" class="space-y-4">
                        @csrf

                        <flux:input
                            name="email"
                            :label="__('Email address')"
                            :value="old('email')"
                            type="email"
                            required
                            autofocus
                            autocomplete="email"
                            placeholder="exemplo@mail.pt"
                            style="color: #000000 !important;"
                            class="rounded-lg border border-zinc-400 focus:border-black focus:ring-1 focus:ring-black" />

                        <flux:input
                            name="password"
                            :label="__('Password')"
                            type="password"
                            required
                            autocomplete="current-password"
                            :placeholder="__('Password')"
                            viewable
                            style="color: #000000 !important;"
                            class="mb-6 rounded-lg border border-zinc-400 focus:border-black focus:ring-1 focus:ring-black" />

                        <button type="submit" class="w-full rounded-md bg-zinc-950 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-zinc-800">
                            Entrar
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</main>
@endcomponent