@vite(['resources/css/app.css', 'resources/js/app.js'])
<header class="sticky top-0 z-50 border-b border-zinc-200 bg-[#fbfaf7]">
    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">

        <a href="/" class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#144226]">
            </div>
            <span class="text-xl font-bold tracking-tight text-zinc-900">FunShirt</span>
        </a>

        <nav class="hidden items-center gap-2 md:flex">
            <a href="/" class="flex items-center gap-2 rounded-xl bg-[#144226] px-4 py-2.5 text-sm font-semibold text-white transition">
                <span class="">
                    Inicio
                </span>
            </a>

            <a href="/"
                class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-medium text-zinc-600 hover:text-zinc-950 transition">
            Catalogo
            </a>

            <a href="/"
                class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-medium text-zinc-600 hover:text-zinc-950 transition">
            Personalizar
            </a>
        </nav>

        <div class="flex items-center gap-4">
            <a href="/" class="relative p-2 text-zinc-800 hover:text-zinc-950 transition">
            <span class="">Carrinho</span>
            </a>

            <a href="/" class="p-2 text-zinc-800 hover:text-zinc-950 transition">
            <span class="">Conta</span>
            </a>
        </div>
    </div>
</header>

{{ $slot }}