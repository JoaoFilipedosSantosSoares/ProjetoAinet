<?php $__env->startComponent('layouts.main-content'); ?>
<div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">

    <div class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight text-zinc-900 md:text-4xl">Configurações do Sistema</h1>
        <p class="mt-2 text-sm text-zinc-600">Administração global do Catálogo, Cores, Categorias e Regras de Preços da
            FunShirt.</p>
    </div>

    <div class="mb-12 rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
        <div class="border-b border-zinc-200 pb-4 mb-6">
            <h2 class="text-lg font-bold text-zinc-900">Preços e Descontos por Quantidade</h2>
            <p class="text-xs text-zinc-500">Define o valor base de venda e as tranches de desconto aplicadas no
                carrinho.</p>
        </div>

        <form method="POST" action="<?php echo e(route('staff.gestao.updatePrices')); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="grid gap-6 md:grid-cols-3">

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-700 mb-2">Preço Unit.
                        Catálogo (€)</label>
                    <input type="number" step="0.01" min="0" name="unit_price_catalog"
                        value="<?php echo e($prices->unit_price_catalog ?? '25.00'); ?>"
                        class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-700 mb-2">Preço Unit.
                        Própria (€)</label>
                    <input type="number" step="0.01" min="0" name="unit_price_own"
                        value="<?php echo e($prices->unit_price_own ?? '30.00'); ?>"
                        class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-700 mb-2">Quant. p/
                        Desconto (Unid.)</label>
                    <input type="number" min="1" name="qty_discount" value="<?php echo e($prices->qty_discount ?? '5'); ?>"
                        class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-700 mb-2">Preço Desc.
                        Catálogo (€)</label>
                    <input type="number" step="0.01" min="0" name="unit_price_catalog_discount"
                        value="<?php echo e($prices->unit_price_catalog_discount ?? '20.00'); ?>"
                        class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-zinc-700 mb-2">Preço Desc.
                        Própria (€)</label>
                    <input type="number" step="0.01" min="0" name="unit_price_own_discount"
                        value="<?php echo e($prices->unit_price_own_discount ?? '25.00'); ?>"
                        class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none">
                </div>

                <div class="flex items-end justify-end">
                    <button type="submit"
                        class="w-full rounded-xl bg-zinc-950 px-6 py-2.5 text-sm font-semibold text-white hover:bg-zinc-800 transition shadow-sm">
                        Salvar Alterações de Preço
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="mb-12 grid gap-8 lg:grid-cols-2">

        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm flex flex-col justify-between h-full">
            <div>
                <div class="flex items-center justify-between border-b border-zinc-200 pb-4 mb-4">
                    <div>
                        <h2 class="text-lg font-bold text-zinc-900">Categorias</h2>
                        <p class="text-xs text-zinc-500">Géneros das estampas oficiais do catálogo.</p>
                    </div>
                </div>

                <form method="POST" action="<?php echo e(route('staff.gestao.storeCategory')); ?>" enctype="multipart/form-data"
                    class="mb-4 space-y-2">
                    <?php echo csrf_field(); ?>
                    <div class="flex gap-2">
                        <input type="text" name="name" required placeholder="Nova categoria..."
                            class="flex-1 rounded-xl border border-zinc-300 bg-white px-4 py-2 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none">
                        <button type="submit"
                            class="rounded-xl bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-800 transition">
                            +
                        </button>
                    </div>

                    <input type="file" name="category_image" accept="image/*"
                        class="w-full text-xs text-zinc-500 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-zinc-100 hover:file:bg-zinc-200 cursor-pointer">
                </form>

                <div class="overflow-hidden rounded-xl border border-zinc-200 max-h-[370px] overflow-y-auto">
                    <table class="w-full border-collapse text-left text-sm text-zinc-500">
                        <tbody class="divide-y divide-zinc-200 bg-white">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr class="hover:bg-zinc-50 transition">
                                    <td class="px-4 py-3">

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($category->image_url): ?>
                                            <div class="h-10 w-10 shrink-0 overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm">
                                                <img src="<?php echo e(asset('storage/categories/' . $category->image_url)); ?>"
                                                    alt="<?php echo e($category->name ?? 'Imagem Categoria'); ?>"
                                                    class="h-full w-full object-cover" />
                                            </div>
                                        <?php else: ?>
                                            <div
                                                class="w-10 h-10 rounded-lg bg-zinc-100 flex items-center justify-center text-[10px] text-zinc-400">
                                                Sem</div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-zinc-900"><?php echo e($category->name); ?></td>
                                    <td class="px-4 py-3 text-right">
                                        <button onclick="openCategoryModal('<?php echo e($category->id); ?>', '<?php echo e($category->name); ?>')"
                                            class="inline-flex h-7 px-2 items-center justify-center rounded-lg border border-zinc-200 bg-zinc-50 text-xs font-semibold text-zinc-700 hover:bg-zinc-100 transition shadow-sm mr-1">
                                            Editar
                                        </button>
                                        <form method="POST" action="<?php echo e(route('staff.gestao.destroyCategory', $category)); ?>"
                                            class="inline" onsubmit="return confirm('Eliminar esta categoria?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit"
                                                class="inline-flex h-7 w-7 items-center justify-center rounded-lg border border-red-100 bg-red-50 hover:bg-red-100 transition shadow-sm">
                                                <img src="/img/close.png" alt="Eliminar" class="h-3 w-3" />
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <tr>
                                    <td class="p-4 text-center text-xs text-zinc-400">Nenhuma categoria registada.</td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-zinc-200 pb-4 mb-4">
                    <div>
                        <h2 class="text-lg font-bold text-zinc-900">Cores Disponíveis</h2>
                        <p class="text-xs text-zinc-500">Palete de cores das t-shirts de algodão base.</p>
                    </div>
                </div>

                <form method="POST" action="<?php echo e(route('staff.gestao.storeColor')); ?>" enctype="multipart/form-data"
                    class="mb-6 space-y-4">
                    <?php echo csrf_field(); ?>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                        <div>
                            <label
                                class="block text-[11px] font-bold uppercase tracking-wider text-zinc-500 mb-1.5">Código
                                HEX (Sem #)</label>
                            <input type="text" name="code" required placeholder="ex: FFFFFF" maxlength="6" pattern="[0-9a-fA-F]{6}" title="Insira um código hexadecimal válido com 6 caracteres (ex: FF0000)" x-on:input="$el.value = $el.value.replace(/[^0-9a-fA-F]/g, '').toUpperCase()"
    
    class="w-full h-10 rounded-xl border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none placeholder:text-zinc-400">
                        </div>

                        <div>
                            <label
                                class="block text-[11px] font-bold uppercase tracking-wider text-zinc-500 mb-1.5">Nome
                                da Cor</label>
                            <input type="text" name="name" required placeholder="ex: Branco"
                                class="w-full h-10 rounded-xl border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none placeholder:text-zinc-400">
                        </div>

                        <div>
                            <label
                                class="block text-[11px] font-bold uppercase tracking-wider text-zinc-500 mb-1.5">T-shirt
                                Base (Mula)</label>
                            <div
                                class="relative w-full h-10 flex items-center rounded-xl border border-zinc-300 bg-white px-3 text-sm text-zinc-900 focus-within:border-zinc-950">
                                <input type="file" name="tshirt_image" required accept="image/*"
                                    class="w-full text-xs text-zinc-500 file:mr-3 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-zinc-100 file:text-zinc-700 hover:file:bg-zinc-200 file:cursor-pointer focus:outline-none">
                            </div>
                        </div>

                    </div>

                    <div class="flex justify-center pt-2">
                        <button type="submit"
                            class="h-10 rounded-xl bg-zinc-950 px-6 text-sm font-semibold text-white hover:bg-zinc-800 transition shadow-sm flex items-center justify-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Adicionar Nova Cor
                        </button>
                    </div>

                </form>

                <div class="overflow-hidden rounded-xl border border-zinc-200 max-h-64 overflow-y-auto">
                    <table class="w-full border-collapse text-left text-sm text-zinc-500">
                        <tbody class="divide-y divide-zinc-200 bg-white">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr class="hover:bg-zinc-50 transition">
                                    <td class="px-4 py-3 font-medium text-zinc-900 flex items-center gap-3">
                                        <span class="h-5 w-5 rounded-full border border-zinc-300 shadow-xs"
                                            style="background-color: #<?php echo e($color->code); ?>"></span>
                                        <span><?php echo e($color->name); ?></span>
                                    </td>
                                    <td class="px-4 py-3 text-xs text-zinc-400">#<?php echo e($color->code); ?></td>
                                    <td class="px-4 py-3 text-right">
                                        <button onclick="openColorModal('<?php echo e($color->code); ?>', '<?php echo e($color->name); ?>')"
                                            class="inline-flex h-7 px-2.5 items-center justify-center rounded-lg border border-zinc-200 bg-zinc-50 text-xs font-semibold text-zinc-700 hover:bg-zinc-100 transition shadow-sm mr-1">
                                            Editar
                                        </button>
                                        <form method="POST" action="<?php echo e(route('staff.gestao.destroyColor', $color)); ?>"
                                            class="inline" onsubmit="return confirm('Eliminar esta cor?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit"
                                                class="inline-flex h-7 w-7 items-center justify-center rounded-lg border border-red-100 bg-red-50 hover:bg-red-100 transition shadow-sm">
                                                <img src="/img/close.png" alt="Eliminar" class="h-3 w-3" />
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <tr>
                                    <td class="p-4 text-center text-xs text-zinc-400">Nenhuma cor registada.</td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="mb-4 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold text-zinc-900">Catálogo Oficial de Designs</h2>
            <p class="text-sm text-zinc-500">Imagens públicas partilhadas disponíveis para todos os clientes comprarem.
            </p>
        </div>
        <div>
            <a href="<?php echo e(route('staff.gestao.create')); ?>">
                <button type="button"
                    class="inline-flex items-center justify-center rounded-xl bg-zinc-950 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-zinc-800 shadow-sm">
                    + Nova Imagem Catálogo
                </button>
            </a>
        </div>
    </div>

    <form method="GET" action="<?php echo e(route('staff.gestao')); ?>"
        class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between bg-zinc-50 p-4 rounded-2xl border border-zinc-200">
        <div class="flex flex-1 flex-col gap-4 sm:flex-row sm:items-center">
            <div class="relative flex-1">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                    placeholder="Pesquisar imagem por nome ou descrição..."
                    class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2 text-sm text-zinc-900 placeholder-zinc-400 focus:border-zinc-950 focus:outline-none">
            </div>

            <div class="w-full sm:w-48">
                <select name="category_id"
                    class="w-full rounded-xl border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none">
                    <option value="">Todas as Categorias</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category_id') == $cat->id ? 'selected' : ''); ?>>
                            <?php echo e($cat->name); ?>

                        </option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button type="submit"
                class="rounded-xl bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-800 transition">
                Filtrar Catálogo
            </button>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request('search') || request('category_id')): ?>
                <a href="<?php echo e(route('staff.gestao')); ?>"
                    class="rounded-xl bg-zinc-200 px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-300 transition">
                    Limpar
                </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </form>

    <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left text-sm text-zinc-500">
                <thead
                    class="bg-zinc-50 text-xs font-semibold uppercase tracking-wider text-zinc-700 border-b border-zinc-200">
                    <tr>
                        <th class="px-6 py-4">Design</th>
                        <th class="px-6 py-4">Categoria</th>
                        <th class="px-6 py-4">Descrição</th>
                        <th class="px-6 py-4 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 bg-white">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $catalogImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr class="hover:bg-zinc-50 transition">

                            <td class="whitespace-nowrap px-6 py-4 font-medium text-zinc-900">
                                <div class="flex items-center gap-4">
                                    <img src="<?php echo e(asset('storage/tshirt_images/' . $image->image_url)); ?>"
                                        alt="<?php echo e($image->name); ?>"
                                        class="h-12 w-12 rounded-xl border border-zinc-200 bg-zinc-100 object-contain" />
                                    <span class="font-semibold"><?php echo e($image->name); ?></span>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-zinc-600">
                                <span
                                    class="inline-flex items-center rounded-md bg-zinc-100 px-2.5 py-0.5 text-xs font-medium text-zinc-800">
                                    <?php echo e($image->category->name ?? 'Sem Categoria'); ?>

                                </span>
                            </td>

                            <td class="px-6 py-4 text-zinc-500 max-w-xs truncate">
                                <?php echo e($image->description ?? 'Sem descrição definida.'); ?>

                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="<?php echo e(route('staff.gestao.edit', $image)); ?>">
                                        <button type="button"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-zinc-200 bg-white transition hover:bg-zinc-100 shadow-sm"
                                            title="Editar informações">
                                            <img src="/img/edit.png" alt="Editar" class="h-4 w-4" />
                                        </button>
                                    </a>

                                    <form method="POST" action="<?php echo e(route('staff.gestao.destroy', $image)); ?>" class="inline"
                                        onsubmit="return confirm('Eliminar estampa?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-red-100 bg-red-50 transition hover:bg-red-100 shadow-sm"
                                            title="Eliminar Estampa">
                                            <img src="/img/close.png" alt="Eliminar" class="h-4 w-4" />
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-sm text-zinc-500 bg-zinc-50">
                                Nenhum design encontrado no catálogo oficial.
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($catalogImages->hasPages()): ?>
            <div class="border-t border-zinc-200 px-6 py-4 bg-zinc-50">
                <?php echo e($catalogImages->links()); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

