@component('layouts.main-content')
<div class="flex flex-col">
    <section class="relative overflow-hidden bg-muted/30 py-20 md:py-32">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid items-center gap-12 lg:grid-cols-2">
                <div class="flex flex-col gap-6">
                    <h1 class="text-balance text-4xl font-bold tracking-tight md:text-5xl lg:text-6xl">
                        Veste a tua
                        <span class="text-[#144226]">criatividade</span>
                    </h1>
                    <p class="text-pretty text-lg text-muted-foreground md:text-xl">
                        Cria t-shirts unicas com os teus proprios designs ou escolhe do nosso catalogo.
                        Qualidade premium, precos acessiveis.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('catalog.index') }}" class="flex items-center gap-2 rounded-xl bg-[#144226] px-4 py-2.5 text-sm font-semibold text-white transition">
                            <img src="/img/tshirt.png" alt="Catalog Icon" class="h-5 w-5" />    
                        <span class="">
                                Ver catalogo
                            </span>
                        </a>
                        <a href="{{ route('customization.index') }}"
                            class="inline-flex items-center gap-2 rounded-md border border-border bg-transparent px-4 py-2 text-sm font-semibold text-muted-foreground hover:bg-muted/30">
                            <!-- Upload icon -->
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true">
                                <path d="M12 3v10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M8 7l4-4 4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M21 21H3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            Criar T-Shirt
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="relative aspect-square overflow-hidden rounded-2xl bg-card shadow-lg">
                            <img src="{{ asset('storage/tshirt_images/00002_2EWdICoA7j.png') }}" alt="Featured 1"
                                class="object-contain w-full h-full transition-transform duration-300 hover:scale-105" />
                        </div>
                        <div class="relative aspect-square overflow-hidden rounded-2xl bg-card shadow-lg translate-y-8">
                            <img src="{{ asset('storage/tshirt_images/00004_iOV69Hbsyr.png') }}" alt="Featured 2"
                                class="object-contain w-full h-full transition-transform duration-300 hover:scale-105" />
                        </div>
                        <div class="relative aspect-square overflow-hidden rounded-2xl bg-card shadow-lg">
                            <img src="{{ asset('storage/tshirt_images/00005_tSAK1qD1mr.png') }}" alt="Featured 3"
                                class="object-contain w-full h-full transition-transform duration-300 hover:scale-105" />
                        </div>
                        <div class="relative aspect-square overflow-hidden rounded-2xl bg-card shadow-lg translate-y-8">
                            <img src="{{ asset('storage/tshirt_images/00007_rxOzQzWLgw.png') }}" alt="Featured 4"
                                class="object-contain w-full h-full transition-transform duration-300 hover:scale-105" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endcomponent