
@vite(['resources/css/app.css', 'resources/js/app.js'])
<header class="sticky top-0 z-50 border-b border-zinc-200 bg-[#fbfaf7]">
    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">

        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#144226]">
            </div>
            <span class="text-xl font-bold tracking-tight text-zinc-900">FunShirt</span>
        </a>

        <nav class="hidden items-center gap-2 md:flex">
            <a href="{{ route('home') }}"
                class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition {{ strtolower($active ?? '') === 'home' ? 'bg-[#144226] text-white' : 'bg-transparent text-zinc-600 hover:text-zinc-950' }}">
                <span class="">
                    Inicio
                </span>
            </a>

            <a href="{{ route('catalog.index') }}"
                class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-medium transition {{ strtolower($active ?? '') === 'catalogo' ? 'bg-[#144226] text-white' : 'bg-transparent text-zinc-600 hover:text-zinc-950' }}">
                Catalogo
            </a>

            <a href="{{ route('customization.index') }}"
                class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-medium transition {{ strtolower($active ?? '') === 'persona' ? 'bg-[#144226] text-white' : 'bg-transparent text-zinc-600 hover:text-zinc-950' }}">
                Personalizar
            </a>

            <a href="{{ route('orders.index') }}"
                class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-medium transition {{ strtolower($active ?? '') === 'encomendas' ? 'bg-[#144226] text-white' : 'bg-transparent text-zinc-600 hover:text-zinc-950' }}">
                Encomendas
            </a>
        </nav>

        <div class="flex items-center gap-4">
            <a href="" class="relative p-2 text-zinc-800 hover:text-zinc-950 transition">
                <img src="/img/online-shopping.png" alt="Catalog Icon" class="h-5 w-5" />
                <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-[#144226] text-xs font-bold text-white">
                    0
                </span>
            </a>

            @auth
            <a href="{{ route('account.index') }}" class="p-2 text-zinc-800 hover:text-zinc-950 transition">
                <img src="/img/user.png" alt="Account Icon" class="h-6 w-6" />
            </a>
            @else
            <a href="{{ route('login') }}" class="p-2 text-zinc-800 hover:text-zinc-950 transition">
                <img src="/img/user.png" alt="Login Icon" class="h-6 w-6" />
            </a>
            @endauth
        </div>
    </div>
</header>

{{ $slot }}