</div>

<div id="colorModal"
    class="fixed inset-0 z-50 hidden bg-zinc-950/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div
        class="bg-white rounded-2xl border border-zinc-200 shadow-xl max-w-md w-full p-6 animate-in fade-in zoom-in-95 duration-150">
        <div class="flex items-center justify-between border-b border-zinc-100 pb-3 mb-4">
            <h3 class="text-base font-bold text-zinc-900">Editar Cor</h3>
            <button onclick="closeColorModal()" class="text-zinc-400 hover:text-zinc-600">✕</button>
        </div>

        <form id="editColorForm" method="POST" enctype="multipart/form-data" class="space-y-4">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div>
                <label class="block text-[11px] font-bold uppercase tracking-wider text-zinc-500 mb-1.5">Código
                    HEX</label>
                <input type="text" id="edit_color_code" name="code" required max="6"
                    class="w-full h-10 rounded-xl border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:outline-none focus:border-zinc-950">
            </div>

            <div>
                <label class="block text-[11px] font-bold uppercase tracking-wider text-zinc-500 mb-1.5">Nome da
                    Cor</label>
                <input type="text" id="edit_color_name" name="name" required
                    class="w-full h-10 rounded-xl border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:outline-none focus:border-zinc-950">
            </div>

            <div>
                <label class="block text-[11px] font-bold uppercase tracking-wider text-zinc-500 mb-1.5">Nova T-shirt
                    Base (Opcional)</label>
                <div
                    class="relative w-full h-10 flex items-center rounded-xl border border-zinc-300 bg-white px-3 text-sm text-zinc-900">
                    <input type="file" name="tshirt_image" accept="image/*"
                        class="w-full text-xs text-zinc-500 file:mr-3 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-zinc-100 file:text-zinc-700 hover:file:bg-zinc-200 file:cursor-pointer focus:outline-none">
                </div>
                <p class="text-[10px] text-zinc-400 mt-1">Deixa em branco para manter a imagem da t-shirt atual.</p>
            </div>

            <div class="flex justify-end gap-2 pt-2 border-t border-zinc-100">
                <button type="button" onclick="closeColorModal()"
                    class="h-10 px-4 text-sm font-semibold text-zinc-700 bg-zinc-100 hover:bg-zinc-200 rounded-xl transition">Cancelar</button>
                <button type="submit"
                    class="h-10 px-5 text-sm font-semibold text-white bg-zinc-950 hover:bg-zinc-800 rounded-xl transition">Guardar
                    Alterações</button>
            </div>
        </form>
    </div>
