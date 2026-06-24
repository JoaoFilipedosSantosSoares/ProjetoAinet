<?php $__env->startComponent('layouts.main-content'); ?>
<div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">

    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-zinc-900 md:text-4xl">Gestão de Equipa</h1>
            <p class="mt-2 text-sm text-zinc-600">Lista completa de todos os trabalhadores da FunShirt.</p>
        </div>
        <div>
            <a href="<?php echo e(route('staff.add')); ?>"
                class="inline-flex items-center justify-center rounded-xl bg-zinc-950 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-zinc-800 shadow-sm">
                + Adicionar Membro
            </a>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
    <div class="mb-6 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-semibold text-red-600 shadow-sm animate-fade-in">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 shrink-0">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
        </svg>
        <span><?php echo e(session('error')); ?></span>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
    <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-semibold text-emerald-600 shadow-sm animate-fade-in">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 shrink-0">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span><?php echo e(session('success')); ?></span>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <form method="GET" action="#" class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between bg-zinc-50 p-4 rounded-2xl border border-zinc-200">
        <div class="flex flex-1 flex-col gap-4 sm:flex-row sm:items-center">
            <div class="relative flex-1">
                <input type="text" name="search" value="<?php echo e($filterBySearch); ?>" placeholder="Pesquisar por nome ou e-mail..."
                    class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-2 text-sm text-zinc-900 placeholder-zinc-400 focus:border-zinc-950 focus:outline-none">
            </div>

            <div class="w-full sm:w-48">
                <select name="type" class="w-full rounded-xl border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none">
                    <option value="">Todos os Cargos</option>
                    <option value="F" <?php echo e($filterByType === 'F' ? 'selected' : ''); ?>>Funcionário</option>
                    <option value="A" <?php echo e($filterByType === 'A' ? 'selected' : ''); ?>>Administrador</option>
                </select>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button type="submit" class="rounded-xl bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-800 transition">
                Filtrar
            </button>
        </div>
    </form>

    <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left text-sm text-zinc-500">
                <thead class="bg-zinc-50 text-xs font-semibold uppercase tracking-wider text-zinc-700 border-b border-zinc-200">
                    <tr>
                        <th class="px-6 py-4">Staff</th>
                        <th class="px-6 py-4">E-mail</th>
                        <th class="px-6 py-4">Cargo</th>
                        <th class="px-6 py-4">Estado</th>
                        <th class="px-6 py-4 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 bg-white">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="hover:bg-zinc-50 transition">

                        <td class="whitespace-nowrap px-6 py-4 font-medium text-zinc-900">
                            <div class="flex items-center gap-3">
                                <img src="<?php echo e($user->getPhotoFullUrlAttribute()); ?>" alt="Avatar" class="h-10 w-10 rounded-full border border-zinc-200 bg-zinc-100" />
                                <span><?php echo e($user->name); ?></span>
                            </div>
                        </td>

                        <td class="whitespace-nowrap px-6 py-4 text-zinc-600">
                            <?php echo e($user->email); ?>

                        </td>

                        <td class="whitespace-nowrap px-6 py-4">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->user_type === 'A'): ?>
                            <span class="inline-flex items-center rounded-md bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700 ring-1 ring-zinc-700/10">Admin</span>
                            <?php else: ?>
                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-zinc-700/10">Funcionário</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>

                        <td class="whitespace-nowrap px-6 py-4">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->blocked): ?>
                            <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700">Bloqueado</span>
                            <?php else: ?>
                            <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700">Ativo</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>

                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-2">
                                <a href="<?php echo e(route('staff.show', $user)); ?>"
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-zinc-200 bg-white transition hover:bg-zinc-100 shadow-sm"
                                    title="Ver/Editar Perfil de <?php echo e($user->name); ?>">
                                    <img src="/img/edit.png" alt="Editar" class="h-4 w-4" />
                                </a>
                                <form method="POST" action="/staff/index/<?php echo e($user->id); ?>/block" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-zinc-200 bg-white transition hover:bg-zinc-100 shadow-sm"
                                        title="<?php echo e($user->blocked ? 'Desbloquear' : 'Bloquear'); ?> Utilizador">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->blocked): ?>
                                        <img src="/img/unlock.png" alt="Desbloquear" class="h-4 w-4" />
                                        <?php else: ?>
                                        <img src="/img/padlock.png" alt="Bloquear" class="h-4 w-4" />
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </button>
                                </form>

                                <form method="POST" action="/staff/index/<?php echo e($user->id); ?>" class="inline"
                                    onsubmit="return confirm('Tem a certeza que deseja eliminar o utilizador <?php echo e($user->name); ?>?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>

                                    <button type="submit" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-red-100 bg-red-50 transition hover:bg-red-100 shadow-sm"
                                        title="Eliminar Utilizador">
                                        <img src="/img/close.png" alt="Eliminar" class="h-4 w-4" />
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-sm text-zinc-500 bg-zinc-50">
                            Nenhum funcionário ou administrador encontrado.
                        </td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($users->hasPages()): ?>
        <div class="border-t border-zinc-200 px-6 py-4 bg-zinc-50">
            <?php echo e($users->links()); ?>

        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php echo $__env->renderComponent(); ?><?php /**PATH C:\laragon\www\ProjetoAinet\resources\views/staff/index.blade.php ENDPATH**/ ?>