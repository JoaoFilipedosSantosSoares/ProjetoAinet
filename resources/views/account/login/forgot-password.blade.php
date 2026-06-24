@extends('layouts.auth-layout', [
    'title' => 'Trocar a Password?',
    'description' => 'Escreva um email para receber um link para trocar a Password'
])

@section('auth-form')
    <x-auth-session-status class="text-center mb-4" :status="session('status')" />

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
            
            @error('email')
                <p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full rounded-md bg-zinc-950 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-zinc-800">
            Enviar
        </button>
    </form>
@endsection