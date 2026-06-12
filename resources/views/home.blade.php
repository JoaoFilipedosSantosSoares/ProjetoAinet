@component('layouts.main-content')
<div class="flex flex-col">
    <section class="relative overflow-hidden bg-muted/30 py-20 md:py-32">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid items-center gap-12 lg:grid-cols-2">
                
                <div class="flex flex-col gap-6">
                    
                    <div class="flex flex-row items-center gap-6">
                        <h1 class="text-balance text-4xl font-bold tracking-tight md:text-5xl lg:text-6xl flex-1">
                            Veste a tua
                            <span class="text-[#144226]">Criatividade</span>
                        </h1>
                        
                        <div class="h-28 w-28 md:h-36 md:w-36 overflow-hidden rounded-2xl">
                            <img src="/img/FunShirtImage.png" alt="FunShirt Logo" class="h-full w-full object-cover">
                        </div>
                    </div>
                    
                    <p class="text-pretty text-lg text-muted-foreground md:text-xl">
                        Cria t-shirts únicas com os teus próprios designs ou escolhe do nosso catálogo.
                        Qualidade premium e preços acessíveis.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('catalog.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-[#144226] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#0f321c]">
                            <img src="/img/tshirt.png" alt="Catalog Icon" class="h-5 w-5" />    
                            <span>Ver catálogo</span>
                        </a>
                        
                        <a href="{{ route('customization.index') }}"
                            class="inline-flex items-center gap-2 rounded-xl border border-zinc-300 bg-transparent px-4 py-2.5 text-sm font-semibold text-zinc-700 hover:bg-zinc-100 transition">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/xl" aria-hidden="true">
                                <path d="M12 3v10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M8 7l4-4 4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M21 21H3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Criar T-Shirt
                        </a>
                    </div>
                </div>

                <div class="relative">
                    <div class="grid grid-cols-2 gap-4">
                        @foreach ($featuredImages as $index => $image)
                            <div class="bg-zinc-100 relative aspect-square overflow-hidden rounded-2xl bg-card shadow-lg {{ $index % 2 !== 0 ? 'translate-y-8' : '' }}">
                                <a href="{{ route('catalog.show', ['tshirt' => $image->id]) }}" title="Ver {{ $image->name }}">
                                    <img src="{{ asset('storage/tshirt_images/' . $image->image_url) }}" 
                                         alt="{{ $image->name }}"
                                         class="object-contain w-full h-full transition-transform duration-300 hover:scale-105" />
                                </a>
                            </div>
                        @endforeach

                        @if($featuredImages->isEmpty())
                            <div class="col-span-2 text-center py-12 text-muted-foreground bg-zinc-50 rounded-2xl border border-dashed border-zinc-200">
                                Sem imagens disponíveis no catálogo de momento.
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
@endcomponent