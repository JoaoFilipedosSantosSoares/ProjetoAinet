<?php $__env->startComponent('layouts.main-content'); ?>

<main class="min-h-screen bg-background">
    <div class="container mx-auto px-4 py-12">
        <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-foreground">A Minha Conta</h1>
                <p class="text-muted-foreground">Gere o teu perfil e encomendas</p>
            </div>

            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="rounded-2xl border border-zinc-300 px-4 py-3 text-sm font-semibold text-zinc-900 transition hover:bg-zinc-100">
                    Sair da conta
                </button>
            </form>
        </div>

        <div class="space-y-6">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('status') === 'profile-information-updated'): ?>
            <div class="mb-4 rounded-2xl bg-green-50 p-4 text-sm font-medium text-green-800 border border-green-200">
                As tuas informações de perfil foram atualizadas com sucesso!
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('status') === 'password-updated'): ?>
            <div class="mb-4 rounded-2xl bg-green-50 p-4 text-sm font-medium text-green-800 border border-green-200">
                A tua palavra-passe foi alterada com sucesso!
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('status') === 'order-placed-success'): ?>
            <div class="mb-4 rounded-2xl bg-emerald-50 p-4 text-sm font-medium text-emerald-800 border border-emerald-200">
                Encomenda <b>#<?php echo e(session('order_id')); ?></b> processada e paga com sucesso!
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <section id="profile-panel" class="space-y-6">
                <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm">
                    <div class="flex flex-col gap-4 border-b border-zinc-200 p-6 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-foreground">Informações Pessoais</h2>
                            <p class="text-muted-foreground">Os teus dados e preferências para futuras encomendas</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button type="submit" form="profile-form" class="rounded-2xl bg-zinc-950 px-4 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800">
                                Guardar Dados
                            </button>
                        </div>
                    </div>

                    <form id="profile-form" action="<?php echo e(route('user-profile-information.update')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6 p-6">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="mb-8 border-b border-zinc-100 pb-6">
                            <label class="block text-sm font-medium text-zinc-900 mb-4">Foto de Perfil</label>
                            <div class="flex items-center gap-6">
                                <div class="relative h-24 w-24 overflow-hidden rounded-full border border-zinc-200 bg-zinc-100">
                                    <img src="<?php echo e(auth()->user()->getPhotoFullUrlAttribute()); ?>" alt="Foto de perfil" class="h-full w-full object-cover">
                                </div>

                                <div class="space-y-1">
                                    <input
                                        type="file"
                                        name="photo"
                                        id="photo"
                                        accept="image/*"
                                        class="text-sm text-zinc-500 file:mr-4 file:rounded-2xl file:border-0 file:bg-zinc-950 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white file:transition hover:file:bg-zinc-800" />
                                    <p class="text-xs text-muted-foreground">PNG, JPG ou WEBP até 2MB.</p>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['photo', 'updateProfileInformation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-xs text-red-500 mt-1 block"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <?php if (isset($component)) { $__componentOriginal9bc121726080b4b42dde7da6d6f54f66 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9bc121726080b4b42dde7da6d6f54f66 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.profile-input','data' => ['label' => 'Nome Completo','name' => 'name','value' => old('name', auth()->user()->name)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('profile-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Nome Completo','name' => 'name','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('name', auth()->user()->name))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9bc121726080b4b42dde7da6d6f54f66)): ?>
<?php $attributes = $__attributesOriginal9bc121726080b4b42dde7da6d6f54f66; ?>
<?php unset($__attributesOriginal9bc121726080b4b42dde7da6d6f54f66); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9bc121726080b4b42dde7da6d6f54f66)): ?>
<?php $component = $__componentOriginal9bc121726080b4b42dde7da6d6f54f66; ?>
<?php unset($__componentOriginal9bc121726080b4b42dde7da6d6f54f66); ?>
<?php endif; ?>

                            <?php if (isset($component)) { $__componentOriginal9bc121726080b4b42dde7da6d6f54f66 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9bc121726080b4b42dde7da6d6f54f66 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.profile-input','data' => ['label' => 'Email','name' => 'email','value' => auth()->user()->email,'readonly' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('profile-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Email','name' => 'email','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(auth()->user()->email),'readonly' => 'true']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9bc121726080b4b42dde7da6d6f54f66)): ?>
