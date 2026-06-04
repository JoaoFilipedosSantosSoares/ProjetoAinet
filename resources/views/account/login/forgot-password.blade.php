@component('layouts.main-content')

<main class="min-h-screen bg-background">
    <div class="container mx-auto flex min-h-[calc(100vh-200px)] items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <div class="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm">
                <x-auth-header
                    title="Esqueceu a Password?"
                    description="Escreva um email para receber um link para trocar a Password" />

                <div class="p-6">

                    <x-auth-session-status class="text-center" :status="session('status')" />

                    <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
                        @csrf


                        <div>
                            <label for="email" class="block text-base font-medium text-black mb-1.5">
                                {{ __('Email') }}
                            </label>

                            <flux:input
                                id="email"
                                name="email"
                                :value="old('email')"
                                type="email"
                                required
                                autofocus
                                autocomplete="email"
                                placeholder="exemplo@mail.pt"
                                style="color: #000000 !important;"
                                class="rounded-lg border border-zinc-400 focus:border-black focus:ring-1 focus:ring-black" />
                        </div>

                        <button type="submit" class="w-full rounded-md bg-zinc-950 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-zinc-800">
                            Enviar
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</main>
@endcomponent