</div>

<div id="categoryModal"
    class="fixed inset-0 z-50 hidden bg-zinc-950/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div
        class="bg-white rounded-2xl border border-zinc-200 shadow-xl max-w-md w-full p-6 animate-in fade-in zoom-in-95 duration-150">
        <div class="flex items-center justify-between border-b border-zinc-100 pb-3 mb-4">
            <h3 class="text-base font-bold text-zinc-900">Editar Categoria</h3>
            <button onclick="closeCategoryModal()" class="text-zinc-400 hover:text-zinc-600">✕</button>
        </div>

        <form id="editCategoryForm" method="POST" class="space-y-4">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div>
                <label class="block text-[11px] font-bold uppercase tracking-wider text-zinc-500 mb-1.5">Nome da
                    Categoria</label>
                <input type="text" id="edit_category_name" name="name" required
                    class="w-full h-10 rounded-xl border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:outline-none focus:border-zinc-950">
            </div>

            <div class="flex justify-end gap-2 pt-2 border-t border-zinc-100">
                <button type="button" onclick="closeCategoryModal()"
                    class="h-10 px-4 text-sm font-semibold text-zinc-700 bg-zinc-100 hover:bg-zinc-200 rounded-xl transition">Cancelar</button>
                <button type="submit"
                    class="h-10 px-5 text-sm font-semibold text-white bg-zinc-950 hover:bg-zinc-800 rounded-xl transition">Guardar
                    Alterações</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openColorModal(code, name) {
        document.getElementById('edit_color_code').value = code;
        document.getElementById('edit_color_name').value = name;

        let form = document.getElementById('editColorForm');
        form.action = `/staff/gestao/cores/${code.toLowerCase()}`;

        document.getElementById('colorModal').classList.remove('hidden');
    }

    function closeColorModal() {
        document.getElementById('colorModal').classList.add('hidden');
    }

    function openCategoryModal(id, name) {
        document.getElementById('edit_category_name').value = name;

        let form = document.getElementById('editCategoryForm');
        form.action = `/staff/gestao/categorias/${id}`;

        document.getElementById('categoryModal').classList.remove('hidden');
    }

    function closeCategoryModal() {
        document.getElementById('categoryModal').classList.add('hidden');
    }
</script>
<?php echo $__env->renderComponent(); ?><?php /**PATH C:\laragon\www\ProjetoAinet\resources\views/staff/gestao.blade.php ENDPATH**/ ?>