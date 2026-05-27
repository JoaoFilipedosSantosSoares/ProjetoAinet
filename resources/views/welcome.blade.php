<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'FunShirt') }} — @yield('title', 'T-Shirts Personalizadas')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full bg-stone-50 font-sans antialiased text-stone-900">

{{-- NAVIGATION --}}
<nav class="bg-white border-b border-stone-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <span class="flex items-center gap-2 group">
                <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center shadow-sm group-hover:bg-orange-600 transition-colors">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C8 2 4.5 4.5 4.5 8.5c0 1.5.5 3 1.5 4L3 21h18l-3-8.5c1-1 1.5-2.5 1.5-4C19.5 4.5 16 2 12 2z"/>
                    </svg>
                </div>
                <span class="text-xl font-bold tracking-tight text-stone-900">Fun<span class="text-orange-500">Shirt</span></span>
            </span>

            {{-- Desktop Nav Links --}}
            <div class="hidden md:flex items-center gap-6">
                <span class="text-sm font-medium text-stone-600 hover:text-stone-900 transition-colors {{ request()->routeIs('catalog.*') ? 'text-orange-600' : '' }}">
                    Catálogo
                </span>
                @auth
                    @if(auth()->user()->user_type === 'C')
                        <span class="text-sm font-medium text-stone-600 hover:text-stone-900 transition-colors {{ request()->routeIs('customer.orders.*') ? 'text-orange-600' : '' }}">
                            As Minhas Encomendas
                        </span>
                        <span class="text-sm font-medium text-stone-600 hover:text-stone-900 transition-colors {{ request()->routeIs('customer.images.*') ? 'text-orange-600' : '' }}">
                            As Minhas Imagens
                        </span>
                    @elseif(auth()->user()->user_type === 'F')
                        <span class="text-sm font-medium text-stone-600 hover:text-stone-900 transition-colors">
                            Encomendas Pendentes
                        </span>
                    @elseif(auth()->user()->user_type === 'A')
                        <span class="text-sm font-medium text-stone-600 hover:text-stone-900 transition-colors {{ request()->routeIs('admin.*') ? 'text-orange-600' : '' }}">
                            Administração
                        </span>
                    @endif
                @endauth
            </div>

            {{-- Right Side --}}
            <div class="flex items-center gap-3">
                {{-- Cart (anonymous + customers only) --}}
                @if(!auth()->check() || auth()->user()->user_type === 'C')
                    <span class="relative p-2 rounded-lg text-stone-600 hover:text-stone-900 hover:bg-stone-100 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                        </svg>
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="absolute -top-1 -right-1 bg-orange-500 text-white text-xs font-bold w-4 h-4 rounded-full flex items-center justify-center">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </span>
                @endif

                {{-- User Menu --}}
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-stone-100 transition-colors">
                            @if(auth()->user()->photo_url)
                                <img src="{{ Storage::url('public/photos/' . auth()->user()->photo_url) }}" alt="" class="w-7 h-7 rounded-full object-cover">
                            @else
                                <div class="w-7 h-7 rounded-full bg-orange-100 flex items-center justify-center">
                                    <span class="text-xs font-semibold text-orange-700">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                </div>
                            @endif
                            <span class="hidden sm:block text-sm font-medium text-stone-700 max-w-24 truncate">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open" x-cloak @click.away="open = false"
                             class="absolute right-0 mt-2 w-52 bg-white border border-stone-200 rounded-xl shadow-lg overflow-hidden z-50">
                            <div class="px-4 py-3 border-b border-stone-100">
                                <p class="text-xs text-stone-500">Sessão iniciada como</p>
                                <p class="text-sm font-semibold text-stone-900 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="py-1">
                                @if(auth()->user()->user_type === 'C')
                                    <span class="flex items-center gap-2.5 px-4 py-2 text-sm text-stone-700 hover:bg-stone-50">
                                        <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                        O Meu Perfil
                                    </span>
                                @endif
                                <span class="flex items-center gap-2.5 px-4 py-2 text-sm text-stone-700 hover:bg-stone-50">
                                    <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                                    Alterar Senha
                                </span>
                            </div>
                            <div class="py-1 border-t border-stone-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-2.5 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/></svg>
                                        Terminar Sessão
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <span class="text-sm font-medium text-stone-600 hover:text-stone-900 transition-colors">Entrar</span>
                    <span class="text-sm font-semibold bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg transition-colors shadow-sm">Registar</span>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- Flash Messages --}}
@if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
         class="fixed top-20 right-4 z-50 flex items-center gap-3 bg-white border border-green-200 text-green-800 px-4 py-3 rounded-xl shadow-lg max-w-sm">
        <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="text-sm font-medium">{{ session('success') }}</p>
        <button @click="show = false" class="ml-auto text-green-400 hover:text-green-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
@endif

@if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
         class="fixed top-20 right-4 z-50 flex items-center gap-3 bg-white border border-red-200 text-red-800 px-4 py-3 rounded-xl shadow-lg max-w-sm">
        <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
        <p class="text-sm font-medium">{{ session('error') }}</p>
        <button @click="show = false" class="ml-auto text-red-400 hover:text-red-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
@endif

{{-- Main Content --}}
<main class="min-h-[calc(100vh-4rem)]">
    @yield('content')
</main>

{{-- Footer --}}
<footer class="bg-white border-t border-stone-200 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-7 h-7 bg-orange-500 rounded-md flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8 2 4.5 4.5 4.5 8.5c0 1.5.5 3 1.5 4L3 21h18l-3-8.5c1-1 1.5-2.5 1.5-4C19.5 4.5 16 2 12 2z"/></svg>
                    </div>
                    <span class="font-bold text-stone-900">Fun<span class="text-orange-500">Shirt</span></span>
                </div>
                <p class="text-sm text-stone-500 leading-relaxed">T-shirts personalizadas de qualidade, entregues na sua porta.</p>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-stone-900 mb-3">Loja</h4>
                <ul class="space-y-2">
                    <li><span class="text-sm text-stone-500 hover:text-stone-700">Catálogo</span></li>
                    <li><span class="text-sm text-stone-500 hover:text-stone-700">Carrinho</span></li>
                </ul>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-stone-900 mb-3">Conta</h4>
                <ul class="space-y-2">
                    @guest
                        <li><span class="text-sm text-stone-500 hover:text-stone-700">Entrar</span></li>
                        <li><span class="text-sm text-stone-500 hover:text-stone-700">Registar</span></li>
                    @else
                        <li><span class="text-sm text-stone-500 hover:text-stone-700">Terminar Sessão</span></li>
                        <form id="footer-logout" method="POST" action="{{ route('logout') }}" class="hidden">@csrf</form>
                    @endguest
                </ul>
            </div>
        </div>
        <div class="border-t border-stone-100 mt-8 pt-6 text-center">
            <p class="text-xs text-stone-400">&copy; {{ date('Y') }} FunShirt. Todos os direitos reservados.</p>
        </div>
    </div>
</footer>

@livewireScripts
@stack('scripts')
</body>
</html>