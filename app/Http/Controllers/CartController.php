<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tshirt_image;
use App\Models\Color;
use App\Models\Price;

class CartController extends Controller
{
    private function getStorePrices()
    {
        return Price::first();
    }

    public function index()
    {
        $cartItems = session()->get('cart', []);
        $tshirtColors = Color::all();
        $tshirtSizes = ['S', 'M', 'L', 'XL'];
        $priceRules = $this->getStorePrices();
        
        return view('cart.index', compact('cartItems', 'tshirtColors', 'tshirtSizes', 'priceRules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tshirt_image_id' => 'required|exists:tshirt_images,id',
            'color'           => 'required|string',
            'size'            => 'required|string',
            'quantity'        => 'required|integer|min:1'
        ]);

        $tshirt = Tshirt_image::findOrFail($request->tshirt_image_id);
        $cart = session()->get('cart', []);

        $size = strtoupper($request->size);
        $color = $request->color;
        $itemId = $tshirt->id . '_' . $color . '_' . $size;
        $isCatalogImage = is_null($tshirt->customer_id);

        if (isset($cart[$itemId])) {
            $cart[$itemId]['quantity'] += $request->quantity;
        } else {
            $cart[$itemId] = [
                'id'              => $itemId,
                'tshirt_image_id' => $tshirt->id,
                'name'            => $tshirt->name ?? 'Minha Estampa',
                'imageUrl'        => $tshirt->image_url,
                'color'           => $color,
                'size'            => $size,
                'quantity'        => $request->quantity,
                'isCatalogImage'  => $isCatalogImage
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Item adicionado ao carrinho com sucesso!');
    }

    public function update(Request $request, $itemId)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$itemId])) {
            return redirect()->route('cart.index');
        }

        $newQty = (int)$request->input('quantity', $cart[$itemId]['quantity']);

        // Se a quantidade for alterada para 0 ou menos, remove automaticamente
        if ($newQty <= 0) {
            unset($cart[$itemId]);
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Item removido do carrinho.');
        }

        $newColor = $request->input('color', $cart[$itemId]['color']);
        $newSize = strtoupper($request->input('size', $cart[$itemId]['size']));

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

        return redirect()->route('cart.index')->with('success', 'Linha atualizada.');
    }

    public function remove($itemId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$itemId])) {
            unset($cart[$itemId]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Item removido.');
    }

    public function clear()
    {
        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Carrinho esvaziado.');
    }
}