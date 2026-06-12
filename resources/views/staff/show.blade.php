@extends('layouts.auth-layout', [
'title' => 'Alterar Membro de Staff',
'description' => 'Edite as informações de registo do utilizador no sistema.'
])

@section('auth-form')
<form action="{{ route('staff.update', $user) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="flex flex-col items-center text-center pb-5 border-b border-zinc-200">
        <img src="{{ $user->getPhotoFullUrlAttribute() }}" alt="Avatar" class="h-24 w-24 rounded-full border-2 border-zinc-300 bg-zinc-100 shadow-sm mb-3 object-cover" />
        <h2 class="text-xl font-bold text-zinc-900">{{ $user->name }}</h2>

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

    {{-- Campos de Edição --}}
    <div class="space-y-4">
        {{-- Nome --}}
        <div>
            <label for="name" class="block text-sm font-medium text-black mb-1.5">Nome Completo</label>
            <flux:input
                id="name"
                name="name"
                :value="old('name', $user->name)"
                type="text"
                required
                style="color: #000000 !important;"
                class="rounded-lg border border-zinc-400 focus:border-black focus:ring-1 focus:ring-black" />
            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>


        {{-- Cargo --}}
        <div>
            <label for="user_type" class="block text-sm font-medium text-black mb-1.5">Cargo</label>
            <select
                id="user_type"
                name="user_type"
                required
                class="w-full h-10 px-3 rounded-lg border border-zinc-400 bg-white text-black focus:border-black focus:ring-1 focus:ring-black text-sm"
                style="color: #000000 !important;">
                <option value="F" {{ old('user_type', $user->user_type) == 'F' ? 'selected' : '' }}>Funcionário</option>
                <option value="A" {{ old('user_type', $user->user_type) == 'A' ? 'selected' : '' }}>Administrador</option>
            </select>
            @error('user_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Género --}}
        <div>
            <label for="gender" class="block text-sm font-medium text-black mb-1.5">Género</label>
            <select
                id="gender"
                name="gender"
                required
                class="w-full h-10 px-3 rounded-lg border border-zinc-400 bg-white text-black focus:border-black focus:ring-1 focus:ring-black text-sm"
                style="color: #000000 !important;">
                <option value="M" {{ old('gender', $user->gender) == 'M' ? 'selected' : '' }}>Masculino</option>
                <option value="F" {{ old('gender', $user->gender) == 'F' ? 'selected' : '' }}>Feminino</option>
            </select>
            @error('gender') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Botões de Ação --}}
    <div class="pt-4 border-t border-zinc-200 flex flex-col gap-2">
        <button type="submit" class="w-full flex justify-center items-center rounded-md bg-zinc-950 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-zinc-800 shadow-sm">
            Gravar Alterações
        </button>

        <a href="{{ route('staff.index') }}" class="w-full flex justify-center items-center rounded-md border border-zinc-300 bg-white px-4 py-2.5 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-50">
            Cancelar e Voltar
        </a>
    </div>
</form>
@endsection