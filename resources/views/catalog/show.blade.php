@component('layouts.main-content', ['type' => 'Persona'])
@php
    $tshirtColors = [
        ['value' => 'branco', 'label' => 'Branco', 'hex' => '#ffffff'],
        ['value' => 'preto', 'label' => 'Preto', 'hex' => '#111827'],
        ['value' => 'vermelho', 'label' => 'Vermelho', 'hex' => '#ef4444'],
        ['value' => 'azul', 'label' => 'Azul', 'hex' => '#3b82f6'],
        ['value' => 'verde', 'label' => 'Verde', 'hex' => '#22c55e'],
    ];

    $tshirtSizes = [
        ['value' => 'S', 'label' => 'S'],
        ['value' => 'M', 'label' => 'M'],
        ['value' => 'L', 'label' => 'L'],
        ['value' => 'XL', 'label' => 'XL'],
    ];
@endphp

<main class="min-h-screen bg-background">
    <div class="container mx-auto px-4 py-12">
        <div class="mb-8 text-center">
            <h1 class="mb-2 text-3xl font-bold text-foreground">Tshit</h1>
            <p class="text-muted-foreground">Carrega a tua imagem e personaliza a tua t-shirt única</p>
        </div>

        <div class="mx-auto grid max-w-5xl gap-8 lg:grid-cols-2">
            <div class="space-y-6">
                <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm">
                    <div class="product-card group cursor-pointer overflow-hidden rounded-2xl bg-white shadow-sm transition hover:shadow-md"
                        data-category="{{ $tshirt->category->name ?? 'Sem Categoria' }}" data-id="{{ $tshirt->id }}">
                        <div class="relative aspect-square overflow-hidden bg-zinc-100">
                            <img src="{{ asset('storage/tshirt_images/' . $tshirt->image_url) }}"
                                alt="{{ $tshirt->name }}"
                                class="h-full w-full object-contain transition group-hover:scale-105" />
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

            <div class="space-y-6">
                <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm">
                    <div class="p-6 space-y-6">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-zinc-900">Cor da T-Shirt</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($tshirtColors as $color)
                                    <button type="button"
                                        class="color-option h-10 w-10 rounded-full border-2 border-border transition-all duration-200"
                                        data-value="{{ $color['value'] }}" data-hex="{{ $color['hex'] }}"
                                        title="{{ $color['label'] }}"
                                        style="background-color: {{ $color['hex'] }}"></button>
                                @endforeach
                            </div>
                            <p id="selected-color-label" class="mt-2 text-sm text-muted-foreground">Branco</p>
                        </div>

                        <div>
                            <label for="size-select"
                                class="mb-2 block text-sm font-medium text-zinc-900">Tamanho</label>
                            <select id="size-select"
                                class="w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                                @foreach ($tshirtSizes as $size)
                                    <option value="{{ $size['value'] }}">{{ $size['label'] }}</option>
                                @endforeach
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
                                disabled>
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