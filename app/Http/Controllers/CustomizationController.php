<?php

namespace App\Http\Controllers;

use App\Models\Tshirt_Image;
use App\Models\Color;
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
            // Apenas Clientes autenticados e verificados podem mexer nas suas personalizações
            new Middleware('auth'),
            new Middleware('verified'),

            // Regra fina da Policy: Garante que o cliente só apaga as SUAS próprias imagens
            new Middleware('can:delete,tshirtImage', only: ['destroy']),
        ];
    }

    public function index(Request $request, Tshirt_image $tshirt)
    {
        $user = Auth::user();
        $customerId = $user->customer ? $user->customer->id : null;

        // 1. Listagem das minhas imagens
        $myImages = Tshirt_Image::query()->orderBy('id', 'desc');
        if ($user->user_type === 'C') {
            $myImages->where('customer_id', $customerId);
        }
        $myImages = $myImages->paginate(12)->withQueryString();

        // 2. Gestão das Cores
        $colours = Color::all();
        $selectedColorCode = $request->query('color');
        $selectedColor = $colours->where('code', $selectedColorCode)->first() ?? $colours->first();

        // 3. NOVA LÓGICA SEM JAVASCRIPT: Verificar se veio um design selecionado por link
        $selectedDesignId = $request->query('design');
        if ($selectedDesignId) {
            // Se o utilizador clicou num design do catálogo, esse passa a ser o $tshirt de preview
            $chosenImage = Tshirt_Image::find($selectedDesignId);
            if ($chosenImage) {
                $tshirt = $chosenImage;
            }
        }

        return view('customization.index', [
            'myImages' => $myImages,
            'colours' => $colours,
            'selectedColor' => $selectedColor,
            'tshirt' => $tshirt,
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

        // Se for cliente, usa o ID de Cliente. Se for Admin/Staff, usa o ID de utilizador temporariamente para não quebrar a BD
        $customerId = $user->customer ? $user->customer->id : $user->id;

        $tshirtImage = DB::transaction(function () use ($request, $customerId) {
            $newImage = new Tshirt_Image();
            $newImage->customer_id = $customerId; // Salva o ID correto de quem enviou
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

    public function destroy(Tshirt_Image $tshirtImage): RedirectResponse
    {
        try {
            DB::transaction(function () use ($tshirtImage) {
                $filename = $tshirtImage->image_url;

                // 1. Apaga o registo da Base de Dados
                $tshirtImage->delete();

                // 2. Apaga o ficheiro físico do storage privado (Última operação do bloco como o professor faz)
                if ($filename && Storage::exists('tshirt_images_private/' . $filename)) {
                    Storage::delete('tshirt_images_private/' . $filename);
                }
            });

            $alertType = 'success';
            $alertMsg = "A imagem personalizada foi eliminada com sucesso.";

        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "Não foi possível eliminar a imagem porque ela já está associada a encomendas existentes.";
        }

        return redirect()->route('customization.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
}
