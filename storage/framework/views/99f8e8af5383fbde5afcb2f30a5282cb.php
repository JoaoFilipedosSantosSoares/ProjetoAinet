<?php $__env->startComponent('layouts.main-content', ['type' => 'Persona']); ?>
<main class="min-h-screen bg-background">
    <div class="container mx-auto px-4 py-12">
        <div class="mb-8 text-center">
            <h1 class="mb-2 text-3xl font-bold text-foreground">Confirmação</h1>
            <p class="text-muted-foreground">Escolha as opções e adicione o seu produto ao carrinho</p>
        </div>

        <div class="mx-auto grid max-w-5xl gap-8 lg:grid-cols-2">
            <div class="space-y-6">
                <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm">
                    <div class="product-card overflow-hidden rounded-2xl bg-white shadow-sm">
                        <div class="relative aspect-square overflow-hidden bg-zinc-100 flex items-center justify-center">
                            <img id="tshirt-base-preview"
                                src="<?php echo e(asset('storage/tshirt_base/' . $selectedColor->code . '.jpg')); ?>"
                                alt="T-shirt Base" class="absolute inset-0 h-full w-full object-contain" />
                            <img src="<?php echo e(asset('storage/tshirt_images/' . $tshirt->image_url)); ?>"
                                alt="<?php echo e($tshirt->name); ?>" class="relative z-10 h-[50%] w-[50%] object-contain" />
                        </div>

                        <div class="p-4 border-b border-zinc-100">
                            <div class="flex items-center justify-between gap-4 mb-2">
                                <p class="text-xs uppercase tracking-widest text-muted-foreground font-semibold">
                                    <?php echo e($tshirt->category->name ?? 'Sem Categoria'); ?>

                                </p>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($tshirt->category->image_url)): ?>
                                <div class="h-10 w-10 shrink-0 overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm">
                                    <img src="<?php echo e(asset('storage/categories/' . $tshirt->category->image_url)); ?>"
                                        alt="<?php echo e($tshirt->name ?? 'Imagem Categoria'); ?>"
                                        class="h-full w-full object-cover" />
                                </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <h3 class="font-semibold text-zinc-900 text-base tracking-tight"><?php echo e($tshirt->name); ?></h3>
                        </div>

                        <div class="p-4 bg-zinc-50/30">
                            <p class="text-xs uppercase tracking-widest text-zinc-900 font-bold">
                                Descrição
                            </p>
                            <p class="mt-2 text-sm text-zinc-600 leading-relaxed italic">
                                <?php echo e($tshirt->description ?? 'Nenhuma descrição disponível para este artigo.'); ?>

                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm">
                    
                    <div class="p-6 space-y-6" x-data="{
                        quantity: 1,
                        basePrice: <?php echo e($basePrice); ?>,
                        discountPrice: <?php echo e($discountPrice); ?>,
                        qtyTrigger: <?php echo e($qtyTrigger); ?>,
                        selectedColorCode: '<?php echo e($selectedColor->code ?? ($colors->first()->code ?? '')); ?>',
                        selectedColorName: '<?php echo e($selectedColor->name ?? ($colors->first()->name ?? '')); ?>'
                    }">

                        <div>
                            <label class="mb-2 block text-sm font-medium text-zinc-900">
                                Cor da T-Shirt: <span class="text-zinc-500 font-normal" x-text="selectedColorName"></span>
                            </label>
                            <div class="flex flex-wrap gap-2">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <button type="button"
                                        @click="selectedColorCode = '<?php echo e($color->code); ?>'; selectedColorName = '<?php echo e($color->name); ?>'; document.getElementById('tshirt-base-preview').src = '<?php echo e(asset('storage/tshirt_base/' . $color->code . '.jpg')); ?>'"
                                        class="h-10 w-10 rounded-full border-2 transition-all duration-200 focus:outline-none"
                                        :class="selectedColorCode === '<?php echo e($color->code); ?>' ? 'border-zinc-950 ring-2 ring-zinc-950 ring-offset-2 scale-105' : 'border-border'"
                                        title="<?php echo e($color->name); ?>"
                                        style="background-color: #<?php echo e($color->code); ?>"></button>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                        </div>

                        <form action="<?php echo e(route('cart.store')); ?>" method="POST" class="space-y-6">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="tshirt_image_id" value="<?php echo e($tshirt->id); ?>">
                            <input type="hidden" name="color" :value="selectedColorCode">

                            <div>
                                <label for="size-select" class="mb-2 block text-sm font-medium text-zinc-900">Tamanho</label>
                                <select id="size-select" name="size" class="w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                                    <option value="S">S</option>
                                    <option value="M" selected>M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option>
                                </select>
                            </div>

                            <div>
                                <label for="quantity-input" class="mb-2 block text-sm font-medium text-zinc-900">Quantidade</label>
                                <input id="quantity-input" name="quantity" type="number" min="1" 
                                    x-model.number="quantity"
                                    class="w-24 rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" />
                                
                                <p class="mt-2 text-xs text-muted-foreground">
                                    Desconto automático aplicado a partir de <span x-text="qtyTrigger"></span> unidades.
                                </p>
                            </div>

                            <div class="rounded-3xl bg-muted p-4 space-y-2 text-sm text-zinc-600">
                                <div class="flex items-center justify-between">
                                    <span>Preço Unitário:</span>
                                    <span class="font-medium text-zinc-900" 
                                          x-text="(quantity >= qtyTrigger ? discountPrice : basePrice).toFixed(2) + '€'">
                                    </span>
                                </div>

                                <div class="flex items-center justify-between text-xs text-emerald-600 font-medium" 
                                     x-show="quantity >= qtyTrigger" x-cloak>
                                    <span>Desconto de quantidade:</span>
                                    <span>Aplicado! (Especial <span x-text="discountPrice.toFixed(2)"></span>€)</span>
                                </div>

                                <div class="flex items-center justify-between border-t border-zinc-200 pt-2 text-zinc-900 font-semibold mt-1">
                                    <span>Total:</span>
                                    <span class="text-xl font-bold text-[#144226]" 
                                          x-text="((quantity >= qtyTrigger ? discountPrice : basePrice) * (quantity || 1)).toFixed(2) + '€'">
                                    </span>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <button type="submit"
                                    class="inline-flex w-full justify-center rounded-2xl bg-zinc-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800 disabled:cursor-not-allowed disabled:opacity-50"
                                    <?php echo e((isset($tshirt) && $tshirt->image_url) ? '' : 'disabled'); ?>

                                    <?php echo e(auth()->check() && (auth()->user()->user_type === 'F' || auth()->user()->user_type === 'A') ? 'disabled' : ''); ?>>
                                    Adicionar ao Carrinho
                                </button>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->user_type === 'F' || auth()->user()->user_type === 'A'): ?>
                                <p class="text-center text-xs text-red-500 mt-1">
                                    Contas de funcionários/admins não podem efetuar compras.
                                </p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php echo $__env->renderComponent(); ?><?php /**PATH C:\laragon\www\ProjetoAinet\resources\views/catalog/show.blade.php ENDPATH**/ ?>