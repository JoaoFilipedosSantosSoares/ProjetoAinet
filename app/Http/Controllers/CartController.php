<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tshirt_image;
use App\Models\Color;
use App\Models\Price; // Importação do teu modelo Prices

class CartController extends Controller
{
    /**
     * Helper privado para obter as regras de preço ativas no modelo Prices.
     */
    private function getStorePrices()
    {
        return Price::first();
    }

    public function index()
    {
        $cartItems = session()->get('cart', []);
        $tshirtColors = Color::all();
        $tshirtSizes = ['S', 'M', 'L', 'XL'];
        
        // Vai buscar o registo único de preços através do modelo
        $priceRules = $this->getStorePrices();
        
        return view('cart.index', compact('cartItems', 'tshirtColors', 'tshirtSizes', 'priceRules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tshirt_image_id' => 'required|exists:tshirt_images,id',
            'color' => 'required|string',
            'size' => 'required|string',
            'quantity' => 'required|integer|min:1'
        ]);

        $tshirt = Tshirt_image::findOrFail($request->tshirt_image_id);
        $cart = session()->get('cart', []);

        $size = strtoupper($request->size);
        $color = $request->color;

        // Chave única para o item (Combinação exata de Imagem + Cor + Tamanho)
        $itemId = $tshirt->id . '_' . $color . '_' . $size;
        $isCatalog = ($tshirt->customer_id === null);

        if (isset($cart[$itemId])) {
            $cart[$itemId]['quantity'] += (int)$request->quantity;
        } else {
            $cart[$itemId] = [
                'id' => $itemId,
                'tshirt_image_id' => $tshirt->id,
                'imageName' => $tshirt->name,
                'imageUrl' => $tshirt->image_url,
                'color' => $color,
                'size' => $size,
                'quantity' => (int)$request->quantity,
                'isCatalogImage' => $isCatalog,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Item adicionado ao carrinho!');
    }

    public function update(Request $request, $itemId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$itemId])) {
            $newColor = $request->input('color', $cart[$itemId]['color']);
            $newSize = strtoupper($request->input('size', $cart[$itemId]['size']));
            $newQty = (int)$request->input('quantity', $cart[$itemId]['quantity']);

            if ($newQty < 1) $newQty = 1;

            $newId = $cart[$itemId]['tshirt_image_id'] . '_' . $newColor . '_' . $newSize;

            $itemData = $cart[$itemId];
            $itemData['id'] = $newId;
            $itemData['color'] = $newColor;
            $itemData['size'] = $newSize;
            $itemData['quantity'] = $newQty;

            unset($cart[$itemId]);

            if (isset($cart[$newId])) {
                $cart[$newId]['quantity'] += $newQty;
            } else {
                $cart[$newId] = $itemData;
            }

            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    public function remove($itemId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$itemId])) {
            unset($cart[$itemId]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index');
    }
}