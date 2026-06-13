@component('layouts.main-content', ['type' => 'Persona'])
<main class="min-h-screen bg-background">
    <div class="container mx-auto px-4 py-12">
        
        <div class="mx-auto max-w-xl rounded-3xl border border-zinc-200 bg-white p-8 shadow-sm">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-foreground">Editar Detalhes do Design</h1>
                <p class="text-sm text-muted-foreground">Altera o nome ou a descrição da estampa selecionada.</p>
            </div>

            {{-- PREVIEW DA IMAGEM QUE ESTÁ A SER EDITADA --}}
            <div class="mb-6 flex justify-center rounded-2xl bg-zinc-50 p-4 border border-zinc-100">
                <img src="{{ route('tshirt_images.show', ['filename' => $image->image_url]) }}" 
                     alt="{{ $image->name }}" 
                     class="max-h-48 object-contain rounded-lg">
            </div>

            {{-- FORMULÁRIO DE ATUALIZAÇÃO --}}
            <form action="{{ route('customization.update', $image->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- CAMPO: NOME --}}
                <div class="space-y-1.5">
                    <label for="name" class="text-xs font-bold uppercase tracking-wider text-zinc-700">
                        Nome do Design
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $image->name) }}"
                        class="w-full rounded-2xl border border-zinc-200 bg-white p-3.5 text-sm text-zinc-900 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 transition outline-none" required />
                    @error('name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- CAMPO: DESCRIÇÃO --}}
                <div class="space-y-1.5">
                    <label for="description" class="text-xs font-bold uppercase tracking-wider text-zinc-700">
                        Descrição / Detalhes
                    </label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full rounded-2xl border border-zinc-200 bg-white p-4 text-sm text-zinc-900 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 transition outline-none resize-none">{{ old('description', $image->description) }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- BOTÕES DE SUBMISSÃO E CANCELAMENTO --}}
                <div class="flex gap-3 pt-2">
                    <a href="{{ route('customization.index', ['design' => $image->id]) }}" 
                       class="inline-flex flex-1 justify-center rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-50">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="inline-flex flex-1 justify-center rounded-2xl bg-zinc-950 px-4 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800">
                        Guardar Alterações
                    </button>
                </div>
            </form>
        </div>

    </div>
</main>
@endcomponent