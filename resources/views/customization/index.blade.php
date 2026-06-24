@component('layouts.main-content', ['type' => 'Persona'])
<main class="min-h-screen bg-background">
    <div class="container mx-auto px-4 py-12">
        <div class="mb-8 text-center">
            <h1 class="mb-2 text-3xl font-bold text-foreground">Cria a Tua T-Shirt</h1>
            <p class="text-muted-foreground">Carrega a tua imagem e personaliza a tua t-shirt única</p>
        </div>

        <div class="mx-auto grid max-w-5xl gap-8 lg:grid-cols-2">
            
            <div class="space-y-6">
                
                <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm">
                    <div class="p-6">
                        <h2 class="mb-4 text-lg font-semibold">Carrega a tua imagem</h2>

                        <form action="{{ route('customization.upload') }}" method="POST"
                            enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <input type="hidden" name="color" value="{{ request('color') }}">

                            <div class="flex flex-col items-center justify-center rounded-3xl border-2 border-dashed border-border bg-muted p-6">
                                <svg class="mb-4 h-12 w-12 text-muted-foreground" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M12 3v10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M8 7l4-4 4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M21 21H3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>

                                <input type="file" name="photo" id="upload-input" accept="image/*"
                                    class="text-sm text-zinc-500 file:mr-4 file:rounded-2xl file:border-0 file:bg-zinc-950 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white file:transition hover:file:bg-zinc-800"
                                    required />

                                <p class="text-xs text-muted-foreground mt-2">PNG, JPG ou WEBP até 2MB.</p>
                            </div>

                            <div class="space-y-1.5">
                                <label for="description" class="text-xs font-bold uppercase tracking-wider black">
                                    Descrição da T-shirt
                                </label>
                                <textarea name="description" id="description" rows="3"
                                    placeholder="Escreve aqui uma breve descrição ou detalhes sobre a estampa..."
                                    class="w-full rounded-2xl border border-zinc-200 bg-white p-4 text-sm text-zinc-900 placeholder-zinc-400 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 transition outline-none resize-none"></textarea>
                            </div>

                            <button type="submit"
                                class="inline-flex w-full justify-center rounded-2xl bg-zinc-950 px-4 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800">
                                Carregar Imagem e Detalhes
                            </button>
                        </form>
                    </div>
                </div>

                <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm p-6">
                    <h2 class="text-lg font-semibold mb-4">Os Teus Designs Disponíveis</h2>
                    
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3" id="product-grid">
                        @forelse ($myImages as $image)
                            <a href="{{ route('customization.index', ['tshirt' => $tshirt, 'design' => $image->id, 'color' => request('color')]) }}" class="block">
                                <div class="product-card group cursor-pointer overflow-hidden rounded-2xl bg-white border border-zinc-200 transition hover:shadow-md {{ request('design') == $image->id ? 'ring-2 ring-zinc-950 border-transparent' : '' }}"
                                    data-id="{{ $image->id }}">
                                    <div class="relative aspect-square overflow-hidden bg-zinc-50 flex items-center justify-center p-2">
                                        <img src="{{ route('tshirt_images.show', ['filename' => $image->image_url]) }}"
                                            alt="{{ $image->name }}"
                                            class="h-full w-full object-contain transition group-hover:scale-105" />
                                    </div>
                                    <div class="p-3 border-t border-zinc-100 bg-zinc-50/50">
                                        <h3 class="font-medium text-xs text-zinc-900 truncate text-center">{{ $image->name }}</h3>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="col-span-full text-center py-12 text-muted-foreground text-sm">
                                Nenhum design encontrado.
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $myImages->links() }}
                    </div>

                    <div class="mt-8 pt-6 border-t border-zinc-100">
                        <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider mb-3">Opções do Design Selecionado</p>
                        @if(request('design'))
                            <div class="grid grid-cols-2 gap-3">
                                <a href="{{ route('customization.edit', request('design')) }}" 
                                   class="inline-flex justify-center items-center gap-2 rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-50 hover:text-zinc-950 shadow-sm">
                                    Editar Nome/Desc
                                </a>
                                <form action="{{ route('customization.destroy', request('design')) }}" method="POST" onsubmit="return confirm('Tens a certeza?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex w-full justify-center items-center gap-2 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-600 transition hover:bg-red-100 shadow-sm">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="rounded-2xl bg-zinc-50 border border-zinc-200/60 p-4 text-center">
                                <p class="text-sm text-zinc-500">Clica numa das tuas imagens acima para a poderes editar ou eliminar.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm">
                    <div class="product-card group cursor-pointer overflow-hidden rounded-2xl bg-white shadow-sm transition hover:shadow-md">
                        <div class="relative aspect-square overflow-hidden bg-zinc-100 flex items-center justify-center">
                            <img id="tshirt-base-preview"
                                src="{{ asset('storage/tshirt_base/' . $selectedColor->code . '.jpg') }}"
                                alt="T-shirt Base" class="absolute inset-0 h-full w-full object-contain" />
                            @if ($tshirt && $tshirt->image_url)
                                <img src="{{ route('tshirt_images.show', ['filename' => $tshirt->image_url]) }}"
                                    alt="{{ $tshirt->name }}"
                                    class="relative z-10 h-[40%] w-[40%] object-contain transition group-hover:scale-105" />
                            @endif
                        </div>
                        <div class="p-5 border-t border-zinc-100 bg-zinc-50/30">
                            <h3 class="font-bold text-base text-zinc-900">{{ $tshirt->name }}</h3>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm p-6">
                    <h2 class="mb-6 text-lg font-semibold">Configurar Produto</h2>

                    <div x-data="{ 
                        quantity: 1,
                        basePrice: {{ $basePrice }},
                        discountPrice: {{ $discountPrice }},
                        qtyTrigger: {{ $qtyTrigger }},
                        selectedColorCode: '{{ $selectedColor->code ?? 'white' }}',
                        selectedColorName: '{{ $selectedColor->name ?? 'Branco' }}'
                    }">

                        <div class="mb-6">
                            <label class="mb-2 block text-sm font-medium text-zinc-900">
                                Cor da T-Shirt: <span class="text-zinc-500 font-normal" x-text="selectedColorName"></span>
                            </label>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($colors as $color)
                                    <button type="button"
                                        @click="selectedColorCode = '{{ $color->code }}'; selectedColorName = '{{ $color->name }}'; document.getElementById('tshirt-base-preview').src = '{{ asset('storage/tshirt_base/' . $color->code . '.jpg') }}'"
                                        class="h-10 w-10 rounded-full border-2 transition-all duration-200 focus:outline-none"
                                        :class="selectedColorCode === '{{ $color->code }}' ? 'border-zinc-950 ring-2 ring-zinc-950 ring-offset-2 scale-105' : 'border-border'"
                                        style="background-color: #{{ $color->code }}">
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <form action="{{ route('cart.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <input type="hidden" name="tshirt_image_id" value="{{ $tshirt->id }}">
                            <input type="hidden" name="color" :value="selectedColorCode">

                            <div>
                                <label for="size" class="mb-2 block text-sm font-medium text-zinc-700">Tamanho</label>
                                <select id="size" name="size" class="w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-zinc-400">
                                    <option value="S">S</option>
                                    <option value="M" selected>M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option>
                                </select>
                            </div>

                            <div>
                                <label for="quantity" class="mb-2 block text-sm font-medium text-zinc-700">Quantidade</label>
                                <input type="number" id="quantity" name="quantity" min="1" x-model.number="quantity"
                                    class="w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-zinc-400" />
                            </div>

                            <div class="rounded-2xl bg-zinc-50 p-4 border border-zinc-100">
                                <div class="space-y-2 text-sm text-zinc-600">
                                    <div class="flex justify-between">
                                        <span>Preço Unitário:</span>
                                        <span class="font-medium text-zinc-900" x-text="(quantity >= qtyTrigger ? discountPrice : basePrice).toFixed(2) + '€'"></span>
                                    </div>
                                    <div class="flex justify-between text-xs text-emerald-600 font-medium" x-show="quantity >= qtyTrigger" x-cloak>
                                        <span>Desconto de quantidade:</span>
                                        <span x-text="'-' + (basePrice - discountPrice).toFixed(2) + '€ por unidade'"></span>
                                    </div>
                                    <div class="flex justify-between border-t border-zinc-200 pt-2 text-zinc-900 font-semibold mt-3">
                                        <span class="font-medium">Total:</span>
                                        <span class="text-xl font-bold text-[#144226]" x-text="((quantity >= qtyTrigger ? discountPrice : basePrice) * (quantity || 0)).toFixed(2) + '€'"></span>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="inline-flex w-full justify-center rounded-2xl bg-zinc-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800">
                                Adicionar ao Carrinho
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endcomponent