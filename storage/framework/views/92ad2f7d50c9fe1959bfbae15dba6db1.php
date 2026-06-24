<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paginator->hasPages()): ?>
    <nav role="navigation" aria-label="<?php echo e(__('Pagination Navigation')); ?>">

        <div class="flex gap-2 items-center justify-between sm:hidden">

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paginator->onFirstPage()): ?>
                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-[#fbfaf7] border border-[#e8e5e0] cursor-not-allowed leading-5 rounded-md dark:text-gray-700 dark:bg-[#fbfaf7] dark:border-[#e8e5e0]">
                    <?php echo __('pagination.previous'); ?>

                </span>
            <?php else: ?>
                <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-[#fbfaf7] border border-[#e8e5e0] leading-5 rounded-md hover:bg-[#d4cfc6] focus:outline-none focus:ring ring-[#d4cfc6] focus:border-[#d4cfc6] active:bg-[#d4cfc6] active:text-gray-900 transition ease-in-out duration-150 dark:bg-[#fbfaf7] dark:border-[#e8e5e0] dark:text-gray-700 dark:focus:border-[#d4cfc6] dark:active:bg-[#d4cfc6] dark:active:text-gray-900 dark:hover:bg-[#d4cfc6]">
                    <?php echo __('pagination.previous'); ?>

                </a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paginator->hasMorePages()): ?>
                <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-[#fbfaf7] border border-[#e8e5e0] leading-5 rounded-md hover:bg-[#d4cfc6] focus:outline-none focus:ring ring-[#d4cfc6] focus:border-[#d4cfc6] active:bg-[#d4cfc6] active:text-gray-900 transition ease-in-out duration-150 dark:bg-[#fbfaf7] dark:border-[#e8e5e0] dark:text-gray-700 dark:focus:border-[#d4cfc6] dark:active:bg-[#d4cfc6] dark:active:text-gray-900 dark:hover:bg-[#d4cfc6]">
                    <?php echo __('pagination.next'); ?>

                </a>
            <?php else: ?>
                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-[#fbfaf7] border border-[#e8e5e0] cursor-not-allowed leading-5 rounded-md dark:text-gray-700 dark:bg-[#fbfaf7] dark:border-[#e8e5e0]">
                    <?php echo __('pagination.next'); ?>

                </span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        </div>

        <div class="hidden sm:flex-1 sm:flex sm:gap-2 sm:items-center sm:justify-between">

            <div>
                <p class="text-sm text-gray-700 leading-5 dark:text-gray-600">
                    <?php echo __('Exibindo de '); ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paginator->firstItem()): ?>
                        <span class="font-medium"><?php echo e($paginator->firstItem()); ?></span>
                        <?php echo __('a'); ?>

                        <span class="font-medium"><?php echo e($paginator->lastItem()); ?></span>
                    <?php else: ?>
                        <?php echo e($paginator->count()); ?>

                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php echo __('de'); ?>

                    <span class="font-medium"><?php echo e($paginator->total()); ?></span>
                    <?php echo __('resultados'); ?>

                </p>
            </div>

            <div>
                <span class="inline-flex rtl:flex-row-reverse shadow-sm rounded-md">

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paginator->onFirstPage()): ?>
                        <span aria-disabled="true" aria-label="<?php echo e(__('pagination.previous')); ?>">
                            <span class="inline-flex items-center px-2 py-2 text-sm font-medium text-gray-700 bg-[#fbfaf7] border border-[#e8e5e0] cursor-not-allowed rounded-l-md leading-5 dark:bg-[#fbfaf7] dark:border-[#e8e5e0] dark:text-gray-700" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    <?php else: ?>
                        <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" class="inline-flex items-center px-2 py-2 text-sm font-medium text-gray-700 bg-[#fbfaf7] border border-[#e8e5e0] rounded-l-md leading-5 hover:bg-[#d4cfc6] focus:outline-none focus:ring ring-[#d4cfc6] focus:border-[#d4cfc6] active:bg-[#d4cfc6] active:text-gray-900 transition ease-in-out duration-150 dark:bg-[#fbfaf7] dark:border-[#e8e5e0] dark:active:bg-[#d4cfc6] dark:focus:border-[#d4cfc6] dark:text-gray-700 dark:hover:bg-[#d4cfc6]" aria-label="<?php echo e(__('pagination.previous')); ?>">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_string($element)): ?>
                            <span aria-disabled="true">
                                <span class="inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-[#fbfaf7] border border-[#e8e5e0] cursor-default leading-5 dark:bg-[#fbfaf7] dark:border-[#e8e5e0] dark:text-gray-700"><?php echo e($element); ?></span>
                            </span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_array($element)): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($page == $paginator->currentPage()): ?>
                                    <span aria-current="page">
                                        <span class="inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-900 bg-[#d4cfc6] border border-[#d4cfc6] cursor-default leading-5 dark:bg-[#d4cfc6] dark:border-[#d4cfc6] dark:text-gray-900"><?php echo e($page); ?></span>
                                    </span>
                                <?php else: ?>
                                    <a href="<?php echo e($url); ?>" class="inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-[#fbfaf7] border border-[#e8e5e0] leading-5 hover:bg-[#d4cfc6] focus:outline-none focus:ring ring-[#d4cfc6] focus:border-[#d4cfc6] active:bg-[#d4cfc6] active:text-gray-900 transition ease-in-out duration-150 dark:bg-[#fbfaf7] dark:border-[#e8e5e0] dark:text-gray-700 dark:hover:bg-[#d4cfc6] dark:active:bg-[#d4cfc6] dark:focus:border-[#d4cfc6]" aria-label="<?php echo e(__('Go to page :page', ['page' => $page])); ?>">
                                        <?php echo e($page); ?>

                                    </a>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paginator->hasMorePages()): ?>
                        <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" class="inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-700 bg-[#fbfaf7] border border-[#e8e5e0] rounded-r-md leading-5 hover:bg-[#d4cfc6] focus:outline-none focus:ring ring-[#d4cfc6] focus:border-[#d4cfc6] active:bg-[#d4cfc6] active:text-gray-900 transition ease-in-out duration-150 dark:bg-[#fbfaf7] dark:border-[#e8e5e0] dark:active:bg-[#d4cfc6] dark:focus:border-[#d4cfc6] dark:text-gray-700 dark:hover:bg-[#d4cfc6]" aria-label="<?php echo e(__('pagination.next')); ?>">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    <?php else: ?>
                        <span aria-disabled="true" aria-label="<?php echo e(__('pagination.next')); ?>">
                            <span class="inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-700 bg-[#fbfaf7] border border-[#e8e5e0] cursor-not-allowed rounded-r-md leading-5 dark:bg-[#fbfaf7] dark:border-[#e8e5e0] dark:text-gray-700" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </span>
            </div>
        </div>
    </nav>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\laragon\www\ProjetoAinet_prat\resources\views/vendor/pagination/tailwind.blade.php ENDPATH**/ ?>