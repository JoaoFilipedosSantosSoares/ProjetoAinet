@props([
    'status',
])

@if ($status)
    <div {{ $attributes->merge(['class' => 'text-base text-green-600']) }}>
        {{ $status }}
    </div>
@endif
