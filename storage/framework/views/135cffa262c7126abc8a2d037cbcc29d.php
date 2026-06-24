<?php $__env->startComponent('layouts.main-content'); ?>
<div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
    <div class="text-center">
        <h1 class="text-3xl font-bold tracking-tight md:text-4xl">Catálogo de Designs</h1>
        <p class="mt-2 text-muted-foreground">Escolhe um design do nosso catálogo e personaliza a tua t-shirt</p>
    </div>

    <div class="mt-8 flex justify-center">
        <form method="GET" class="flex w-full max-w-4xl flex-col gap-3 sm:flex-row sm:items-center">

            <div class="w-full sm:w-48">
                <select
                    name="category"
                    class="w-full rounded-lg border border-zinc-300 px-4 py-2 text-sm focus:border-zinc-900 focus:outline-none focus:ring-1 focus:ring-zinc-900">
                    <option value="" <?php echo e(request('category') === '' ? 'selected' : ''); ?>>Todas as Categorias</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <option value="<?php echo e($category); ?>" <?php echo e(request('category') === $category ? 'selected' : ''); ?>>
                        <?php echo e($category); ?>

                    </option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </div>

            <div class="relative flex-1">
                <input
                    type="text"
                    name="search"
                    value="<?php echo e(request('search')); ?>"
                    placeholder="Pesquisar por nome da t-shirt..."
                    class="w-full rounded-lg border border-zinc-300 px-4 py-2 text-sm focus:border-zinc-900 focus:outline-none focus:ring-1 focus:ring-zinc-900" />
            </div>

            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-lg bg-zinc-900 px-5 py-2 text-sm font-semibold text-white transition hover:bg-zinc-950 sm:w-auto">
                Pesquisar
            </button>

            <a
                href="<?php echo e(url()->current()); ?>"
                class="inline-flex items-center justify-center rounded-lg border border-zinc-300 bg-white px-5 py-2 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-50 sm:w-auto text-center">
                Limpar
            </a>

        </form>
    </div>

    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3" id="product-grid">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $tshirts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tshirt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
        <a href="<?php echo e(route('catalog.show', $tshirt)); ?>">
            <div class="product-card group cursor-pointer overflow-hidden rounded-2xl bg-white shadow-sm transition hover:shadow-md"
                data-category="<?php echo e($tshirt->category->name ?? 'Sem Categoria'); ?>" data-id="<?php echo e($tshirt->id); ?>">
                <div class="relative aspect-square overflow-hidden bg-zinc-100">
                    <img src="<?php echo e(asset('storage/tshirt_images/' . $tshirt->image_url)); ?>" alt="<?php echo e($tshirt->name); ?>"
                        class="h-full w-full object-contain transition group-hover:scale-105" />
                </div>
                <div class="p-5 border-t border-zinc-100 bg-zinc-50/30">
                    <div class="flex items-center justify-between gap-4 mb-2">
                        <p class="text-[12px] font-bold uppercase tracking-widest text-zinc-900">
                            <?php echo e($tshirt->category->name ?? 'Sem Categoria'); ?>

                        </p>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($tshirt->category->image_url)): ?>
                        <div class="h-10 w-10 shrink-0 overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm">
                            <img src="<?php echo e(asset('storage/categories/' . $tshirt->category->image_url)); ?>"
                                alt="<?php echo e($tshirt->name ?? 'Imagem'); ?>"
                                class="h-full w-full object-cover" />
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <h3 class="font-bold text-base text-zinc-900 tracking-tight">
                        <?php echo e($tshirt->name); ?>

                    </h3>

                    <p class="mt-1.5 text-xs text-zinc-500 leading-relaxed italic">
                        <?php echo e($tshirt->description ?? 'Sem descrição disponível.'); ?>

                    </p>
                </div>
            </div>
        </a>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        <div class="col-span-full text-center py-12 text-muted-foreground">
            Nenhum design encontrado.
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div class="mt-12 flex justify-center">
        <?php echo e($tshirts->links()); ?>

    </div>

    <div id="empty-state" class="mt-12 text-center text-muted-foreground hidden">
        Nenhum design encontrado nesta categoria.
    </div>

    <div id="product-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
        <div class="relative w-full max-w-3xl overflow-hidden rounded-3xl bg-white shadow-2xl">
            <button type="button"
                class="modal-close-button absolute right-4 top-4 inline-flex h-10 w-10 items-center justify-center rounded-full bg-zinc-100 text-zinc-700 transition hover:bg-zinc-200"
                aria-label="Fechar modal">
                ×
            </button>
            <div class="grid gap-6 p-6 md:grid-cols-[1.4fr_0.8fr]">
                <div class="relative aspect-square overflow-hidden rounded-3xl bg-zinc-100">
                    <img id="modal-image" src="" alt="" class="object-cover w-full h-full" />
                </div>
                <div class="flex flex-col gap-4">
                    <div>
                        <p id="modal-category" class="text-sm uppercase tracking-[0.2em] text-muted-foreground"></p>
                        <h2 id="modal-name" class="mt-2 text-3xl font-bold"></h2>
                    </div>
                    <p class="text-sm leading-6 text-muted-foreground">
                        Escolhe este design para personalizar a tua t-shirt com facilidade. Adiciona quantidades e
                        finaliza a encomenda quando estiver pronto.
                    </p>
                    <div class="mt-auto flex flex-col gap-3 sm:flex-row">
                        <button type="button" id="modal-buy"
                            class="inline-flex justify-center rounded-lg bg-zinc-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-zinc-950">
                            Escolher design
                        </button>
                        <button type="button"
                            class="modal-close-button inline-flex justify-center rounded-lg border border-zinc-300 bg-white px-5 py-3 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-50">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $__env->renderComponent(); ?><?php /**PATH C:\laragon\www\ProjetoAinet\resources\views/catalog/index.blade.php ENDPATH**/ ?>