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
                        <div id="upload-dropzone"
                            class="flex min-h-75 cursor-pointer flex-col items-center justify-center rounded-3xl border-2 border-dashed border-border bg-muted transition-colors duration-200 hover:border-primary/50 hover:bg-muted/70">
                            <svg class="mb-4 h-12 w-12 text-muted-foreground" viewBox="0 0 24 24" fill="none"
                                aria-hidden="true">
                                <path d="M12 3v10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M8 7l4-4 4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M21 21H3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <p class="mb-2 text-center font-medium text-foreground">Arrasta e larga a tua imagem aqui
                            </p>
                            <p class="mb-4 text-center text-sm text-muted-foreground">ou clica para selecionar</p>
                            <button id="upload-button" type="button"
                                class="inline-flex items-center gap-2 rounded-lg border border-border px-4 py-2 text-sm font-semibold text-foreground transition hover:border-primary/70">
                                Escolher ficheiro
                            </button>
                        </div>
                        <input id="upload-input" type="file" accept="image/*" class="hidden" />
                        <div id="upload-preview" class="relative mt-6 hidden">
                            <div class="relative aspect-square overflow-hidden rounded-3xl bg-zinc-100">
                                <img id="preview-image" src="" alt="Imagem carregada"
                                    class="hidden object-contain w-full h-full" />
                                <div id="preview-placeholder"
                                    class="flex h-full items-center justify-center rounded-3xl border-2 border-dashed border-black/20">
                                    <p class="text-center text-sm text-black/40">A tua imagem aparece aqui</p>
                                </div>
                            </div>
                            <button id="remove-image" type="button"
                                class="absolute right-3 top-3 inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-zinc-700 shadow hover:bg-zinc-100">
                                ×
                            </button>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3" id="product-grid">
                        @forelse ($myImages as $image)
                            <a
                                href="{{ route('customization.index', ['tshirt' => $tshirt, 'design' => $image->id, 'color' => request('color')]) }}">
                                <div class="product-card group cursor-pointer overflow-hidden rounded-2xl bg-white shadow-sm transition hover:shadow-md {{ request('design') == $image->id ? 'ring-2 ring-zinc-950' : '' }}"
                                    data-id="{{ $image->id }}">
                                    <div class="relative aspect-square overflow-hidden bg-zinc-100">
                                        <img src="{{ route('tshirt_images.show', ['filename' => $image->image_url]) }}"
                                            alt="{{ $image->name }}"
                                            class="h-full w-full object-contain transition group-hover:scale-105" />
                                    </div>
                                    <div class="p-4">
                                        <h3 class="mt-2 font-semibold text-zinc-900">{{ $image->name }}</h3>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="col-span-full text-center py-12 text-muted-foreground">
                                Nenhum design encontrado.
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-12 flex justify-center">
                        {{ $myImages->links() }}
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm">
                    <div class="product-card group cursor-pointer overflow-hidden rounded-2xl bg-white shadow-sm transition hover:shadow-md"
                        data-id="{{ $tshirt->id }}">
                        <div
                            class="relative aspect-square overflow-hidden bg-zinc-100 flex items-center justify-center">
                            <img id="tshirt-base-preview"
                                src="{{ asset('storage/tshirt_base/' . $selectedColor->code . '.jpg') }}"
                                alt="T-shirt Base" class="absolute inset-0 h-full w-full object-contain" />
                            <img src="{{ route('tshirt_images.show', ['filename' => $tshirt->image_url]) }}"
                                alt="{{ $tshirt->name }}"
                                class="relative z-10 h-[40%] w-[40%] object-contain transition group-hover:scale-105" />
                        </div>
                        <div class="p-4">
                            <h3 class="mt-2 font-semibold text-zinc-900">{{ $tshirt->name }}</h3>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm">
                    <div class="p-6 space-y-6">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-zinc-900">Cor da T-Shirt</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($colours as $color)
                                    <a href="{{ route('customization.index', ['tshirt' => $tshirt, 'color' => $color->code, 'design' => request('design')]) }}"
                                        class="color-option h-10 w-10 rounded-full border-2 transition-all duration-200 {{ ($selectedColor->code ?? '') === $color->code ? 'border-zinc-950 ring-2 ring-zinc-950 ring-offset-2' : 'border-border' }}"
                                        data-value="{{ $color->name }}" data-hex="{{ $color->code }}"
                                        title="{{ $color->name }}" style="background-color: #{{ $color->code }}"></a>
                                @endforeach
                            </div>
                            <p id="selected-color-label" class="mt-2 text-sm text-muted-foreground">
                                {{ $selectedColor->name ?? 'Selecione uma cor' }}
                            </p>
                        </div>

                        <div>
                            <label for="size-select"
                                class="mb-2 block text-sm font-medium text-zinc-900">Tamanho</label>
                            <select id="size-select"
                                class="w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                                <option value="s">S</option>
                                <option value="m">M</option>
                                <option value="l">L</option>
                                <option value="xl">XL</option>
                            </select>
                        </div>

                        <div>
                            <label for="quantity-input"
                                class="mb-2 block text-sm font-medium text-zinc-900">Quantidade</label>
                            <input id="quantity-input" type="number" min="1" value="1"
                                class="w-24 rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" />
                            <p id="discount-label" class="mt-2 hidden text-sm text-primary">Desconto de quantidade
                                aplicado!</p>
                        </div>

                        <div class="rounded-3xl bg-muted p-4">
                            <div class="flex items-center justify-between text-sm text-zinc-600">
                                <span>Preço unitário:</span>
                                <span id="unit-price" class="font-medium">25.00€</span>
                            </div>
                            <div id="unit-price-original"
                                class="mt-2 hidden text-sm text-muted-foreground line-through">25.00€</div>
                            <div class="mt-3 flex items-center justify-between border-t border-zinc-200 pt-3">
                                <span class="font-medium">Total:</span>
                                <span id="total-price" class="text-xl font-bold text-primary">25.00€</span>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <button id="add-to-cart-btn" type="button"
                                class="inline-flex w-full justify-center rounded-2xl bg-zinc-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800 disabled:cursor-not-allowed disabled:opacity-50"
                                {{ $tshirt->image_url ? '' : 'disabled' }}>
                                Adicionar ao Carrinho
                            </button>
                            <p id="added-message" class="hidden text-center text-sm font-medium text-emerald-600">
                                Adicionado ao carrinho!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endcomponent