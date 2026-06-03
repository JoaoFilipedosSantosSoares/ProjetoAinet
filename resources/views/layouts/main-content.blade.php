@component('layouts.app.header')
    <flux:main>
        @include('partials.main-content-headings')
        @include('partials.main-content-alerts')
        {{ $slot }}
    </flux:main>
@endcomponent
