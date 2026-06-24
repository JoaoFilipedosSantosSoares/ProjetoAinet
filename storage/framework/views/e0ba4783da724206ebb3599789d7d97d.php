<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php $__env->startComponent('layouts.main-content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-zinc-200 pb-5">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900">Painel de Estatísticas</h1>
            <p class="text-sm text-zinc-500">Monitorização de desempenho, médias temporais e rankings do negócio.</p>
        </div>
        
        <form method="GET" action="<?php echo e(route('staff.estatisticas')); ?>" class="flex flex-wrap items-center gap-4">
            <div class="flex items-center gap-2">
                <label class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Ano:</label>
                <select name="ano" onchange="this.form.submit()" 
                    class="h-9 rounded-xl border border-zinc-300 bg-white px-3 text-sm text-zinc-900 font-medium focus:border-zinc-950 focus:outline-none shadow-sm">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $anosDisponiveis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ano): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($ano); ?>" <?php echo e($ano == $anoSelecionado ? 'selected' : ''); ?>><?php echo e($ano); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <label class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Visualizar (Top):</label>
                <select name="limite" onchange="this.form.submit()" 
                    class="h-9 rounded-xl border border-zinc-300 bg-white px-3 text-sm text-zinc-900 font-medium focus:border-zinc-950 focus:outline-none shadow-sm">
                    <option value="5" <?php echo e($limite == 5 ? 'selected' : ''); ?>>5 Resultados</option>
                    <option value="10" <?php echo e($limite == 10 ? 'selected' : ''); ?>>10 Resultados</option>
                    <option value="20" <?php echo e($limite == 20 ? 'selected' : ''); ?>>20 Resultados</option>
                    <option value="50" <?php echo e($limite == 50 ? 'selected' : ''); ?>>50 Resultados</option>
                </select>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">Volume de Vendas</p>
            <p class="mt-2 text-3xl font-bold tracking-tight text-zinc-900"><?php echo e(number_format($vendasTotais, 2, ',', '.')); ?> €</p>
            <p class="mt-1 text-xs text-zinc-500">Total faturado em <?php echo e($anoSelecionado); ?></p>
        </div>

        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">Encomendas Processadas</p>
            <p class="mt-2 text-3xl font-bold tracking-tight text-zinc-900"><?php echo e($totalEncomendas); ?></p>
            <p class="mt-1 text-xs text-zinc-500">Volume total de pedidos</p>
        </div>

        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">Ticket Médio</p>
            <p class="mt-2 text-3xl font-bold tracking-tight text-zinc-900"><?php echo e(number_format($mediaPrecoEncomenda, 2, ',', '.')); ?> €</p>
            <p class="mt-1 text-xs text-zinc-500">Valor médio por compra</p>
        </div>

        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">Produtos Vendidos</p>
            <p class="mt-2 text-3xl font-bold tracking-tight text-zinc-900"><?php echo e($totalTshirtsVendidas ?? 0); ?></p>
            <p class="mt-1 text-xs text-zinc-500">Quantidade de t-shirts físicas</p>
        </div>
    </div>

    <div class="w-full block clear-both lg:col-span-3 xl:col-span-3 mt-8">
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm w-full">
            <div class="mb-4">
                <h3 class="text-base font-bold text-zinc-900">Evolução Mensal de Faturação</h3>
                <p class="text-sm text-zinc-400">Análise macro do fluxo de caixa faturado em cada mês do ano de <?php echo e($anoSelecionado); ?>.</p>
            </div>
            
            <div class="h-80 w-full relative">
                <canvas id="lucrosChart"></canvas>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
        <div class="mb-4">
            <h3 class="text-base font-bold text-zinc-900">Análise de Médias Periódicas</h3>
            <p class="text-sm text-zinc-400">Métricas de desempenho calculadas proporcionalmente por frações de tempo.</p>
        </div>
        <div class="overflow-hidden rounded-xl border border-zinc-200">
            <table class="w-full text-left text-sm text-zinc-500 border-collapse">
                <thead class="bg-zinc-50 border-b border-zinc-200 text-xs font-bold text-zinc-600 uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3">Período Temporal</th>
                        <th class="px-4 py-3 text-right">Média de Faturação (€)</th>
                        <th class="px-4 py-3 text-right">Média de Produtos Vendidos (Qtd)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 bg-white font-medium">
                    <tr class="hover:bg-zinc-50/50">
                        <td class="px-4 py-3.5 text-zinc-900 font-bold">Média Anual (Global)</td>
                        <td class="px-4 py-3.5 text-right text-zinc-900 font-bold"><?php echo e(number_format($vendasTotais, 2, ',', '.')); ?> €</td>
                        <td class="px-4 py-3.5 text-right text-zinc-900 font-bold"><?php echo e(number_format($totalTshirtsVendidas, 0)); ?> un.</td>
                    </tr>
                    <tr class="hover:bg-zinc-50/50">
                        <td class="px-4 py-3.5 text-zinc-700">Média Mensal</td>
                        <td class="px-4 py-3.5 text-right font-semibold text-zinc-900"><?php echo e(number_format($mediaMensalFaturacao, 2, ',', '.')); ?> €</td>
                        <td class="px-4 py-3.5 text-right text-zinc-600"><?php echo e(number_format($mediaMensalQuantidade, 1, ',', '.')); ?> un.</td>
                    </tr>
                    <tr class="hover:bg-zinc-50/50">
                        <td class="px-4 py-3.5 text-zinc-700">Média Semanal</td>
                        <td class="px-4 py-3.5 text-right font-semibold text-zinc-900"><?php echo e(number_format($mediaSemanalFaturacao, 2, ',', '.')); ?> €</td>
                        <td class="px-4 py-3.5 text-right text-zinc-600"><?php echo e(number_format($mediaSemanalQuantidade, 1, ',', '.')); ?> un.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm flex flex-col h-[800px]">
            <div class="mb-4">
                <h3 class="text-base font-bold text-zinc-900">Categorias + Rentáveis (Top <?php echo e($limite); ?>)</h3>
                <p class="text-xs text-zinc-400">Ordenado por receita financeira total.</p>
            </div>
            <div class="overflow-x-auto overflow-y-auto max-h-[680px] rounded-xl border border-zinc-200 flex-1 scrollbar-thin">
                <table class="w-full text-left text-sm text-zinc-500 border-collapse">
                    <thead class="bg-zinc-50 border-b border-zinc-200 text-xs font-bold text-zinc-600 uppercase tracking-wider sticky top-0 z-10">
                        <tr>
                            <th class="px-4 py-2.5 bg-zinc-50">Categoria</th>
                            <th class="px-4 py-2.5 text-right bg-zinc-50">Qtd</th>
                            <th class="px-4 py-2.5 text-right bg-zinc-50">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 bg-white">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $topCategorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="hover:bg-zinc-50/80">
                                <td class="px-4 py-3 font-medium text-zinc-900"><?php echo e($cat->name); ?></td>
                                <td class="px-4 py-3 text-right text-zinc-600"><?php echo e($cat->total_qty); ?></td>
                                <td class="px-4 py-3 text-right font-semibold text-zinc-900"><?php echo e(number_format($cat->total_revenue, 2, ',', '.')); ?> €</td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr><td colspan="3" class="p-4 text-center text-xs text-zinc-400">Sem registos.</td></tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm flex flex-col h-[800px]">
            <div class="mb-4">
                <h3 class="text-base font-bold text-zinc-900">Líderes de Catálogo (Top <?php echo e($limite); ?>)</h3>
                <p class="text-xs text-zinc-400">As estampas oficiais mais compradas.</p>
            </div>
            <div class="overflow-x-auto overflow-y-auto max-h-[680px] rounded-xl border border-zinc-200 flex-1 scrollbar-thin">
                <table class="w-full text-left text-sm text-zinc-500 border-collapse">
                    <thead class="bg-zinc-50 border-b border-zinc-200 text-xs font-bold text-zinc-600 uppercase tracking-wider sticky top-0 z-10">
                        <tr>
                            <th class="px-4 py-2.5 bg-zinc-50">Estampa</th>
                            <th class="px-4 py-2.5 text-right bg-zinc-50">Unidades</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 bg-white">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $topEstampas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $est): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="hover:bg-zinc-50/80">
                                <td class="px-4 py-3 font-medium text-zinc-900"><?php echo e($est->name); ?></td>
                                <td class="px-4 py-3 text-right font-semibold text-zinc-900"><?php echo e($est->total_qty); ?></td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr><td colspan="2" class="p-4 text-center text-xs text-zinc-400">Sem registos.</td></tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm flex flex-col h-[800px]">
            <div class="mb-4">
                <h3 class="text-base font-bold text-zinc-900">Clientes VIP (Top <?php echo e($limite); ?>)</h3>
                <p class="text-xs text-zinc-400">Utilizadores com maior volume acumulado.</p>
            </div>
            <div class="overflow-x-auto overflow-y-auto max-h-[680px] rounded-xl border border-zinc-200 flex-1 scrollbar-thin">
                <table class="w-full text-left text-sm text-zinc-500 border-collapse">
                    <thead class="bg-zinc-50 border-b border-zinc-200 text-xs font-bold text-zinc-600 uppercase tracking-wider sticky top-0 z-10">
                        <tr>
                            <th class="px-4 py-2.5 bg-zinc-50">Cliente</th>
                            <th class="px-4 py-2.5 text-right bg-zinc-50">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 bg-white">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $topClientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cli): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="hover:bg-zinc-50/80">
                                <td class="px-4 py-3">
                                    <p class="font-medium text-zinc-900 leading-tight"><?php echo e($cli->name); ?></p>
                                    <p class="text-[10px] text-zinc-400 mt-0.5"><?php echo e($cli->email); ?></p>
                                </td>
                                <td class="px-4 py-3 text-right font-semibold text-zinc-900"><?php echo e(number_format($cli->total_spent, 2, ',', '.')); ?> €</td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr><td colspan="2" class="p-4 text-center text-xs text-zinc-400">Sem registos.</td></tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<?php echo $__env->renderComponent(); ?>
