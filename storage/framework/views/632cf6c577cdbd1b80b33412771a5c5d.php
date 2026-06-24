<?php $__env->startComponent('layouts.main-content', ['title' => 'Carrinho']); ?>
    <?php
        $userIsAuthenticated = auth()->check();
        $grandTotal = 0;

        $calculateItemPrice = function($isCatalog, $quantity, $rules) {
            if (!$rules) {
                if ($quantity >= 5) {
                    return $isCatalog ? 20.00 : 40.00;
                }
                return $isCatalog ? 25.00 : 50.00;
            }

            if ($quantity >= $rules->qty_discount) {
                return $isCatalog ? $rules->unit_price_catalog_discount : $rules->unit_price_own_discount;
            }

            return $isCatalog ? $rules->unit_price_catalog : $rules->unit_price_own;
        };
    ?>

    <main class="min-h-screen bg-background py-12">
        <div class="container mx-auto px-4 max-w-6xl">
            <h1 class="mb-8 text-3xl font-bold tracking-tight text-zinc-900">O seu Carrinho</h1>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                <div class="mb-6 rounded-2xl bg-emerald-50 p-4 text-sm font-medium text-emerald-800 border border-emerald-200">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(empty($cartItems) || count($cartItems) === 0): ?>
                <div class="flex flex-col items-center justify-center py-20 text-center border border-dashed border-zinc-200 rounded-3xl bg-white shadow-sm">
                    <svg class="mb-4 h-16 w-16 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <h2 class="text-xl font-semibold text-zinc-900">O seu carrinho está vazio</h2>
                    <p class="mt-2 text-sm text-zinc-500">Explore os nossos produtos e encontre a estampa perfeita!</p>
                    <a href="<?php echo e(route('catalog.index')); ?>" class="mt-6 rounded-xl bg-zinc-950 px-4 py-2.5 text-sm font-semibold text-white hover:bg-zinc-800 transition shadow-sm">
                        Voltar ao Catálogo
                    </a>
                </div>
            <?php else: ?>
                <div class="grid gap-8 lg:grid-cols-3">
                    
                    <div class="lg:col-span-2 space-y-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-zinc-500"><?php echo e(count($cartItems)); ?> item(ns) no total</span>
                            
                            <form method="POST" action="<?php echo e(route('cart.clear')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="text-sm font-semibold text-red-600 hover:text-red-700 transition flex items-center gap-1">
                                    Limpar Carrinho
                                </button>
                            </form>
                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <?php
                                $unitPrice = $calculateItemPrice($item['isCatalogImage'], $item['quantity'], $priceRules);
                                $subTotal = $unitPrice * $item['quantity'];
                                $grandTotal += $subTotal;
                                
                                $hasDiscountApplied = $priceRules && ($item['quantity'] >= $priceRules->qty_discount);
                            ?>

                            <form method="POST" action="<?php echo e(route('cart.update', ['itemId' => $id])); ?>" class="relative rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm flex flex-col md:flex-row gap-6 items-start md:items-center justify-between transition hover:shadow-md">
                                <?php echo csrf_field(); ?>

                                <div class="flex items-center gap-6 w-full md:w-auto">
                                    
                                    <div class="relative aspect-square h-32 w-32 shrink-0 overflow-hidden rounded-2xl bg-zinc-100 border border-zinc-200 flex items-center justify-center p-2 shadow-inner">
                                        <img src="<?php echo e(asset('storage/tshirt_base/' . $item['color'] . '.jpg')); ?>" class="absolute inset-0 h-full w-full object-contain" onerror="this.src='/img/tshirt.png'" />
                                        
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item['isCatalogImage']): ?>
                                            <img src="<?php echo e(asset('storage/tshirt_images/' . $item['imageUrl'])); ?>" class="absolute h-16 w-16 object-contain pointer-events-none" />
                                        <?php else: ?>
                                            <img src="<?php echo e(route('tshirt_images.show', ['filename' => $item['imageUrl']])); ?>" class="absolute h-16 w-16 object-contain pointer-events-none" />
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>

                                    <div class="overflow-hidden">
                                        <h3 class="font-bold text-base text-zinc-900 truncate max-w-55"><?php echo e($item['name']); ?></h3>
                                        <p class="text-xs text-zinc-500 mt-0.5"><?php echo e($item['isCatalogImage'] ? 'Imagem de Catálogo' : 'Design Personalizado'); ?></p>
                                        
                                        <div class="mt-3 flex flex-col gap-0.5">
                                            <div class="flex items-baseline gap-2">
                                                <span class="text-base font-extrabold text-zinc-950"><?php echo e(number_format($subTotal, 2)); ?>€</span>
                                                <span class="text-xs text-zinc-400">(<?php echo e(number_format($unitPrice, 2)); ?>€/un)</span>
                                            </div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasDiscountApplied): ?>
                                                <span class="w-fit inline-block mt-1 text-[10px] font-bold bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full border border-emerald-100">Desconto aplicado</span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-wrap items-center gap-4 w-full md:w-auto justify-between md:justify-end border-t md:border-t-0 pt-4 md:pt-0 border-zinc-100">
                                    
                                    <div class="flex flex-col gap-1">
                                        <span class="text-[10px] uppercase font-bold tracking-wider text-zinc-400">Cor</span>
                                        <select name="color" class="rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-xs font-semibold text-zinc-800 outline-none focus:border-zinc-400 transition">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tshirtColors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                <option value="<?php echo e($color->code); ?>" <?php echo e($item['color'] === $color->code ? 'selected' : ''); ?>>
                                                    <?php echo e($color->name); ?>

                                                </option>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </select>
                                    </div>

                                    <div class="flex flex-col gap-1">
                                        <span class="text-[10px] uppercase font-bold tracking-wider text-zinc-400">Tam</span>
                                        <select name="size" class="rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-xs font-semibold text-zinc-800 outline-none focus:border-zinc-400 transition">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tshirtSizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                <option value="<?php echo e($size); ?>" <?php echo e($item['size'] === $size ? 'selected' : ''); ?>>
                                                    <?php echo e($size); ?>

                                                </option>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </select>
                                    </div>

                                    <div class="flex flex-col gap-1">
                                        <span class="text-[10px] uppercase font-bold tracking-wider text-zinc-400">Qty</span>
                                        <input type="number" name="quantity" min="0" value="<?php echo e($item['quantity']); ?>" 
                                            class="w-16 rounded-xl border border-zinc-200 bg-zinc-50 px-2 py-2 text-xs font-bold text-zinc-900 outline-none text-center focus:border-zinc-400 transition" />
                                    </div>

                                    <div class="flex items-center gap-1.5 pt-4">
                                        <button type="submit" title="Guardar Alterações" class="rounded-xl bg-zinc-100 p-2 text-zinc-700 transition hover:bg-zinc-200 hover:text-zinc-950">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </button>
                            </form>

                                        <form method="POST" action="<?php echo e(route('cart.remove', ['itemId' => $id])); ?>">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" title="Remover Item" class="rounded-xl bg-red-50 p-2 text-red-600 transition hover:bg-red-100">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>

                    <div class="space-y-6">
                        <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm">
                            <h2 class="text-lg font-semibold text-zinc-900 mb-4">Resumo do Pedido</h2>
                            
                            <div class="space-y-3 border-b border-zinc-100 pb-4 text-sm text-zinc-600">
                                <div class="flex justify-between">
                                    <span>Subtotal de Artigos</span>
                                    <span class="font-medium text-zinc-900"><?php echo e(number_format($grandTotal, 2)); ?>€</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Portes de Envio</span>
                                    <span class="text-emerald-600 font-bold">Grátis</span>
                                </div>
                            </div>

                            <div class="pt-4">
                                <div class="flex items-baseline justify-between text-zinc-900 mb-6">
                                    <span class="text-base font-semibold">Valor Total Estimado:</span>
                                    <span class="text-2xl font-bold text-[#144226]"><?php echo e(number_format($grandTotal, 2)); ?>€</span>
                                </div>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($userIsAuthenticated): ?>
                                    <a href="<?php echo e(route('orders.checkout')); ?>" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-[#144226] px-5 py-3.5 text-sm font-semibold text-white transition hover:bg-[#0e2f1b] shadow-sm text-center">
                                        Proceder para o Checkout
                                    </a>
                                <?php else: ?>
                                    <div class="space-y-3">
                                        <a href="/login?redirect=/checkout" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-zinc-950 px-5 py-3.5 text-sm font-semibold text-white transition hover:bg-zinc-800 shadow-sm text-center">
                                            Entrar para Finalizar Compra
                                        </a>
                                        <p class="text-center text-xs text-zinc-500">
                                            Não tem conta? <a href="/register?redirect=/checkout" class="text-zinc-900 font-medium underline">Registe-se aqui</a> e mantenha o seu carrinho!
                                        </p>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </main>
<?php echo $__env->renderComponent(); ?><?php /**PATH C:\laragon\www\ProjetoAinet\resources\views/cart/index.blade.php ENDPATH**/ ?>