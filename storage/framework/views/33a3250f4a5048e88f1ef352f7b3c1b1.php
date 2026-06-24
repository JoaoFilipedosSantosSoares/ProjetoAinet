<header class="sticky top-0 z-50 border-b border-zinc-200 bg-[#fbfaf7]">
    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">

        <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-4">
            <div class="flex h-16 w-16 items-center justify-center rounded-2xl overflow-hidden">
                <img src="/img/FunShirtImage.png" alt="FunShirt Logo" class="h-full w-full object-cover">
            </div>
            <span class="text-3xl font-bold tracking-tight text-zinc-900">FunShirt</span>
        </a>

        <nav class="hidden items-center gap-2 md:flex">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin')): ?>
                    <a href="<?php echo e(route('staff.estatisticas')); ?>"
                        class="flex items-center gap-2 rounded-xl bg-transparent px-4 py-2.5 text-sm font-medium text-zinc-600 transition hover:text-zinc-950">
                        Dashboard
                    </a>
                <?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <a href="<?php echo e(route('home')); ?>"
                class="flex items-center gap-2 rounded-xl bg-transparent px-4 py-2.5 text-sm font-medium text-zinc-600 transition hover:text-zinc-950">
                <span>Inicio</span>
            </a>

            <a href="<?php echo e(route('catalog.index')); ?>"
                class="flex items-center gap-2 rounded-xl bg-transparent px-4 py-2.5 text-sm font-medium text-zinc-600 transition hover:text-zinc-950">
                Catalogo
            </a>


            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('employee')): ?>
            <a href="<?php echo e(route('customization.index')); ?>"
                class="flex items-center gap-2 rounded-xl bg-transparent px-4 py-2.5 text-sm font-medium text-zinc-600 transition hover:text-zinc-950">
                Personalizar
            </a>
            <?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('cliente')): ?>
            <a href="<?php echo e(route('orders.index')); ?>"
                class="flex items-center gap-2 rounded-xl bg-transparent px-4 py-2.5 text-sm font-medium text-zinc-600 transition hover:text-zinc-950">
                Encomendas
            </a>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin')): ?>
            <a href="<?php echo e(route('staff.index')); ?>"
                class="flex items-center gap-2 rounded-xl bg-transparent px-4 py-2.5 text-sm font-medium text-zinc-600 transition hover:text-zinc-950">
                Staff
            </a>
            <a href="<?php echo e(route('clients.index')); ?>"
                class="flex items-center gap-2 rounded-xl bg-transparent px-4 py-2.5 text-sm font-medium text-zinc-600 transition hover:text-zinc-950">
                Clientes
            </a>
            <a href="<?php echo e(route('staff.gestao')); ?>"
                class="flex items-center gap-2 rounded-xl bg-transparent px-4 py-2.5 text-sm font-medium text-zinc-600 transition hover:text-zinc-950">
                Gestão de Catálogo
            </a>
            <?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </nav>

        <div class="flex items-center gap-4">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('employee')): ?>
            <a href="<?php echo e(route('cart.index')); ?>" class="relative p-2 text-zinc-800 hover:text-zinc-950 transition">
                <img src="/img/online-shopping.png" alt="Catalog Icon" class="h-5 w-5" />
                <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-[#144226] text-xs font-bold text-white">
                    <?php echo e(is_array(session('cart')) ? count(session('cart')) : 0); ?>

                </span>
            </a>
            <?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cliente')): ?>
            <a href="<?php echo e(route('account.index')); ?>" class="p-2 text-zinc-800 hover:text-zinc-950 transition">
                <img src="/img/user.png" alt="Account Icon" class="h-6 w-6" />
            </a>
            <?php else: ?>
            <form method="POST" action="<?php echo e(route('logout')); ?>" class="inline-block">
                <?php echo csrf_field(); ?>
                <button type="submit" class="p-2 text-zinc-800 hover:text-zinc-950 transition outline-none border-0 bg-transparent cursor-pointer flex items-center justify-center">
                    <img src="/img/logout.png" alt="Logout Icon" class="h-6 w-6" />
                </button>
            </form>
            <?php endif; ?>
            <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" class="p-2 text-zinc-800 hover:text-zinc-950 transition">
                <img src="/img/user.png" alt="Login Icon" class="h-6 w-6" />
            </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</header><?php /**PATH C:\laragon\www\ProjetoAinet\resources\views/layouts/app/header.blade.php ENDPATH**/ ?>