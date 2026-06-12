<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tshirt_image;
use App\Models\Color;

class CartController extends Controller
{
    public function index()
    {
        // Vai buscar os itens guardados na sessão (ou um array vazio se não existir)
        $cartItems = session()->get('cart', []);

        $tshirtColors = Color::all();
        $tshirtSizes = ['S', 'M', 'L', 'XL'];

        return view('cart.index', compact('cartItems', 'tshirtColors', 'tshirtSizes'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'tshirt_image_id' => 'required|exists:tshirt_images,id',
            'color' => 'required|string',
            'size' => 'required|string|in:S,M,L,XL,s,m,l,xl',
            'quantity' => 'required|integer|min:1'
        ]);

        $tshirt = Tshirt_image::findOrFail($request->tshirt_image_id);
        $cart = session()->get('cart', []);

        // Normalizar o tamanho para maiúsculas (evita chaves duplicadas como 's' e 'S')
        $size = strtoupper($request->size);
        $color = $request->color;

        // Gerar uma chave única baseada no ID da estampa, na cor e no tamanho escolhido
        $itemId = $tshirt->id . '_' . $color . '_' . $size;

        // Determinar se é um design público do catálogo ou um design privado (do cliente)
        $isCatalog = ($tshirt->customer_id === null);

        if (isset($cart[$itemId])) {
            // Se o mesmo produto com a mesma cor e tamanho já existe, soma a quantidade
            $cart[$itemId]['quantity'] += (int) $request->quantity;
        } else {
            // Se for um item novo, adiciona-o ao array
            $cart[$itemId] = [
                'id' => $itemId,
                'tshirt_image_id' => $tshirt->id,
                'imageName' => $tshirt->name,
                'imageUrl' => $tshirt->image_url,
                'color' => $color,
                'size' => $size,
                'quantity' => (int) $request->quantity,
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
            // Se mudou a cor ou o tamanho, a chave única do item muda
            $newColor = $request->input('color', $cart[$itemId]['color']);
            $newSize = $request->input('size', $cart[$itemId]['size']);
            $newQty = (int) $request->input('quantity', $cart[$itemId]['quantity']);

            if ($newQty < 1)
                $newQty = 1;

            $newId = $cart[$itemId]['tshirt_image_id'] . '_' . $newColor . '_' . $newSize;

            // Atualiza os dados do item
            $itemData = $cart[$itemId];
            $itemData['id'] = $newId;
            $itemData['color'] = $newColor;
            $itemData['size'] = $newSize;
            $itemData['quantity'] = $newQty;

            // Remove a chave antiga
            unset($cart[$itemId]);

            // Se o novo ID já existir no carrinho por coincidência, funde as quantidades
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