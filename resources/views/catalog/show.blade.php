@component('layouts.main-content', ['type' => 'Persona'])
<main class="min-h-screen bg-background">
    <div class="container mx-auto px-4 py-12">
        <div class="mb-8 text-center">
            <h1 class="mb-2 text-3xl font-bold text-foreground">Confirmação</h1>
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
                        <div class="p-4">
                            <p class="text-xs uppercase tracking-widest black font-bold">
                                Descrição
                            </p>
                            <p class="mt-2 text-sm text-zinc-600 leading-relaxed italic">
                                {{ $tshirt->description ?? 'Nenhuma descrição disponível para este artigo.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- COLUNA DA DIREITA: Opções de Compra --}}
            <div class="space-y-6">
                <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm">
                    
                    {{-- 
                        O Alpine.js AGORA LÊ OS VALORES DIRETOS DA BASE DE DADOS 
                    --}}
                    <div class="p-6 space-y-6" x-data="{
                        quantity: 1,
                        basePrice: {{ $basePrice }},
                        discountPrice: {{ $discountPrice }},
                        qtyTrigger: {{ $qtyTrigger }},
                        selectedColorCode: '{{ $selectedColor->code ?? ($colors->first()->code ?? '') }}',
                        selectedColorName: '{{ $selectedColor->name ?? ($colors->first()->name ?? '') }}'
                    }">

                        {{-- SELEÇÃO DE CORES COM ALPINE.JS --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium text-zinc-900">
                                Cor da T-Shirt: <span class="text-zinc-500 font-normal" x-text="selectedColorName"></span>
                            </label>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($colors as $color)
                                    <button type="button"
                                        @click="selectedColorCode = '{{ $color->code }}'; selectedColorName = '{{ $color->name }}'; document.getElementById('tshirt-base-preview').src = '{{ asset('storage/tshirt_base/' . $color->code . '.jpg') }}'"
                                        class="h-10 w-10 rounded-full border-2 transition-all duration-200 focus:outline-none"
                                        :class="selectedColorCode === '{{ $color->code }}' ? 'border-zinc-950 ring-2 ring-zinc-950 ring-offset-2 scale-105' : 'border-border'"
                                        title="{{ $color->name }}"
                                        style="background-color: #{{ $color->code }}"></button>
                                @endforeach
                            </div>
                        </div>

                        {{-- FORMULÁRIO ÚNICO POST PARA A SESSÃO DO CARRINHO --}}
                        <form action="{{ route('cart.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <input type="hidden" name="tshirt_image_id" value="{{ $tshirt->id }}">
                            <input type="hidden" name="color" :value="selectedColorCode">

                            {{-- SELEÇÃO DE TAMANHO --}}
                            <div>
                                <label for="size-select" class="mb-2 block text-sm font-medium text-zinc-900">Tamanho</label>
                                <select id="size-select" name="size" class="w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                                    <option value="S">S</option>
                                    <option value="M" selected>M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option>
                                </select>
                            </div>

                            {{-- QUANTIDADE --}}
                            <div>
                                <label for="quantity-input" class="mb-2 block text-sm font-medium text-zinc-900">Quantidade</label>
                                <input id="quantity-input" name="quantity" type="number" min="1" 
                                    x-model.number="quantity"
                                    class="w-24 rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" />
                                
                                <p class="mt-2 text-xs text-muted-foreground">
                                    Desconto automático aplicado a partir de <span x-text="qtyTrigger"></span> unidades.
                                </p>
                            </div>

                            {{-- ESPELHO DE PREÇOS COMPLETO E REATIVO --}}
                            <div class="rounded-3xl bg-muted p-4 space-y-2 text-sm text-zinc-600">
                                <div class="flex items-center justify-between">
                                    <span>Preço Unitário:</span>
                                    <span class="font-medium text-zinc-900" 
                                          x-text="(quantity >= qtyTrigger ? discountPrice : basePrice).toFixed(2) + '€'">
                                    </span>
                                </div>

                                <div class="flex items-center justify-between text-xs text-emerald-600 font-medium" 
                                     x-show="quantity >= qtyTrigger" x-cloak>
                                    <span>Desconto de quantidade:</span>
                                    <span>Aplicado! (Especial <span x-text="discountPrice.toFixed(2)"></span>€)</span>
                                </div>

                                <div class="flex items-center justify-between border-t border-zinc-200 pt-2 text-zinc-900 font-semibold mt-1">
                                    <span>Total:</span>
                                    <span class="text-xl font-bold text-[#144226]" 
                                          x-text="((quantity >= qtyTrigger ? discountPrice : basePrice) * (quantity || 1)).toFixed(2) + '€'">
                                    </span>
                                </div>
                            </div>

                            {{-- BOTÃO DE SUBMISSÃO PARA O CARRINHO --}}
                            <div class="space-y-3">
                                <button type="submit"
                                    class="inline-flex w-full justify-center rounded-2xl bg-zinc-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800 disabled:cursor-not-allowed disabled:opacity-50"
                                    {{ (isset($tshirt) && $tshirt->image_url) ? '' : 'disabled' }}
                                    {{ auth()->check() && (auth()->user()->user_type === 'F' || auth()->user()->user_type === 'A') ? 'disabled' : '' }}>
                                    Adicionar ao Carrinho
                                </button>

                                @auth
                                @if(auth()->user()->user_type === 'F' || auth()->user()->user_type === 'A')
                                <p class="text-center text-xs text-red-500 mt-1">
                                    Contas de funcionários/admins não podem efetuar compras.
                                </p>
                                @endif
                                @endauth
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endcomponent