<?php $__env->startComponent('layouts.main-content', ['title' => 'Detalhes da Encomenda #' . $order->id]); ?>

<main class="min-h-screen bg-background py-12">
    <div class="container mx-auto px-4 max-w-4xl">

        <div class="mb-6">
            <a href="<?php echo e(route('account.index')); ?>"
                class="text-sm font-semibold text-zinc-600 hover:text-zinc-900 transition flex items-center gap-2">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Voltar à Minha Conta
            </a>
        </div>

        <div
            class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm mb-6 flex flex-col sm:flex-row justify-between sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900">Encomenda #<?php echo e($order->id); ?></h1>
                <p class="text-sm text-zinc-500">Realizada em:
                    <?php echo e(date('d/m/Y', strtotime($order->date ?? $order->created_at))); ?>

                </p>
            </div>
            <div>
                <span
                    class="inline-flex items-center rounded-full border border-green-200 bg-green-50 px-3 py-1 text-xs font-bold text-green-700 uppercase tracking-wider">
                    <?php echo e($order->status); ?>

                </span>
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-3 items-start">

            <div class="md:col-span-2 space-y-4">
                <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm overflow-hidden">
                    <div class="border-b border-zinc-200 p-6">
                        <h2 class="text-lg font-bold text-zinc-900">Artigos Comprados</h2>
                    </div>

                    <div class="divide-y divide-zinc-100">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $order->order_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="p-6 flex gap-4 items-center justify-between">

                            <div class="flex items-center gap-4">
                                <div
                                    class="relative aspect-square h-20 w-20 shrink-0 overflow-hidden rounded-xl bg-zinc-100 border border-zinc-200 flex items-center justify-center p-1 shadow-inner">
                                    <img src="<?php echo e(asset('storage/tshirt_base/' . ($item->color_code ?? $item->color) . '.jpg')); ?>"
                                        alt="T-shirt Base" class="absolute inset-0 h-full w-full object-contain"
                                        onerror="this.src='/img/tshirt.png'" />

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->tshirt_image): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($item->tshirt_image->customer_id)): ?>
                                    <img src="<?php echo e(route('tshirt_images.show', ['filename' => $item->tshirt_image->image_url])); ?>"
                                        alt="<?php echo e($item->tshirt_image->name); ?>"
                                        class="relative z-10 h-[55%] w-[55%] object-contain pointer-events-none" />
                                    <?php else: ?>
                                    <img src="<?php echo e(asset('storage/tshirt_images/' . ($item->tshirt_image->image_url ?? 'default.png'))); ?>"
                                        alt="Estampa"
                                        class="relative z-10 h-[55%] w-[55%] object-contain pointer-events-none" />
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php else: ?>
                                    <span class="relative z-10 text-[10px] font-bold text-red-500 text-center px-1">Sem
                                        imagem</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <div>
                                    <h3 class="font-bold text-sm text-zinc-900">
                                        T-Shirt Tamanho <?php echo e($item->size); ?>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$item->tshirt_image): ?>
                                        <span
                                            class="ml-2 inline-block text-xs font-semibold text-red-600 bg-red-50 px-2 py-0.5 rounded-md border border-red-200 animate-pulse">
                                            (A imagem foi apagada)
                                        </span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </h3>
                                    <p class="text-xs text-zinc-500">Quantidade: <span
                                            class="font-bold text-zinc-800"><?php echo e($item->qty ?? $item->quantity); ?></span>
                                    </p>
                                </div>
                            </div>

                            <div class="text-right">
                                <span
                                    class="block font-bold text-sm text-zinc-900"><?php echo e(number_format($item->sub_total ?? $item->price ?? 0, 2, ',', '.')); ?>

                                    €</span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($item->unit_price)): ?>
                                <span class="text-xs text-zinc-400">(<?php echo e(number_format($item->unit_price, 2, ',', '.')); ?>

                                    €/un)</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <div class="p-8 text-center text-sm text-zinc-500">
                            Nenhum item associado a esta encomenda na base de dados.
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-zinc-400 mb-4">Resumo Financeiro</h2>

                    <div class="space-y-3 text-sm text-zinc-600 border-b border-zinc-100 pb-4">
                        <div class="flex justify-between">
                            <span>Método:</span>
                            <span class="font-semibold text-zinc-900"><?php echo e($order->payment_type ?? 'N/A'); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span>NIF da Fatura:</span>
                            <span class="font-semibold text-zinc-900"><?php echo e($order->nif ?? 'Consumidor Final'); ?></span>
                        </div>
                    </div>

                    <div class="py-4 flex justify-between items-baseline mb-4">
                        <span class="text-sm font-semibold text-zinc-900">Total Pago:</span>
                        <span
                            class="text-xl font-extrabold text-[#144226]"><?php echo e(number_format($order->total_price ?? $order->total ?? 0, 2, ',', '.')); ?>

                            €</span>
                    </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->receipt_url): ?>
                        <div class="pt-2">
                            <a href="<?php echo e(route('orders.receipt', $order)); ?>"
                                class="inline-flex w-full justify-center items-center gap-2 rounded-2xl border border-zinc-300 bg-white px-4 py-3 text-sm font-semibold text-zinc-700 shadow-sm transition hover:bg-zinc-50 focus:outline-none">
                                <svg class="h-4 w-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Descarregar Recibo PDF
                            </a>
                        </div>
                        <?php else: ?>
                        <div class="pt-2 text-center text-xs text-zinc-400 italic">
                            O recibo estará disponível assim que for processado pela nossa equipa.
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                </div>
            </div>

        </div>

    </div>
</main>

<?php echo $__env->renderComponent(); ?><?php /**PATH C:\laragon\www\ProjetoAinet_prat\resources\views/orders/show.blade.php ENDPATH**/ ?>