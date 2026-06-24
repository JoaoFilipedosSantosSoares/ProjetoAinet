<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FunShirt</title>

    <link rel="icon" type="image/png" href="/img/FunShirt_Ico.ico">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body class="bg-[#fbfaf7] min-h-screen flex flex-col antialiased">

    <?php echo $__env->make('layouts.app.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="flex-1">
        <?php echo e($slot); ?>

    </main>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    <?php app('livewire')->forceAssetInjection(); ?>
<?php echo app('flux')->scripts(); ?>

</body>
</html><?php /**PATH C:\laragon\www\ProjetoAinet_prat\resources\views/layouts/main-content.blade.php ENDPATH**/ ?>