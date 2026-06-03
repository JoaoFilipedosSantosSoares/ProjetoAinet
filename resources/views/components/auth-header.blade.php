@props([
    'title',
    'description',
])

<div class="border-b border-zinc-200 p-6 text-center flex w-full flex-col gap-2">
    <flux:heading size="2xl" class="font-bold text-zinc-950 text-3xl">
        {{ $title }}
    </flux:heading>
    
    <flux:subheading class="text-zinc-600 text-base">
        {{ $description }}
    </flux:subheading>
</div>