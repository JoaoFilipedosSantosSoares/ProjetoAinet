<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'label',
    'name',
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'errorBag' => 'updateProfileInformation',
    'readonly' => false,
    'maxlength' => null
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'label',
    'name',
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'errorBag' => 'updateProfileInformation',
    'readonly' => false,
    'maxlength' => null
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="space-y-2">
    <label class="block text-sm font-medium text-zinc-900"><?php echo e($label); ?></label>
    <div class="relative">
        <input
            type="<?php echo e($type); ?>"
            name="<?php echo e($name); ?>"
            value="<?php echo e($value); ?>"
            placeholder="<?php echo e($placeholder); ?>"
            data-editable="true"
            <?php if($maxlength): ?> maxlength="<?php echo e($maxlength); ?>" <?php endif; ?>
            <?php if($readonly): ?> readonly <?php endif; ?>
            class="profile-input w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 pr-10 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20 <?php echo e($readonly ? 'cursor-not-allowed opacity-80' : ''); ?>" />
    </div>
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = [$name, $errorBag];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="text-xs text-red-500 mt-1 block"><?php echo e($message); ?></span>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div><?php /**PATH C:\laragon\www\ProjetoAinet_prat\resources\views/components/profile-input.blade.php ENDPATH**/ ?>