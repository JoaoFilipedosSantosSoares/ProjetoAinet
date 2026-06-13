<?php

namespace App\Http\Controllers;

use App\Models\Tshirt_Image;
use App\Models\Color;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CustomizationController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('verified'),
        ];
    }

    public function index(Request $request, Tshirt_image $tshirt)
    {
        $user = Auth::user();
        $customerId = $user->customer ? $user->customer->id : null;

        $myImages = Tshirt_Image::query()->orderBy('id', 'desc');
        if ($user->user_type === 'C') {
            $myImages->where('customer_id', $customerId);
        }
        $myImages = $myImages->paginate(12)->withQueryString();

        $colors = Color::all();
        $selectedColorCode = $request->query('color');
        $selectedColor = $colors->where('code', $selectedColorCode)->first() ?? $colors->first();

        $selectedDesignId = $request->query('design');
        if ($selectedDesignId) {
            $chosenImage = Tshirt_Image::find($selectedDesignId);
            if ($chosenImage) {
                $tshirt = $chosenImage;
            }
        }

        $quantity = (int) $request->query('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }

        $priceRules = Price::first();

        $basePrice = $priceRules ? $priceRules->unit_price_own : 15.00;
        $discountPrice = $priceRules ? $priceRules->unit_price_own_discount : 12.00;
        $qtyTrigger = $priceRules ? $priceRules->qty_discount : 10;

        $hasDiscount = false;
        $unitPrice = $basePrice;

        if ($quantity >= $qtyTrigger) {
            $unitPrice = $discountPrice;
            $hasDiscount = true;
        }

        $totalPrice = $unitPrice * $quantity;

        return view('customization.index', compact(
            'myImages',
            'colors',
            'selectedColor',
            'tshirt',
            'priceRules',
            'quantity',
            'unitPrice',
            'basePrice',
            'discountPrice', 
            'qtyTrigger',    
            'totalPrice',
            'hasDiscount'
        ));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'photo.image' => 'O ficheiro selecionado tem de ser uma imagem.',
            'photo.max' => 'A foto não pode ter mais do que 2MB.',
        ]);

        $user = Auth::user();
        $file = $request->file('photo');

        $fileName = time() . '_' . $file->getClientOriginalName();

        $destinationPath = storage_path('app/private/tshirt_images_private');

        $file->move($destinationPath, $fileName);

        $newDesign = Tshirt_Image::create([
            'customer_id' => $user->customer ? $user->customer->id : null,
            'category_id' => null,
            'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'image_url' => $fileName,
            'description' => $request->input('description') ?? 'Design carregado pelo utilizador.',
        ]);

        return redirect()->route('customization.index', [
            'design' => $newDesign->id,
            'color' => $request->input('color')
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        $user = Auth::user();

        $customerId = $user->customer ? $user->customer->id : $user->id;

        $tshirtImage = DB::transaction(function () use ($request, $customerId) {
            $newImage = new Tshirt_Image();
            $newImage->customer_id = $customerId; 
            $newImage->name = $request->name;
            $newImage->description = $request->description;
            $newImage->shared = 0;
            $newImage->image_url = '';
            $newImage->save();

            if ($request->hasFile('image_file')) {
                $path = $request->file('image_file')->store('tshirt_images_private');
                $newImage->image_url = basename($path);
                $newImage->save();
            }

            return $newImage;
        });

        $htmlMessage = "A imagem personalizada <b>{$tshirtImage->name}</b> foi enviada com sucesso!";

        return redirect()->route('customization.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function edit($id)
    {
        $image = Tshirt_Image::findOrFail($id);


        return view('customization.edit', compact('image'));
    }

    public function update(Request $request, $id)
    {
        $image = Tshirt_Image::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $image->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('customization.index', ['design' => $image->id])
            ->with('success', 'Design atualizado com sucesso!');
    }

    public function destroy(Tshirt_Image $tshirtImage): RedirectResponse
    {
        if ((int) auth()->id() !== (int) $tshirtImage->customer_id) {
            abort(403, 'Ação não autorizada. Esta imagem pertence a outro utilizador.');
        }

        try {
            $filename = $tshirtImage->image_url;

            DB::transaction(function () use ($tshirtImage) {
                $tshirtImage->delete();
            });

            if ($filename && Storage::exists('tshirt_images_private/' . $filename)) {
                Storage::delete('tshirt_images_private/' . $filename);
            }

            return redirect()->route('customization.index')
                ->with('success', "A imagem personalizada foi eliminada com sucesso.");
        } catch (\Exception $error) {
            return redirect()->route('customization.index')
                ->with('error', "Não foi possível eliminar a imagem porque ela já está associada a encomendas existentes.");
        }
    }
}
