@extends('layouts.auth-layout', [
    'title' => 'Nova Password',
    'description' => 'Escolhe e confirma a tua nova palavra-passe'
])

@section('auth-form')
    <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ request()->route('token') }}">

        {{-- Bloco do Email (Read-Only) --}}
        <div>
            <label for="email" class="block text-base font-medium text-black mb-1.5">
                {{ __('Email') }}
            </label>

            <flux:input
                id="email"
                name="email"
                value="{{ request('email') }}"
                type="email"
                readonly
                style="color: #000000 !important;"
                class="rounded-lg border border-zinc-400 focus:border-black focus:ring-1 focus:ring-black bg-zinc-50 cursor-not-allowed" />
        </div>

        <div>
            <div class="mb-4">
                <label for="password" class="block text-base font-medium text-black mb-1.5">
                    {{ __('Nova Password') }}
                </label>
                
                <flux:input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="new-password"
                    :placeholder="__('Password')"
                    viewable
                    style="color: #000000 !important;"
                    class="rounded-lg border border-zinc-400 focus:border-black focus:ring-1 focus:ring-black" />
            </div>

            <div class="mb-2">
                <label for="password_confirmation" class="block text-base font-medium text-black mb-1.5">
                    {{ __('Confirme Password') }}
                </label>

                <flux:input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    required
                    autocomplete="new-password"
                    :placeholder="__('Password')"
                    viewable
                    style="color: #000000 !important;"
                    class="rounded-lg border border-zinc-400 focus:border-black focus:ring-1 focus:ring-black" />
            </div>

            @error('password')
                <p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full rounded-md bg-zinc-950 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-zinc-800">
            Trocar Password
        </button>
    </form>
@endsection