<?php $attributes = $__attributesOriginal9bc121726080b4b42dde7da6d6f54f66; ?>
<?php unset($__attributesOriginal9bc121726080b4b42dde7da6d6f54f66); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9bc121726080b4b42dde7da6d6f54f66)): ?>
<?php $component = $__componentOriginal9bc121726080b4b42dde7da6d6f54f66; ?>
<?php unset($__componentOriginal9bc121726080b4b42dde7da6d6f54f66); ?>
<?php endif; ?>

                            <?php if (isset($component)) { $__componentOriginal9bc121726080b4b42dde7da6d6f54f66 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9bc121726080b4b42dde7da6d6f54f66 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.profile-input','data' => ['label' => 'NIF','name' => 'nif','value' => old('nif', auth()->user()->customer?->nif),'placeholder' => '123456789','maxlength' => '9']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('profile-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'NIF','name' => 'nif','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('nif', auth()->user()->customer?->nif)),'placeholder' => '123456789','maxlength' => '9']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9bc121726080b4b42dde7da6d6f54f66)): ?>
<?php $attributes = $__attributesOriginal9bc121726080b4b42dde7da6d6f54f66; ?>
<?php unset($__attributesOriginal9bc121726080b4b42dde7da6d6f54f66); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9bc121726080b4b42dde7da6d6f54f66)): ?>
<?php $component = $__componentOriginal9bc121726080b4b42dde7da6d6f54f66; ?>
<?php unset($__componentOriginal9bc121726080b4b42dde7da6d6f54f66); ?>
<?php endif; ?>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-zinc-900">Método de Pagamento</label>
                                <div class="relative">
                                    <select
                                        name="paymentMethod"
                                        data-editable="true"
                                        class="profile-input w-full appearance-none rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 pr-10 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">

                                        <option value="" disabled <?php echo e(empty(auth()->user()->customer?->default_payment_type) ? 'selected' : ''); ?>>Selecione um método</option>
                                        <option value="MB WAY" <?php echo e(old('paymentMethod', auth()->user()->customer?->default_payment_type) == 'MB WAY' ? 'selected' : ''); ?>>MB WAY</option>
                                        <option value="PayPal" <?php echo e(old('paymentMethod', auth()->user()->customer?->default_payment_type) == 'PayPal' ? 'selected' : ''); ?>>PayPal</option>
                                        <option value="Visa" <?php echo e(old('paymentMethod', auth()->user()->customer?->default_payment_type) == 'Visa' ? 'selected' : ''); ?>>Visa</option>
                                    </select>

                                    <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-zinc-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['paymentMethod', 'updateProfileInformation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-xs text-red-500 mt-1 block"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <?php if (isset($component)) { $__componentOriginal9bc121726080b4b42dde7da6d6f54f66 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9bc121726080b4b42dde7da6d6f54f66 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.profile-input','data' => ['label' => 'Referência de Pagamento','name' => 'paymentRef','value' => old('paymentRef', auth()->user()->customer?->default_payment_ref),'placeholder' => 'Nº Telemóvel (MB WAY), Email (PayPal) ou Cartão (VISA)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('profile-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Referência de Pagamento','name' => 'paymentRef','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('paymentRef', auth()->user()->customer?->default_payment_ref)),'placeholder' => 'Nº Telemóvel (MB WAY), Email (PayPal) ou Cartão (VISA)']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9bc121726080b4b42dde7da6d6f54f66)): ?>
<?php $attributes = $__attributesOriginal9bc121726080b4b42dde7da6d6f54f66; ?>
<?php unset($__attributesOriginal9bc121726080b4b42dde7da6d6f54f66); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9bc121726080b4b42dde7da6d6f54f66)): ?>
<?php $component = $__componentOriginal9bc121726080b4b42dde7da6d6f54f66; ?>
<?php unset($__componentOriginal9bc121726080b4b42dde7da6d6f54f66); ?>
<?php endif; ?>

                            <?php if (isset($component)) { $__componentOriginal9bc121726080b4b42dde7da6d6f54f66 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9bc121726080b4b42dde7da6d6f54f66 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.profile-input','data' => ['label' => 'Morada de Envio','name' => 'morada','value' => old('morada', auth()->user()->customer?->address),'placeholder' => 'Rua, número, código postal, cidade']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('profile-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Morada de Envio','name' => 'morada','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('morada', auth()->user()->customer?->address)),'placeholder' => 'Rua, número, código postal, cidade']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9bc121726080b4b42dde7da6d6f54f66)): ?>
