@component('layouts.main-content', ['type' => 'Persona'])
<main class="min-h-screen bg-background">
    <div class="container mx-auto px-4 py-12">
        <div class="mb-8 text-center">
            <h1 class="mb-2 text-3xl font-bold text-foreground">Personalização</h1>
            <p class="text-muted-foreground">Escolha as opções e adicione o seu produto ao carrinho</p>
        </div>

        <div class="mx-auto grid max-w-5xl gap-8 lg:grid-cols-2">
            <div class="space-y-6">
                <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm">
                    <div class="product-card overflow-hidden rounded-2xl bg-white shadow-sm">
                        <div class="relative aspect-square overflow-hidden bg-zinc-100 flex items-center justify-center">
                            <img id="tshirt-base-preview" src="{{ asset('storage/tshirt_base/' . $selectedColor->code . '.jpg') }}"
                                alt="T-shirt Base" class="absolute inset-0 h-full w-full object-contain" />
                            <img src="{{ asset('storage/tshirt_images/' . $tshirt->image_url) }}"
                                alt="{{ $tshirt->name }}" class="relative z-10 h-[50%] w-[50%] object-contain" />
                        </div>
                        <div class="p-4">
                            <p class="text-xs uppercase tracking-widest text-muted-foreground">
                                {{ $tshirt->category->name ?? 'Sem Categoria' }}
                            </p>
                            <h3 class="mt-2 font-semibold text-zinc-900">{{ $tshirt->name }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            {{-- COLUNA DA DIREITA: Opções de Compra --}}
            <div class="space-y-6">
                <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm">
                    <div class="p-6 space-y-6">
                        
                        {{-- Seleção de Cores através de links diretos (atualiza o preview da t-shirt) --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium text-zinc-900">Cor da T-Shirt</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($colours as $color)
                                    <a href="{{ route('catalog.show', ['tshirt' => $tshirt, 'color' => $color->code]) }}"
                                        class="color-option h-10 w-10 rounded-full border-2 transition-all duration-200 {{ ($selectedColor->code ?? '') === $color->code ? 'border-zinc-950 ring-2 ring-zinc-950 ring-offset-2' : 'border-border' }}"
                                        title="{{ $color->name }}"
                                        style="background-color: #{{ $color->code }}"></a>
                                @endforeach
                            </div>
                            <p class="mt-2 text-sm text-muted-foreground">{{ $selectedColor->name ?? 'Selecione uma cor' }}</p>
                        </div>

                        {{-- FORMULÁRIO ÚNICO POST PARA A SESSÃO DO CARRINHO --}}
                        <form action="{{ route('cart.add') }}" method="POST" class="space-y-6">
                            @csrf
                            <input type="hidden" name="tshirt_image_id" value="{{ $tshirt->id }}">
                            <input type="hidden" name="color" value="{{ $selectedColor->code }}">

                            <div>
                                <label for="size-select" class="mb-2 block text-sm font-medium text-zinc-900">Tamanho</label>
                                <select id="size-select" name="size" class="w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                                    <option value="S">S</option>
                                    <option value="M" selected>M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option>
                                </select>
                            </div>

                            <div>
                                <label for="quantity-input" class="mb-2 block text-sm font-medium text-zinc-900">Quantidade</label>
                                <input id="quantity-input" name="quantity" type="number" min="1" value="1"
                                    class="w-24 rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" />
                                <p class="mt-2 text-xs text-muted-foreground">Desconto automático aplicado a partir de 5 unidades.</p>
                            </div>

                            <div class="rounded-3xl bg-muted p-4">
                                <div class="flex items-center justify-between text-sm text-zinc-600">
                                    <span>Preço base unitário:</span>
                                    <span class="font-medium">25.00€</span>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <button type="submit" class="inline-flex w-full justify-center rounded-2xl bg-zinc-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800">
                                    Adicionar ao Carrinho
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endcomponent