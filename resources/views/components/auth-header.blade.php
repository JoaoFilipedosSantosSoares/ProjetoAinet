@props([
    'title',
    'description',
])

<div class="border-b border-zinc-200 p-6 text-center flex w-full flex-col gap-2">
    <h1 class="font-bold text-zinc-950 text-3xl">
        {{ $title }}
    </h1>
    
    <p class="text-zinc-600 text-base">
        {{ $description }}
    </p>
</div>