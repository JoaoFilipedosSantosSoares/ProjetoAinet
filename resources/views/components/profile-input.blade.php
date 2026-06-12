@props([
    'label',
    'name',
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'errorBag' => 'updateProfileInformation',
    'readonly' => false,
    'maxlength' => null
])

<div class="space-y-2">
    <label class="block text-sm font-medium text-zinc-900">{{ $label }}</label>
    <div class="relative">
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            data-editable="true"
            @if($maxlength) maxlength="{{ $maxlength }}" @endif
            @if($readonly) readonly @endif
            class="profile-input w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 pr-10 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 {{ $readonly ? 'cursor-not-allowed opacity-80' : '' }}" />
    </div>
    
    @error($name, $errorBag)
        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
    @enderror
</div>