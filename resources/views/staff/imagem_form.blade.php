@component('layouts.main-content')
<div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
    
    <div class="mb-6">
        <a href="{{ route('staff.gestao') }}" class="inline-flex items-center gap-2 text-sm font-medium text-zinc-600 hover:text-zinc-950 transition">
            ← Voltar para a Gestão
        </a>
    </div>

    <div class="mb-8 border-b border-zinc-200 pb-4">
        <h1 class="text-2xl font-bold tracking-tight text-zinc-900 sm:text-3xl">
            {{ $tshirtImage->exists ? 'Editar Imagem do Catálogo' : 'Adicionar Nova Imagem ao Catálogo' }}
        </h1>
        <p class="mt-2 text-sm text-zinc-600">
            {{ $tshirtImage->exists ? "Atualiza as informações de {$tshirtImage->name}." : 'Disponibiliza um novo design oficial na FunShirt.' }}
        </p>
    </div>

    <div class="grid gap-8 {{ $tshirtImage->exists ? 'md:grid-cols-3' : 'grid-cols-1' }}">
        
        @if($tshirtImage->exists)
        <div class="md:col-span-1 space-y-4">
            <div class="block text-xs font-semibold uppercase tracking-wider text-zinc-700">Design Atual</div>
            <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 flex items-center justify-center shadow-sm">
                <img src="{{ asset('storage/tshirt_images/' . $tshirtImage->image_url) }}" 
                    alt="{{ $tshirtImage->name }}" class="max-h-64 object-contain rounded-xl" />
            </div>
        </div>
        @endif

        <div class="{{ $tshirtImage->exists ? 'md:col-span-2' : 'max-w-3xl mx-auto w-full' }} rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
            
            <form method="POST" 
                  action="{{ $tshirtImage->exists ? route('staff.gestao.update', $tshirtImage) : route('staff.gestao.store') }}" 
                  enctype="multipart/form-data" 
                  class="space-y-6">
                
                @csrf
                @if($tshirtImage->exists)
                    @method('PUT')
                @endif

                <div>
                    <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-zinc-700 mb-2">Nome do Design *</label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $tshirtImage->name) }}" placeholder="Ex: Caveira Rock, Sunset Vibes..."
                        class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2.5 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none">
                </div>

                <div>
                    <label for="category_id" class="block text-xs font-semibold uppercase tracking-wider text-zinc-700 mb-2">Categoria *</label>
                    <select name="category_id" id="category_id" required
                        class="w-full rounded-xl border border-zinc-300 bg-white px-3 py-2.5 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none">
                        <option value="">Selecione uma categoria...</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $tshirtImage->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-zinc-700 mb-2">Descrição (Opcional)</label>
                    <textarea name="description" id="description" rows="3" placeholder="Breve texto sobre a estampa..."
                        class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2.5 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none">{{ old('description', $tshirtImage->description) }}</textarea>
                </div>

                <div>
                    <label for="image_file" class="block text-xs font-semibold uppercase tracking-wider text-zinc-700 mb-2">
                        {{ $tshirtImage->exists ? 'Substituir Imagem (Deixar vazio para manter a atual)' : 'Ficheiro da Imagem (Máx: 2MB) *' }}
                    </label>
                    <input type="file" id="image_file" name="image_file" {{ $tshirtImage->exists ? '' : 'required' }} accept="image/*"
                        class="w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-zinc-100 file:text-zinc-700 hover:file:bg-zinc-200 file:cursor-pointer">
                </div>

                <div class="flex justify-end gap-3 border-t border-zinc-100 pt-6">
                    <a href="{{ route('staff.gestao') }}" class="rounded-xl border border-zinc-300 bg-white px-4 py-2.5 text-sm font-semibold text-zinc-700 hover:bg-zinc-50 transition">
                        Cancelar
                    </a>
                    <button type="submit" class="rounded-xl bg-zinc-950 px-5 py-2.5 text-sm font-semibold text-white hover:bg-zinc-800 transition shadow-sm">
                        {{ $tshirtImage->exists ? 'Guardar Alterações' : 'Criating Estampa' }}
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endcomponent