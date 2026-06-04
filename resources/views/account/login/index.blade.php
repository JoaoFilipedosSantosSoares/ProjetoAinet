@extends('layouts.auth-layout', [
    'title' => 'Bem-vindo de volta!',
    'description' => 'Entra na tua conta para continuar'
])

@section('auth-form')
    <form action="{{ route('login') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-base font-medium text-black mb-1.5">
                {{ __('Email ') }}
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
            
            @error('email')
                <p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <div class="flex justify-between items-center mb-1.5">
                <label for="password" class="text-base font-medium text-black">
                    {{ __('Password') }}
                </label>

                @if (Route::has('password.request'))
                <flux:link class="text-zinc-600 text-base" :href="route('password.request')">
                    {{ __('Esqueceu a Password?') }}
                </flux:link>
                @endif
            </div>

            <flux:input
                id="password"
                name="password"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Password')"
                viewable
                style="color: #000000 !important;"
                class="rounded-lg border border-zinc-400 focus:border-black focus:ring-1 focus:ring-black" />
            
            @error('password')
                <p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="mt-2 w-full rounded-md bg-zinc-950 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-zinc-800">
            Entrar
        </button>
    </form>
@endsection