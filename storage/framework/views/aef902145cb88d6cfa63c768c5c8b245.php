<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Recibo da Encomenda #<?php echo e($order->id); ?></title>
    <style> 
        /* --- ESTILOS GERAIS (Inspirados no teu Catálogo) --- */
        @page {
            margin: 40px;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 13px;
            color: #18181b;
            line-height: 1.5;
            background-color: #ffffff;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
        }

        /* --- CABEÇALHO --- */
        .header {
            width: 100%;
            border-bottom: 1px solid #e4e4e7;
            padding-bottom: 25px;
            margin-bottom: 30px;
        }

        .title {
            font-size: 24px;
            font-weight: 800;
            color: #09090b;
            text-transform: uppercase;
        }

        .order-number {
            font-size: 14px;
            color: #71717a;
            margin-top: 5px;
        }

        /* --- DETALHES DE FATURAÇÃO --- */
        .details-table {
            width: 100%;
            margin-bottom: 40px;
        }

        .details-table td {
            vertical-align: top;
            width: 50%;
        }

        .section-title {
            font-size: 11px;
            font-weight: 700;
            color: #71717a;
            text-transform: uppercase;
            margin-bottom: 8px;
            tracking-length: 1px;
        }

        .info-content {
            font-size: 13px;
            color: #27272a;
        }

        /* --- TABELA DE PRODUTOS --- */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .items-table th {
            background-color: #fafafa;
            padding: 12px 16px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #27272a;
            border-bottom: 1px solid #e4e4e7;
        }

        .items-table td {
            padding: 16px;
            border-bottom: 1px solid #f4f4f5;
            vertical-align: middle;
        }

        .product-title {
            font-weight: 700;
            font-size: 14px;
            color: #09090b;
        }

        .product-meta {
            font-size: 11px;
            color: #71717a;
            margin-top: 4px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-size {
            background: #f4f4f5;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: bold;
            color: #18181b;
        }

        /* --- CONTENTOR DO MOCK-UP DA T-SHIRT (Sem cortes nas bordas) --- */
        .tshirt-container {
            position: relative;
            width: 75px;
            height: 75px;
            background-color: #f4f4f5;
            border-radius: 12px;
            overflow: hidden;
            display: block;
        }

        /* Camada de Trás: A T-shirt lisa */
        .tshirt-base {
            width: 100%;
            height: 100%;
            display: block;
            position: relative;
            object-fit: contain;
            /* Garante que a t-shirt não é cortada nas pontas */
            z-index: 1;
        }

        /* Camada da Frente: A Estampa */
        .tshirt-print {
            position: absolute;
            top: 22px;
            /* Alinhamento vertical no peito */
            left: 26px;
            /* Centrar horizontalmente */
            width: 24px;
            /* Tamanho da estampa escalado corretamente */
            height: 24px;
            object-fit: contain;
            z-index: 2;
        }

        /* --- TOTAIS --- */
        .total-section {
            width: 100%;
            margin-top: 30px;
            border-top: 1px solid #e4e4e7;
            padding-top: 20px;
        }

        .total-box {
            float: right;
            width: 35%;
            text-align: right;
        }

        .total-row {
            font-size: 14px;
            color: #71717a;
            margin-bottom: 5px;
        }

        .grand-total {
            font-size: 20px;
            font-weight: 800;
            color: #09090b;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="invoice-box">

        <table class="header">
            <tr>
                <td>
                    <div class="title">Recibo Oficial</div>
                    <div class="order-number">Encomenda #<?php echo e($order->id); ?></div>
                </td>
                <td style="text-align: right; vertical-align: bottom; color: #71717a;">
                    <strong>Data:</strong> <?php echo e(\Carbon\Carbon::parse($order->date)->format('d/m/Y')); ?>

                </td>
            </tr>
        </table>



        <table class="details-table">
            <tr>
                <td>
                    <div class="section-title">Faturado a</div>
                    <div class="info-content">
                        <strong><?php echo e($order->customer->user->name ?? 'Cliente Registado'); ?></strong><br>
                        <?php echo e($order->customer->user->email ?? ''); ?><br>
                        <span style="color: #71717a;">NIF: <?php echo e($order->nif ?? 'N/A'); ?></span>
                    </div>
                </td>
                <td style="text-align: right;">
                    <div class="section-title">Método de Pagamento</div>
                    <div class="info-content">
                        <strong><?php echo e(strtoupper($order->payment_type ?? 'N/A')); ?></strong><br>
                    </div>
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 85px;">Design</th>
                    <th>Detalhes do Produto</th>
                    <th style="text-align: center; width: 80px;">Tamanho</th>
                    <th style="text-align: center; width: 60px;">Qtd</th>
                    <th style="text-align: right; width: 90px;">Preço</th>
                    <th style="text-align: right; width: 90px;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <tr>
                    <td>
                        <div class="tshirt-container">
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($item->color_code) && file_exists($backgroundsPath . $item->color_code . '.png')): ?>
                            <img src="<?php echo e($backgroundsPath . $item->color_code . '.png'); ?>" class="tshirt-base">
                            <?php elseif(!empty($item->color_code) && file_exists($backgroundsPath . $item->color_code . '.jpg')): ?>
                            <img src="<?php echo e($backgroundsPath . $item->color_code . '.jpg'); ?>" class="tshirt-base">
                            <?php else: ?>
                            <div class="tshirt-base" style="background: #e4e4e7;"></div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            
                            <img src="<?php echo e($catalogPath . $item->estampa_file); ?>" class="tshirt-print">
                                                        
                        </div>
                    </td>

                    <td>
                        <div class="product-title">T-Shirt Personalizada</div>
                        <div class="product-meta">Cor: <?php echo e($item->color_code); ?></div>
                    </td>

                    <td style="text-align: center;">
                        <span class="badge-size"><?php echo e(strtoupper($item->size)); ?></span>
                    </td>

                    <td style="text-align: center; font-weight: bold; color: #71717a;">
                        <?php echo e($item->qty); ?>x
                    </td>

                    <td style="text-align: right; color: #27272a;">
                        <?php echo e(number_format($item->unit_price, 2)); ?>€
                    </td>

                    <td style="text-align: right; font-weight: bold; color: #09090b;">
                        <?php echo e(number_format($item->sub_total, 2)); ?>€
                    </td>
                </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-box">
                <div class="total-row">Subtotal: <?php echo e(number_format($order->total_price, 2)); ?>€</div>
                <div class="grand-total">Total Pago: <?php echo e(number_format($order->total_price, 2)); ?>€</div>
            </div>
        </div>

        <?php

        if(number_format($order->total_price, 2) >= 25.00){
        echo "<h1>és NIGGA</h1>";
        }
        ?>

    </div>

</body>

</html><?php /**PATH C:\laragon\www\ProjetoAinet_prat\resources\views/orders/invoice.blade.php ENDPATH**/ ?>