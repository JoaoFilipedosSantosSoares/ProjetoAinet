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
            // Apenas Clientes autenticados e verificados podem mexer nas suas personalizações
            new Middleware('auth'),
            new Middleware('verified'),
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
        $colors = Color::all();
        $selectedColorCode = $request->query('color');
        $selectedColor = $colors->where('code', $selectedColorCode)->first() ?? $colors->first();

        // 3. Verificar se veio um design selecionado por link
        $selectedDesignId = $request->query('design');
        if ($selectedDesignId) {
            $chosenImage = Tshirt_Image::find($selectedDesignId);
            if ($chosenImage) {
                $tshirt = $chosenImage;
            }
        }

        // 4. CÁLCULO DE PREÇOS NO SERVIDOR (SEM JAVASCRIPT)
        $quantity = (int) $request->query('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }

        $priceRules = Price::first();

        // Valores de salvaguarda atualizados para coincidir com a tua DB atual
        $basePrice = $priceRules ? $priceRules->unit_price_own : 15.00;
        $discountPrice = $priceRules ? $priceRules->unit_price_own_discount : 12.00;
        $qtyTrigger = $priceRules ? $priceRules->qty_discount : 10;

        $hasDiscount = false;
        $unitPrice = $basePrice;

        // Aplicar a regra de desconto por quantidade para imagens próprias (Own)
        // Só passa para 12€ se o cliente encomendar 10 ou mais unidades
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
        // 1. Validação do ficheiro
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'photo.image' => 'O ficheiro selecionado tem de ser uma imagem.',
            'photo.max' => 'A foto não pode ter mais do que 2MB.',
        ]);

        $user = Auth::user();
        $file = $request->file('photo');

        // Gerar o nome do ficheiro
        $fileName = time() . '_' . $file->getClientOriginalName();

        // 2. SOLUÇÃO COMPATÍVEL: Mover diretamente para a pasta privada do sistema
        // Isto vai colocar o ficheiro exatamente em: storage/app/private/tshirt_images_private/
        $destinationPath = storage_path('app/private/tshirt_images_private');

        $file->move($destinationPath, $fileName);

        // 3. Criar o registo na Base de Dados
        $newDesign = Tshirt_Image::create([
            'customer_id' => $user->customer ? $user->customer->id : null,
            'category_id' => null,
            'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'image_url' => $fileName,
            'description' => $request->input('description') ?? 'Design carregado pelo utilizador.',
        ]);

        // 4. Redirecionar
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

    public function edit($id)
    {
        // Procura a imagem pelo ID ou falha (404) se não existir
        $image = Tshirt_Image::findOrFail($id);

        // if ($image->customer_id !== auth()->id()) { abort(403); }

        return view('customization.edit', compact('image'));
    }

    public function update(Request $request, $id)
    {
        $image = Tshirt_Image::findOrFail($id);

        // Opcional: Segurança extra para garantir propriedade
        // if ($image->customer_id !== auth()->id()) { abort(403); }

        // Validação simples
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // Atualiza apenas os campos permitidos
        $image->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Redireciona de volta para a página principal de customização selecionando este design
        return redirect()
            ->route('customization.index', ['design' => $image->id])
            ->with('success', 'Design atualizado com sucesso!');
    }

    public function destroy(Tshirt_Image $tshirtImage): RedirectResponse
    {
        // SEGURANÇA MÁXIMA: Se o ID do utilizador logado for diferente do dono da imagem, bloqueia!
        if ((int) auth()->id() !== (int) $tshirtImage->customer_id) {
            abort(403, 'Ação não autorizada. Esta imagem pertence a outro utilizador.');
        }

        try {
            $filename = $tshirtImage->image_url;

            // A Base de Dados trata de apagar o registo de forma segura
            DB::transaction(function () use ($tshirtImage) {
                $tshirtImage->delete();
            });

            // O ficheiro físico só sai do disco se a transação correu bem na BD
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
