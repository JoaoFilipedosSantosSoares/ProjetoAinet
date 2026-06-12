@component('layouts.main-content', ['title' => 'Carrinho'])
    @php
        $userIsAuthenticated = auth()->check();
        $grandTotal = 0;

        // Função anónima para calcular o preço com base no objeto de regras vindo do Model Prices
        $calculateItemPrice = function($isCatalog, $quantity, $rules) {
            // Fallback preventivo caso a tabela prices esteja totalmente vazia
            if (!$rules) {
                if ($quantity >= 5) {
                    return $isCatalog ? 20.00 : 40.00;
                }
                return $isCatalog ? 25.00 : 50.00;
            }

            // Lógica do Desconto de Quantidade por Item específico
            if ($quantity >= $rules->qty_discount) {
                return $isCatalog ? $rules->unit_price_catalog_discount : $rules->unit_price_own_discount;
            }

            return $isCatalog ? $rules->unit_price_catalog : $rules->unit_price_own;
        };
    @endphp

    <main class="min-h-screen bg-background">
        <div class="container mx-auto px-4 py-12">
            
            {{-- ESTADO VAZIO (Sem JS) --}}
            @if(count($cartItems) === 0)
                <div class="flex flex-col items-center justify-center py-20 text-center">
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
            @else
                {{-- CONTEÚDO DO CARRINHO COM ITENS --}}
                <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-foreground">O Teu Carrinho</h1>
                        <p class="text-muted-foreground">{{ count($cartItems) }} {{ count($cartItems) === 1 ? 'artigo' : 'artigos' }} no carrinho</p>
                    </div>
                    
                    {{-- Formulário para Limpar o Carrinho --}}
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 rounded-2xl border border-zinc-300 px-4 py-3 text-sm font-semibold text-zinc-900 transition hover:bg-zinc-100">
                            <span>Limpar Carrinho</span>
                        </button>
                    </form>
                </div>

                <div class="grid gap-8 lg:grid-cols-3">
                    <div class="space-y-4 lg:col-span-2">
                        @foreach ($cartItems as $item)
                            @php
                                $unitPrice = $calculateItemPrice($item['isCatalogImage'], $item['quantity'], $priceRules);
                                $itemTotal = $unitPrice * $item['quantity'];
                                $grandTotal += $itemTotal;
                            @endphp

                            <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm">
                                <div class="p-4 sm:p-6">
                                    <div class="flex flex-col gap-4 sm:flex-row">
                                        
                                        {{-- Imagem do produto --}}
                                        <div class="relative h-24 w-full overflow-hidden rounded-3xl bg-muted sm:w-24 flex items-center justify-center">
                                            @if($item['isCatalogImage'])
                                                <img src="{{ asset('storage/tshirt_images/' . $item['imageUrl']) }}" alt="{{ $item['imageName'] }}" class="object-contain w-full h-full" />
                                            @else
                                                <img src="{{ route('tshirt_images.show', ['filename' => $item['imageUrl']]) }}" alt="{{ $item['imageName'] }}" class="object-contain w-full h-full" />
                                            @endif
                                        </div>

                                        {{-- Informações e Ações --}}
                                        <div class="flex flex-1 flex-col justify-between gap-4">
                                            <div class="flex items-start justify-between gap-4">
                                                <div>
                                                    <h2 class="text-lg font-semibold text-foreground">{{ $item['imageName'] }}</h2>
                                                    <p class="text-sm text-muted-foreground">
                                                        {{ $item['isCatalogImage'] ? 'Design do Catálogo' : 'Imagem Personalizada' }}
                                                    </p>
                                                </div>

                                                {{-- Formulário para Remover Item --}}
                                                <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="rounded-full border border-zinc-300 px-3 py-2 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-100">
                                                        Remover
                                                    </button>
                                                </form>
                                            </div>

                                            {{-- FORMULÁRIO DE ATUALIZAÇÃO (Submete alterações ao trocar selects ou focar a quantidade) --}}
                                            <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="grid gap-4 sm:grid-cols-3 items-end">
                                                @csrf
                                                <div>
                                                    <label class="mb-2 block text-sm font-medium text-zinc-900">Cor</label>
                                                    <select name="color" class="w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-primary">
                                                        @foreach ($tshirtColors as $color)
                                                            <option value="{{ $color->code }}" {{ $item['color'] === $color->code ? 'selected' : '' }}>
                                                                {{ $color->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                
                                                <div>
                                                    <label class="mb-2 block text-sm font-medium text-zinc-900">Tamanho</label>
                                                    <select name="size" class="w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-primary">
                                                        @foreach ($tshirtSizes as $size)
                                                            <option value="{{ $size }}" {{ $item['size'] === $size ? 'selected' : '' }}>
                                                                {{ $size }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="flex gap-2 items-center">
                                                    <div class="w-full">
                                                        <label class="mb-2 block text-sm font-medium text-zinc-900">Qtd</label>
                                                        <input name="quantity" type="number" min="1" value="{{ $item['quantity'] }}" 
                                                            class="w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none" />
                                                    </div>
                                                    <button type="submit" title="Atualizar Linha" class="mt-7 p-3 rounded-2xl bg-zinc-100 border border-zinc-200 hover:bg-zinc-200 text-sm">
                                                        ✓
                                                    </button>
                                                </div>
                                            </form>

                                            <div class="flex items-center justify-between border-t border-zinc-200 pt-4 text-sm text-muted-foreground">
                                                <span>Preço unitário</span>
                                                <span>{{ number_format($unitPrice, 2) }}€</span>
                                            </div>
                                            <div class="flex items-center justify-between pt-2 text-base font-semibold text-foreground">
                                                <span>Total do Artigo</span>
                                                <span class="text-zinc-900">{{ number_format($itemTotal, 2) }}€</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- RESUMO DA COMPRA --}}
                    <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm h-fit">
                        <div class="p-6 space-y-6">
                            <h2 class="text-xl font-semibold text-foreground">Resumo da Encomenda</h2>
                            
                            <div class="space-y-3">
                                @foreach($cartItems as $item)
                                    @php
                                        $unitPrice = $calculateItemPrice($item['isCatalogImage'], $item['quantity'], $priceRules);
                                    @endphp
                                    <div class="flex justify-between text-sm text-muted-foreground">
                                        <span>{{ $item['imageName'] }} (x{{ $item['quantity'] }})</span>
                                        <span>{{ number_format($unitPrice * $item['quantity'], 2) }}€</span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-t border-zinc-200 pt-4">
                                <div class="flex items-center justify-between text-lg font-semibold">
                                    <span>Total</span>
                                    <span class="text-primary">{{ number_format($grandTotal, 2) }}€</span>
                                </div>
                                <p class="mt-1 text-xs text-muted-foreground">Portes de envio calculados no checkout</p>
                            </div>
                            
                            <div class="mt-6 space-y-4">
    @if ($userIsAuthenticated)
        {{-- Formulário Direto de Compra sem interrupção de ecrãs de pagamento externos --}}
        <form method="POST" action="{{ route('orders.storeCheckout') }}" class="space-y-4">
            @csrf
            
            <div>
                <label for="order-notes" class="mb-2 block text-sm font-medium text-zinc-700">Notas/Observações da Encomenda (Opcional)</label>
                <textarea id="order-notes" name="notes" rows="2" placeholder="Ex: Deixar no andar de baixo caso não responda..."
                    class="w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"></textarea>
            </div>

            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-[#144226] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#0e2f1b]">
                Confirmar e Submeter Encomenda
            </button>
        </form>
    @else
        <div class="space-y-4">
            <a href="/entrar?redirect=/carrinho" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-zinc-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800">
                Entrar para Finalizar Compra
            </a>
            <p class="text-center text-sm text-muted-foreground">
                Não tens conta? <a href="/registar" class="text-primary hover:underline">Regista-te aqui</a>
            </p>
        </div>
    @endif
</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>
@endcomponent