<?php $attributes = $__attributesOriginal9bc121726080b4b42dde7da6d6f54f66; ?>
<?php unset($__attributesOriginal9bc121726080b4b42dde7da6d6f54f66); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9bc121726080b4b42dde7da6d6f54f66)): ?>
<?php $component = $__componentOriginal9bc121726080b4b42dde7da6d6f54f66; ?>
<?php unset($__componentOriginal9bc121726080b4b42dde7da6d6f54f66); ?>
<?php endif; ?>
                        </div>
                    </form>
                </div>
            </section>

            <section id="password-panel" class="mt-8">
                <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm">
                    <div class="flex flex-col gap-4 border-b border-zinc-200 p-6 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-foreground">Alterar Palavra-passe</h2>
                            <p class="text-muted-foreground">Garante que a tua conta utiliza uma credencial forte e segura</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button type="submit" form="password-form" class="rounded-2xl bg-zinc-950 px-4 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800">
                                Atualizar Palavra-passe
                            </button>
                        </div>
                    </div>

                    <form id="password-form" action="<?php echo e(route('user-password.update')); ?>" method="POST" class="p-6 space-y-6">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="grid gap-6 md:grid-cols-3">
                            <div class="space-y-2">
                                <label for="current_password" class="block text-sm font-medium text-zinc-900">Palavra-passe Atual</label>
                                <input type="password" id="current_password" name="current_password" required
                                    class="w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-zinc-400 focus:bg-white" />
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['current_password', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-xs text-red-500 mt-1 block"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="space-y-2">
                                <label for="password" class="block text-sm font-medium text-zinc-900">Nova Palavra-passe</label>
                                <input type="password" id="password" name="password" required
                                    class="w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-zinc-400 focus:bg-white" />
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-xs text-red-500 mt-1 block"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="space-y-2">
                                <label for="password_confirmation" class="block text-sm font-medium text-zinc-900">Confirmar Nova Palavra-passe</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    class="w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-zinc-400 focus:bg-white" />
                            </div>
                        </div>
                    </form>
                </div>
            </section>

            <section id="orders-panel" class="space-y-6 mt-8">
                <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm overflow-hidden">
                    <div class="border-b border-zinc-200 p-6">
                        <h2 class="text-xl font-semibold text-foreground">As Minhas Encomendas concluídas</h2>
                        <p class="text-muted-foreground">Acompanha o histórico das tuas compras </p>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($orders && $orders->isNotEmpty()): ?>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-zinc-600">
                            <thead class="bg-zinc-50 text-xs font-semibold uppercase text-zinc-700 border-b border-zinc-200">
                                <tr>
                                    <th class="px-6 py-4">ID / Referência</th>
                                    <th class="px-6 py-4">Data</th>
                                    <th class="px-6 py-4">Estado</th>
                                    <th class="px-6 py-4 text-right">Total</th>
                                    <th class="px-6 py-4 text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr class="hover:bg-zinc-50/50 transition">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium text-zinc-900">
                                        #<?php echo e($order->id); ?>

                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <?php echo e(date('d/m/Y', strtotime($order->date ?? $order->created_at))); ?>

                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span class="inline-flex items-center rounded-full border border-green-200 bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700">
                                            <?php echo e(ucfirst($order->status)); ?>

                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right font-semibold text-zinc-900">
                                        <?php echo e(number_format($order->total_price, 2, ',', '.')); ?> €
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-center">
                                        <a href="<?php echo e(route('orders.show', $order->id)); ?>" class="inline-flex items-center gap-1 text-sm font-semibold text-zinc-900 hover:underline">
                                            Ver Detalhes
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 px-6 pb-6">
                        <?php echo e($orders->links()); ?>

                    </div>

                    <?php else: ?>
                    <div class="flex flex-col items-center justify-center p-12 text-center">
                        <div class="rounded-full bg-zinc-50 p-4 border border-zinc-100 mb-4">
                            <svg class="h-8 w-8 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-zinc-900">Nenhuma encomenda fechada</h3>
                        <p class="mt-1 text-sm text-muted-foreground">Não encontrámos encomendas com o estado fechada na tua conta.</p>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </section>
            <section id="cancelled-orders-panel" class="mt-8">
                <div class="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm">
                    <div class="border-b border-zinc-200 bg-red-50/50 p-6">
                        <h2 class="text-xl font-semibold text-red-900">Encomendas Canceladas</h2>
                        <p class="text-sm text-red-700">Histórico de compras que foram anuladas</p>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cancelledOrders->isNotEmpty()): ?>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-zinc-600">
                                <thead class="border-b border-zinc-100 bg-zinc-50 text-xs font-semibold uppercase text-zinc-700">
                                    <tr>
                                        <th class="px-6 py-4">ID</th>
                                        <th class="px-6 py-4">Data</th>
                                        <th class="px-6 py-4 text-right">Total</th>
                                        <th class="px-6 py-4">Motivo</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-100">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $cancelledOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <tr class="transition hover:bg-red-50/30">
                                            <td class="px-6 py-4 font-medium text-zinc-900">#<?php echo e($order->id); ?></td>
                                            <td class="px-6 py-4"><?php echo e($order->created_at->format('d/m/Y')); ?></td>
                                            <td class="px-6 py-4 text-right font-semibold text-zinc-900">
                                                <?php echo e(number_format($order->total_price, 2, ',', '.')); ?> €
                                            </td>
                                            <td class="px-6 py-4 italic text-red-600">
                                                <?php echo e($order->reason_for_cancellation ?? 'Sem motivo especificado'); ?>

                                            </td>
                                        </tr>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="flex flex-col items-center justify-center p-8 text-center text-zinc-500">
                            <svg class="mb-2 h-6 w-6 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm">Não existem encomendas canceladas.</p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </section>
        </div>
    </div>
</main>
<?php echo $__env->renderComponent(); ?><?php /**PATH C:\laragon\www\ProjetoAinet_prat\resources\views/account/index.blade.php ENDPATH**/ ?>