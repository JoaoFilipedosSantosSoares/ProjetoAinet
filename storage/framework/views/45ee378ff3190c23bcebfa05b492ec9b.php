<div class="rounded-3xl border border-zinc-200 bg-white shadow-sm">
    <div class="flex flex-col gap-4 border-b border-zinc-200 p-6 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <?php
                $statusText = match ($order->status) {
                    'pending' => 'Pendente',
                    'closed' => 'Concluída',
                    'canceled' => 'Cancelada',
                    default => ucfirst($order->status)
                };

                $badgeClasses = match ($order->status) {
                    'pending' => 'bg-amber-100 text-amber-800',
                    'closed' => 'bg-emerald-100 text-emerald-800',
                    'canceled' => 'bg-red-100 text-red-800',
                    default => 'bg-zinc-100 text-zinc-800'
                };
            ?>

            <p class="text-sm uppercase tracking-[0.2em] text-muted-foreground">
                Pedido: <?php echo e($statusText); ?>

            </p>
            <h2 class="text-xl font-semibold text-foreground">Encomenda #<?php echo e($order->id); ?></h2>
            <p class="mt-2 text-sm text-muted-foreground">
                Cliente: <?php echo e($order->customer->user?->name ?? 'Cliente Eliminado'); ?>

            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold <?php echo e($badgeClasses); ?>">
                <?php echo e($statusText); ?>

            </span>
            <span class="text-sm font-semibold text-zinc-900">€<?php echo e(number_format($order->total_price, 2)); ?></span>
        </div>
    </div>

    <div class="grid gap-4 p-6 sm:grid-cols-[1.2fr_0.8fr]">
        <div class="space-y-4">
            <div class="rounded-3xl border border-zinc-200 bg-zinc-50 p-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $order->order_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
    <div class="mb-4">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($item->tshirt_image->customer_id)): ?>
            <img src="<?php echo e(route('tshirt_images.show', ['filename' => $item->tshirt_image->image_url])); ?>"
                alt="<?php echo e($item->tshirt_image->name ?? 'T-shirt personalizada'); ?>"
                class="mb-2 h-32 w-32 rounded-lg object-cover" />
        <?php else: ?>
            <img src="<?php echo e(asset('storage/tshirt_images/' . ($item->tshirt_image->image_url ?? 'default.png'))); ?>"
                alt="<?php echo e($item->tshirt_image->name ?? 'Imagem Apagada'); ?>"
                class="mb-2 h-32 w-32 rounded-lg object-cover" />
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <p class="mt-1 text-sm text-muted-foreground">
            Tamanho: <?php echo e($item->size); ?> · 
            Quantidade: <?php echo e($item->qty ?? $item->quantity); ?> · 
            P. unitário: <?php echo e(number_format($item->unit_price, 2, ',', '.')); ?>€
        </p>
    </div>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <p class="mt-2 text-sm font-medium text-zinc-900">Sub-total:
                    €<?php echo e(number_format($order->total_price, 2)); ?></p>
            </div>
        </div>

        <div class="space-y-4">
            <div class="rounded-3xl border border-zinc-200 bg-white p-4 shadow-sm">
                <div class="space-y-2">
                    <p class="text-sm text-muted-foreground">Notas</p>
                    <p class="rounded-2xl bg-zinc-50 p-4 text-sm text-zinc-700">
                        <?php echo e($order->notes ?? 'Sem observações.'); ?></p>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->status === 'canceled'): ?>
                <div class="rounded-3xl border border-zinc-200 bg-white p-4 shadow-sm">
                    <div class="space-y-2">
                        <p class="text-sm text-muted-foreground">Motivo da Anulação</p>
                        <p class="rounded-2xl bg-zinc-50 p-4 text-sm text-zinc-700">
                            <?php echo e($order->reason_for_cancellation ?? 'Sem observações.'); ?></p>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin')): ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->receipt_url): ?>
                <a href="<?php echo e(route('orders.receipt', $order)); ?>"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-zinc-300 bg-white px-5 py-3 text-sm font-semibold text-zinc-700 shadow-sm transition hover:bg-zinc-50 focus:outline-none">
                    <svg class="h-4 w-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Descarregar Recibo PDF
                </a>
            <?php else: ?>
                <div class="text-center text-xs text-zinc-400 italic py-2">
                    Nenhum recibo PDF associado a esta encomenda.
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($order->status, ['pending'])): ?>
                <form action="<?php echo e(route('orders.update', $order)); ?>" method="POST" class="space-y-3 rounded-3xl">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>

                    <input type="hidden" name="status" value="closed">

                    <button type="submit"
                        class="inline-flex w-full items-center justify-center rounded-2xl bg-[#144226] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#0e2f1b]">
                        Marcar como Concluída
                    </button>
                </form>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->user_type === 'A'): ?>
                    <button type="button" onclick="openCancelModal(<?php echo e($order->id); ?>)"
                        class="inline-flex w-full items-center justify-center rounded-2xl border border-red-200 bg-red-50 px-5 py-3 text-sm font-semibold text-red-700 transition hover:bg-red-100 shadow-sm">
                        Anular / Cancelar Encomenda
                    </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\ProjetoAinet\resources\views/orders/partials/cards.blade.php ENDPATH**/ ?>