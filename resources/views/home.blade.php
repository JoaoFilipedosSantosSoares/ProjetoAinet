@component('layouts.main-content', ['type' => 'home'])
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
                        <a href="/" class="flex items-center gap-2 rounded-xl bg-[#144226] px-4 py-2.5 text-sm font-semibold text-white transition">
                            <img src="/img/tshirt.png" alt="Catalog Icon" class="h-5 w-5" />    
                        <span class="">
                                Ver catalogo
                            </span>
                        </a>
                        <a href="/personalizar"
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
                            <img src="/images/featured1.jpg" alt="Featured 1"
                                class="object-cover w-full h-full transition-transform duration-300 hover:scale-105" />
                        </div>
                        <div class="relative aspect-square overflow-hidden rounded-2xl bg-card shadow-lg translate-y-8">
                            <img src="/images/featured2.jpg" alt="Featured 2"
                                class="object-cover w-full h-full transition-transform duration-300 hover:scale-105" />
                        </div>
                        <div class="relative aspect-square overflow-hidden rounded-2xl bg-card shadow-lg">
                            <img src="/images/featured3.jpg" alt="Featured 3"
                                class="object-cover w-full h-full transition-transform duration-300 hover:scale-105" />
                        </div>
                        <div class="relative aspect-square overflow-hidden rounded-2xl bg-card shadow-lg translate-y-8">
                            <img src="/images/featured4.jpg" alt="Featured 4"
                                class="object-cover w-full h-full transition-transform duration-300 hover:scale-105" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold tracking-tight">Precos Simples</h2>
                <p class="mt-2 text-muted-foreground">Descontos automaticos para encomendas maiores</p>
            </div>

            <div class="mt-12 grid gap-8 md:grid-cols-2">
                <div class="relative overflow-hidden rounded-lg bg-card shadow">
                    <div
                        class="absolute right-0 top-0 rounded-bl-lg bg-primary px-3 py-1 text-sm font-medium text-primary-foreground">
                        Popular</div>
                    <div class="p-6 pt-8 flex flex-col gap-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10">
                                <svg class="h-6 w-6 text-primary" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M4 7.5L7 5l2 1 1-1 1 1 2-1 3 2.5V20a1 1 0 01-1 1H5a1 1 0 01-1-1V7.5z"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold">Imagens do Catalogo</h3>
                                <p class="text-sm text-muted-foreground">Escolhe de centenas de designs</p>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-4xl font-bold">30</span>
                            <span class="text-muted-foreground">/ unidade</span>
                        </div>
                        <div class="rounded-lg bg-accent/50 p-3 text-sm"><span class="font-medium">Desconto:</span>
                            40€/unidade para 10+ unidades</div>
                        <a href="/catalogo"
                            class="mt-2 inline-flex w-full items-center justify-center gap-2 rounded-md bg-primary px-4 py-2 text-sm font-semibold text-primary-foreground hover:opacity-95">
                            Explorar Catalogo
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true">
                                <path d="M5 12h14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M12 5l7 7-7 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="rounded-lg bg-card shadow">
                    <div class="p-6 pt-6 flex flex-col gap-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-accent/50">
                                <svg class="h-6 w-6 text-accent-foreground" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M12 3v10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M8 7l4-4 4 4" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M21 21H3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold">Imagem Personalizada</h3>
                                <p class="text-sm text-muted-foreground">Envia a tua propria imagem</p>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-4xl font-bold">50</span>
                            <span class="text-muted-foreground">/ unidade</span>
                        </div>
                        <div class="rounded-lg bg-muted p-3 text-sm"><span class="font-medium">Desconto:</span>
                            40€/unidade para 10+ unidades</div>
                        <a href="/personalizar"
                            class="mt-2 inline-flex w-full items-center justify-center gap-2 rounded-md border border-border bg-transparent px-4 py-2 text-sm font-semibold text-muted-foreground hover:bg-muted/30">
                            Criar T-Shirt
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true">
                                <path d="M5 12h14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M12 5l7 7-7 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl bg-primary p-8 text-center text-primary-foreground md:p-16">
                <h2 class="text-3xl font-bold tracking-tight md:text-4xl">Pronto para criar a tua t-shirt?</h2>
                <p class="mx-auto mt-4 max-w-2xl text-primary-foreground/80">Comeca agora e recebe a tua t-shirt
                    personalizada em poucos dias.</p>
                <div class="mt-8 flex flex-wrap justify-center gap-4">
                    <a href="/personalizar"
                        class="inline-flex items-center gap-2 rounded-md bg-secondary px-4 py-2 text-sm font-semibold text-secondary-foreground hover:opacity-95">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true">
                            <path d="M12 3v10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M8 7l4-4 4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        Comecar Agora
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

@endcomponent