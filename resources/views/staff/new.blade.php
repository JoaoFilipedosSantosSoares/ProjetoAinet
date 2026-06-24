@extends('layouts.auth-layout', [
'title' => 'Adicionar Membro à Equipa',
'description' => 'Registe um novo funcionário ou administrador no sistema.'
])

@section('auth-form')
<form action="{{ route('staff.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
        <label for="name" class="block text-base font-medium text-black mb-1.5">
            {{ __('Nome Completo') }}
        </label>

        <flux:input
            id="name"
            name="name"
            :value="old('name')"
            type="text"
            required
            autocomplete="name"
            placeholder="Nome do trabalhador"
            style="color: #000000 !important;"
            class="rounded-lg border border-zinc-400 focus:border-black focus:ring-1 focus:ring-black" />

        @error('name')
        <p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}</p>
        @enderror
    </div>

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
            autocomplete="email"
            placeholder="exemplo@funshirt.pt"
            style="color: #000000 !important;"
            class="rounded-lg border border-zinc-400 focus:border-black focus:ring-1 focus:ring-black" />

        @error('email')
        <p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="block text-base font-medium text-black mb-1.5">
            {{ __('Password') }}
        </label>

        <flux:input
            id="password"
            name="password"
            type="password"
            required
            autocomplete="new-password"
            placeholder="Defina uma password inicial"
            viewable
            style="color: #000000 !important;"
            class="rounded-lg border border-zinc-400 focus:border-black focus:ring-1 focus:ring-black" />

        @error('password')
        <p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="user_type" class="block text-base font-medium text-black mb-1.5">
            {{ __('Cargo / Tipo de Utilizador') }}
        </label>

        <select
            id="user_type"
            name="user_type"
            required
            class="w-full h-10 px-3 rounded-lg border border-zinc-400 bg-white text-black focus:border-black focus:ring-1 focus:ring-black focus:outline-none text-sm transition-colors"
            style="color: #000000 !important;">
            <option value="" disabled {{ old('user_type') ? '' : 'selected' }}>Selecione o cargo</option>
            <option value="F" {{ old('user_type') == 'F' ? 'selected' : '' }}>Funcionário</option>
            <option value="A" {{ old('user_type') == 'A' ? 'selected' : '' }}>Administrador</option>
        </select>

        @error('user_type')
        <p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="gender" class="block text-base font-medium text-black mb-1.5">
            {{ __('Género') }}
        </label>

        <select
            id="gender"
            name="gender"
            required
            class="w-full h-10 px-3 rounded-lg border border-zinc-400 bg-white text-black focus:border-black focus:ring-1 focus:ring-black focus:outline-none text-sm transition-colors"
            style="color: #000000 !important;">
            <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Selecione o género</option>
            <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Masculino</option>
            <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Feminino</option>
        </select>

        @error('gender')
        <p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="mt-2 w-full rounded-md bg-zinc-950 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-zinc-800">
        Gravar Membro de Staff
    </button>
</form>

<div class="w-full flex justify-center items-center mt-4">
    <flux:link class="text-zinc-600 text-base font-medium underline hover:text-zinc-700" :href="route('staff.index')">
        {{ __('Voltar para a Lista de Equipa') }}
    </flux:link>
</div>
@endsection