<script>
    const dadosFaturacao = <?php echo json_encode($dadosGrafico, 15, 512) ?>;
    const dadosEncomendas = <?php echo json_encode($dadosEncomendas, 15, 512) ?>;

    const maxLucro = Math.max(...dadosFaturacao);
    
    const mesesComVendas = dadosFaturacao.filter(valor => valor > 0);
    const minLucro = mesesComVendas.length > 0 ? Math.min(...mesesComVendas) : 0;

    const coresBarras = dadosFaturacao.map(valor => {
        if (valor === maxLucro && maxLucro > 0) {
            return '#22c55e'; 
        }
        if (valor === minLucro && minLucro > 0) {
            return '#ef4444'; 
        }
        return '#18181b';     
    });

    const ctx = document.getElementById('lucrosChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            datasets: [{
                label: 'Faturação Mensal (€)',
                data: dadosFaturacao,
                backgroundColor: coresBarras,
                borderRadius: 6,
                borderWidth: 0,
                categoryPercentage: 0.8,
                barPercentage: 0.9
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let valorFaturacao = context.raw.toLocaleString('pt-PT', { style: 'currency', currency: 'EUR' });
                            let numEncomendas = dadosEncomendas[context.dataIndex];
                            
                            return [
                                `Faturação: ${valorFaturacao}`,
                                `Vendas: ${numEncomendas} encomendas`
                            ];
                        }
                    }
                },
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f4f4f5' },
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('pt-PT') + ' €';
                        },
                        font: { size: 11 }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 } }
                }
            }
        }
    });
</script><?php /**PATH C:\laragon\www\ProjetoAinet\resources\views/staff/estatisticas.blade.php ENDPATH**/ ?>