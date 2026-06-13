<?php

namespace App\Http\Controllers;

use App\Models\Tshirt_image;
use App\Models\Color;
use Illuminate\Http\Request;
use App\Models\Price;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Tshirt_image::with('category')->whereNull('customer_id');

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('name', $request->category));
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $tshirts = $query->paginate(18)->appends($request->query());

        $categories = Tshirt_image::with('category')
            ->whereNull('customer_id')
            ->get()
            ->pluck('category.name')
            ->filter()
            ->unique();

        $catalogImages = collect($tshirts->items())->map(fn($t) => [
            'id' => $t->id,
            'name' => $t->name,
            'category' => $t->category->name ?? 'Sem Categoria',
            'imageUrl' => $t->image_url,
        ]);

        

        return view('catalog.index', [
            'tshirts' => $tshirts,
            'categories' => $categories,
            'catalogImages' => $catalogImages,
            
        ]);
    }

    public function show(Tshirt_image $tshirt, Request $request)
    {
        $colors = Color::all();
        $selectedColorCode = $request->query('color');
        $selectedColor = $colors->where('code', $selectedColorCode)->first() ?? $colors->first();

        // 1. Ir buscar os preços globais à base de dados
        $priceConfig = Price::first();

        // 2. Extrair os valores exatos para o CATÁLOGO
        $basePrice = $priceConfig ? (float) $priceConfig->unit_price_catalog : 10.00;
        $discountPrice = $priceConfig ? (float) $priceConfig->unit_price_catalog_discount : 8.50;
        $qtyTrigger = $priceConfig ? (int) $priceConfig->qty_discount : 10;

        return view('catalog.show', [
            'tshirt' => $tshirt,
            'colors' => $colors,
            'selectedColor' => $selectedColor,
            // 3. Enviar as variáveis de preço para a View
            'basePrice' => $basePrice,
            'discountPrice' => $discountPrice,
            'qtyTrigger' => $qtyTrigger,
        ]);
    }
}
