@component('layouts.app.header', ['title' => $title ?? null, 'active' => $type ?? null])
    <flux:main>
        @include('partials.main-content-headings')
        @include('partials.main-content-alerts')
        {{ $slot }}
    </flux:main>
@endcomponent
