@component('layouts.main-content', ['title' => 'Carrinho'])
    @php
        $cartItems = [
            [
                'id' => 'item-1',
                'imageUrl' => 'https://via.placeholder.com/320x320?text=Design+1',
                'imageName' => 'Design Floral',
                'color' => 'branco',
                'size' => 'M',
                'quantity' => 2,
                'isCatalogImage' => true,
            ],
            [
                'id' => 'item-2',
                'imageUrl' => 'https://via.placeholder.com/320x320?text=Design+2',
                'imageName' => 'Guitarra Neon',
                'color' => 'preto',
                'size' => 'L',
                'quantity' => 1,
                'isCatalogImage' => false,
            ],
        ];

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

        $userIsAuthenticated = auth()->check();
    @endphp

    <main class="min-h-screen bg-background">
        <div class="container mx-auto px-4 py-12">
            <div id="cart-empty" class="{{ count($cartItems) > 0 ? 'hidden' : '' }} flex flex-col items-center justify-center py-20 text-center">
                <svg class="mb-4 h-16 w-16 text-muted-foreground" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M6 6h15l-2 12H6L4 6z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M9 6V4h6v2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <h1 class="mb-2 text-2xl font-bold text-foreground">O teu carrinho está vazio</h1>
                <p class="mb-6 text-muted-foreground">Adiciona algumas t-shirts incríveis ao teu carrinho!</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="/catalog" class="rounded-2xl bg-zinc-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800">Ver Catálogo</a>
                    <a href="/customization" class="rounded-2xl border border-zinc-300 px-5 py-3 text-sm font-semibold text-zinc-900 transition hover:bg-zinc-100">Criar T-Shirt</a>
                </div>
            </div>

            <div id="cart-content" class="{{ count($cartItems) === 0 ? 'hidden' : '' }}">
                <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-foreground">O Teu Carrinho</h1>
                        <p class="text-muted-foreground">{{ count($cartItems) }} {{ count($cartItems) === 1 ? 'artigo' : 'artigos' }} no carrinho</p>
                    </div>
                    <button id="clear-cart" type="button" class="inline-flex items-center gap-2 rounded-2xl border border-zinc-300 px-4 py-3 text-sm font-semibold text-zinc-900 transition hover:bg-zinc-100">
                        <span>Limpar Carrinho</span>
                    </button>
                </div>

                <div class="grid gap-8 lg:grid-cols-3">
                    <div class="space-y-4 lg:col-span-2" id="cart-items">
                        @foreach ($cartItems as $item)
                            <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm" data-item-id="{{ $item['id'] }}" data-is-custom="{{ $item['isCatalogImage'] ? 'false' : 'true' }}">
                                <div class="p-4 sm:p-6">
                                    <div class="flex flex-col gap-4 sm:flex-row">
                                        <div class="relative h-24 w-full overflow-hidden rounded-3xl bg-muted sm:w-24">
                                            <img src="{{ $item['imageUrl'] }}" alt="{{ $item['imageName'] }}" class="object-cover w-full h-full" />
                                        </div>
                                        <div class="flex flex-1 flex-col justify-between gap-4">
                                            <div class="flex items-start justify-between gap-4">
                                                <div>
                                                    <h2 class="text-lg font-semibold text-foreground">{{ $item['imageName'] }}</h2>
                                                    <p class="text-sm text-muted-foreground">
                                                        {{ $item['isCatalogImage'] ? 'Design do Catálogo' : 'Imagem Personalizada' }}
                                                    </p>
                                                </div>
                                                <button type="button" class="remove-item rounded-full border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-100">Remover</button>
                                            </div>

                                            <div class="grid gap-4 sm:grid-cols-3">
                                                <div>
                                                    <label class="mb-2 block text-sm font-medium text-zinc-900">Cor</label>
                                                    <select class="item-color w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                                                        @foreach ($tshirtColors as $color)
                                                            <option value="{{ $color['value'] }}" data-hex="{{ $color['hex'] }}" {{ $item['color'] === $color['value'] ? 'selected' : '' }}>{{ $color['label'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="mb-2 block text-sm font-medium text-zinc-900">Tamanho</label>
                                                    <select class="item-size w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                                                        @foreach ($tshirtSizes as $size)
                                                            <option value="{{ $size['value'] }}" {{ $item['size'] === $size['value'] ? 'selected' : '' }}>{{ $size['label'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="mb-2 block text-sm font-medium text-zinc-900">Quantidade</label>
                                                    <div class="flex items-center gap-2 rounded-2xl border border-zinc-200 bg-white px-2 py-1">
                                                        <button type="button" class="quantity-decrease inline-flex h-10 w-10 items-center justify-center text-zinc-700 transition hover:bg-zinc-100">−</button>
                                                        <input class="quantity-input w-full border-none bg-transparent text-center text-sm text-zinc-900 outline-none" type="number" min="1" value="{{ $item['quantity'] }}" />
                                                        <button type="button" class="quantity-increase inline-flex h-10 w-10 items-center justify-center text-zinc-700 transition hover:bg-zinc-100">+</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex items-center justify-between border-t border-zinc-200 pt-4 text-sm text-muted-foreground">
                                                <span>Preço unitário</span>
                                                <span class="item-unit-price">0.00€</span>
                                            </div>
                                            <div class="flex items-center justify-between pt-2 text-base font-semibold text-foreground">
                                                <span>Total</span>
                                                <span class="item-total-price">0.00€</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm">
                        <div class="p-6 space-y-6">
                            <h2 class="text-xl font-semibold text-foreground">Resumo da Encomenda</h2>
                            <div class="space-y-3" id="summary-items"></div>
                            <div class="border-t border-zinc-200 pt-4">
                                <div class="flex items-center justify-between text-lg font-semibold">
                                    <span>Total</span>
                                    <span id="summary-total" class="text-primary">0.00€</span>
                                </div>
                                <p class="mt-1 text-xs text-muted-foreground">Portes de envio calculados no checkout</p>
                            </div>
                            @if ($userIsAuthenticated)
                                <a href="/checkout" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-zinc-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800">Finalizar Compra</a>
                            @else
                                <div class="space-y-4">
                                    <a href="/entrar?redirect=/checkout" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-zinc-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800">Entrar para Finalizar</a>
                                    <p class="text-center text-sm text-muted-foreground">Não tens conta? <a href="/registar?redirect=/checkout" class="text-primary hover:underline">Regista-te aqui</a></p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        const cartItems = @json($cartItems);
        const tshirtColors = @json($tshirtColors);
        const clearCartButton = document.getElementById('clear-cart');
        const cartItemsContainer = document.getElementById('cart-items');
        const summaryItems = document.getElementById('summary-items');
        const summaryTotal = document.getElementById('summary-total');
        const cartEmpty = document.getElementById('cart-empty');
        const cartContent = document.getElementById('cart-content');

        function getPrice(isCustom, quantity) {
            if (isCustom) {
                return quantity >= 5 ? 40 : 50;
            }
            return quantity >= 5 ? 20 : 25;
        }

        function formatPrice(value) {
            return value.toFixed(2) + '€';
        }

        function updateItemRow(row, item) {
            const unitPriceEl = row.querySelector('.item-unit-price');
            const totalPriceEl = row.querySelector('.item-total-price');
            const quantityInput = row.querySelector('.quantity-input');
            quantityInput.value = item.quantity;

            const unitPrice = getPrice(!item.isCatalogImage, item.quantity);
            unitPriceEl.textContent = formatPrice(unitPrice);
            totalPriceEl.textContent = formatPrice(unitPrice * item.quantity);
        }

        function renderSummary(items) {
            summaryItems.innerHTML = '';
            let total = 0;

            items.forEach((item) => {
                const unitPrice = getPrice(!item.isCatalogImage, item.quantity);
                const itemTotal = unitPrice * item.quantity;
                total += itemTotal;

                const line = document.createElement('div');
                line.className = 'flex justify-between text-sm text-muted-foreground';
                line.innerHTML = `<span>${item.imageName} x${item.quantity}</span><span>${formatPrice(itemTotal)}</span>`;
                summaryItems.appendChild(line);
            });

            summaryTotal.textContent = formatPrice(total);
        }

        function updateCartState(items) {
            const rows = cartItemsContainer.querySelectorAll('[data-item-id]');
            rows.forEach((row) => {
                const itemId = row.dataset.itemId;
                const item = items.find((entry) => entry.id === itemId);
                if (item) {
                    updateItemRow(row, item);
                }
            });
            renderSummary(items);
            const hasItems = items.length > 0;
            cartEmpty.classList.toggle('hidden', hasItems);
            cartContent.classList.toggle('hidden', !hasItems);
        }

        function removeItem(itemId) {
            const index = cartItems.findIndex((item) => item.id === itemId);
            if (index !== -1) {
                cartItems.splice(index, 1);
                const row = cartItemsContainer.querySelector(`[data-item-id="${itemId}"]`);
                if (row) row.remove();
                updateCartState(cartItems);
            }
        }

        function attachEvents() {
            cartItemsContainer.querySelectorAll('[data-item-id]').forEach((row) => {
                const itemId = row.dataset.itemId;
                const decreaseButton = row.querySelector('.quantity-decrease');
                const increaseButton = row.querySelector('.quantity-increase');
                const quantityInput = row.querySelector('.quantity-input');
                const colorSelect = row.querySelector('.item-color');
                const sizeSelect = row.querySelector('.item-size');
                const removeButton = row.querySelector('.remove-item');

                decreaseButton.addEventListener('click', () => {
                    const item = cartItems.find((entry) => entry.id === itemId);
                    if (item && item.quantity > 1) {
                        item.quantity -= 1;
                        updateCartState(cartItems);
                    }
                });

                increaseButton.addEventListener('click', () => {
                    const item = cartItems.find((entry) => entry.id === itemId);
                    if (item) {
                        item.quantity += 1;
                        updateCartState(cartItems);
                    }
                });

                quantityInput.addEventListener('input', (event) => {
                    const item = cartItems.find((entry) => entry.id === itemId);
                    let value = parseInt(event.target.value, 10);
                    if (Number.isNaN(value) || value < 1) {
                        value = 1;
                    }
                    event.target.value = value;
                    if (item) {
                        item.quantity = value;
                        updateCartState(cartItems);
                    }
                });

                colorSelect.addEventListener('change', (event) => {
                    const item = cartItems.find((entry) => entry.id === itemId);
                    if (item) {
                        item.color = event.target.value;
                    }
                });

                sizeSelect.addEventListener('change', (event) => {
                    const item = cartItems.find((entry) => entry.id === itemId);
                    if (item) {
                        item.size = event.target.value;
                    }
                });

                removeButton.addEventListener('click', () => removeItem(itemId));
            });
        }

        clearCartButton.addEventListener('click', () => {
            cartItems.length = 0;
            cartItemsContainer.innerHTML = '';
            updateCartState(cartItems);
        });

        updateCartState(cartItems);
        attachEvents();
    </script>
@endcomponent
