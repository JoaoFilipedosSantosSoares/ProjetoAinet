<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;       
use App\Models\Category;
use App\Models\Order_Item;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Capturar Filtros da Query String (com valores padrão)
        $anoSelecionado = $request->get('ano', date('Y'));
        $limite = (int) $request->get('limite', 5); // Padrão: 5 linhas

        // ==========================================
        // BLOCO 1: MÉTRICAS GLOBAIS
        // ==========================================
        $vendasTotais = Order::whereYear('date', $anoSelecionado)->sum('total_price');
        $totalEncomendas = Order::whereYear('date', $anoSelecionado)->count();
        $mediaPrecoEncomenda = $totalEncomendas > 0 ? $vendasTotais / $totalEncomendas : 0;

        $totalTshirtsVendidas = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereYear('orders.date', $anoSelecionado)
            ->sum('order_items.qty');

        // ==========================================
        // NOVO BLOCO: ANÁLISE DE MÉDIAS TEMPORAIS (SQLite)
        // ==========================================
        
        // A. Médias Mensais (Faturação total / número de meses com vendas)
        $mesesComVendas = Order::whereYear('date', $anoSelecionado)
            ->selectRaw("strftime('%m', date) as mes")
            ->groupBy('mes')
            ->get()
            ->count();
        $mesesDivisor = $mesesComVendas > 0 ? $mesesComVendas : 1;
        
        $mediaMensalFaturacao = $vendasTotais / $mesesDivisor;
        $mediaMensalQuantidade = $totalTshirtsVendidas / $mesesDivisor;

        // B. Médias Semanais (Faturação total / número de semanas com vendas)
        $semanasComVendas = Order::whereYear('date', $anoSelecionado)
            ->selectRaw("strftime('%W', date) as semana")
            ->groupBy('semana')
            ->get()
            ->count();
        $semanasDivisor = $semanasComVendas > 0 ? $semanasComVendas : 1;

        $mediaSemanalFaturacao = $vendasTotais / $semanasDivisor;
        $mediaSemanalQuantidade = $totalTshirtsVendidas / $semanasDivisor;

        // ==========================================
        // BLOCO 2: TOP RANKINGS
        // ==========================================
        
        // 1. Categorias Mais Rentáveis
        $topCategorias = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('tshirt_images', 'order_items.tshirt_image_id', '=', 'tshirt_images.id') 
            ->join('categories', 'tshirt_images.category_id', '=', 'categories.id')
            ->whereYear('orders.date', $anoSelecionado)
            ->select(
                'categories.name', 
                DB::raw('SUM(order_items.qty) as total_qty'), 
                DB::raw('SUM(order_items.sub_total) as total_revenue')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_revenue', 'desc')
            ->take($limite) // <--- DINÂMICO
            ->get();

        // 2. Estampas Mais Vendidas
        $topEstampas = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('tshirt_images', 'order_items.tshirt_image_id', '=', 'tshirt_images.id')
            ->whereYear('orders.date', $anoSelecionado)
            ->select(
                'tshirt_images.name', 
                DB::raw('SUM(order_items.qty) as total_qty')
            )
            ->groupBy('tshirt_images.id', 'tshirt_images.name')
            ->orderBy('total_qty', 'desc')
            ->take($limite) // <--- DINÂMICO
            ->get();

        // 3. Melhores Clientes
        $topClientes = DB::table('orders')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->join('users', 'customers.id', '=', 'users.id') 
            ->whereYear('orders.date', $anoSelecionado)
            ->select(
                'users.name', 
                'users.email', 
                DB::raw('COUNT(orders.id) as total_orders'), 
                DB::raw('SUM(orders.total_price) as total_spent')
            )
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderBy('total_spent', 'desc')
            ->take($limite) // <--- DINÂMICO
            ->get();

        // Lista de anos para o filtro do topo
        $anosDisponiveis = Order::selectRaw("strftime('%Y', date) as ano")
            ->groupBy('ano')
            ->orderBy('ano', 'desc')
            ->pluck('ano')
            ->toArray();
            
        if (empty($anosDisponiveis)) {
            $anosDisponiveis = [date('Y')];
        }

        $lucrosMeses = array_fill(1, 12, 0);

        // Query para ir buscar a faturação agrupada por mês
        $faturacaoPorMes = Order::whereYear('date', $anoSelecionado)
            ->selectRaw("strftime('%m', date) as mes, SUM(total_price) as total")
            ->groupBy('mes')
            ->get();

        // Preencher o array com os valores reais onde houve vendas
        foreach ($faturacaoPorMes as $dados) {
            $mesId = (int)$dados->mes;
            $lucrosMeses[$mesId] = (float)$dados->total;
        }

        // Transformar o array numa lista simples de 12 números para passar para o JS
        $dadosGrafico = array_values($lucrosMeses);

        // Obter contagem de encomendas agrupadas por mês
        $contagemPorMes = Order::whereYear('date', $anoSelecionado)
            ->selectRaw("strftime('%m', date) as mes, COUNT(id) as total_encomendas")
            ->groupBy('mes')
            ->get();

        // Inicializar array com zeros
        $encomendasMeses = array_fill(1, 12, 0);

        foreach ($contagemPorMes as $dados) {
            $encomendasMeses[(int)$dados->mes] = (int)$dados->total_encomendas;
        }

        $dadosEncomendas = array_values($encomendasMeses);

        return view('staff.estatisticas', compact(
            'vendasTotais',
            'totalEncomendas',
            'mediaPrecoEncomenda',
            'totalTshirtsVendidas',
            'mediaMensalFaturacao',
            'mediaMensalQuantidade',
            'mediaSemanalFaturacao',
            'mediaSemanalQuantidade',
            'topCategorias',
            'topEstampas',
            'topClientes',
            'anoSelecionado',
            'anosDisponiveis',
            'limite',
            'dadosGrafico',
            'dadosEncomendas'
        ));
    }
}
