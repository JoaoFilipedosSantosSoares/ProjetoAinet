<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Tshirt_Image;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Price;

class ManagementController extends Controller
{
    public function index(Request $request): View
    {
        $filterByCategory = $request->query('category_id');
        $filterBySearch = $request->query('search');

        $categories = Category::orderBy('name')->get();
        $colors = Color::orderBy('name')->get();

        $prices = Price::first();

        $catalogQuery = Tshirt_Image::whereNull('customer_id');

        if ($filterByCategory !== null) {
            $catalogQuery->where('category_id', $filterByCategory);
        }

        if ($filterBySearch !== null) {
            $catalogQuery->where(function ($q) use ($filterBySearch) {
                $q->where('name', 'like', "%$filterBySearch%")
                    ->orWhere('description', 'like', "%$filterBySearch%");
            });
        }

        $catalogImages = $catalogQuery
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('staff.gestao', compact('catalogImages', 'categories', 'colors', 'prices', 'filterByCategory', 'filterBySearch'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        
        $tshirtImage = new Tshirt_Image();

        return view('staff.imagem_form', compact('categories', 'tshirtImage'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image_file' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], [
            'name.required' => 'O nome da imagem é obrigatório.',
            'category_id.required' => 'Deve selecionar uma categoria válida.',
            'image_file.required' => 'A imagem do catálogo é obrigatória.',
            'image_file.image' => 'O ficheiro tem de ser uma imagem válida.',
            'image_file.max' => 'A imagem não pode ter mais do que 2MB.',
        ]);

        DB::transaction(function () use ($request, $validated) {
            // 1. Ir buscar a extensão do ficheiro enviado
            $extension = $request->file('image_file')->getClientOriginalExtension();

            // 2. Gerar um nome único e seguro antes de inserir na BD
            $newFileName = 'catalogImage_' . uniqid() . '.' . $extension;

            // 3. Fazer o upload do ficheiro para a pasta storage/app/public/tshirt_images
            $request->file('image_file')->storeAs('tshirt_images', $newFileName, 'public');

            // 4. Criar o registo na Base de Dados
            Tshirt_Image::create([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'category_id' => $validated['category_id'],
                'image_url' => $newFileName, 
                'customer_id' => null,       // Nulo porque é para o catálogo global
            ]);
        });

        return redirect()->route('staff.gestao')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Nova imagem adicionada ao catálogo!');
    }
    public function edit(Tshirt_Image $tshirtImage): View
    {
        if ($tshirtImage->customer_id !== null) {
            abort(403, 'Não pode editar imagens privadas.');
        }

        $categories = Category::orderBy('name')->get();

        // Enviamos o formulário para a mesma view, mas com o objeto preenchido
        return view('staff.imagem_form', compact('categories', 'tshirtImage'));
    }

    public function update(Request $request, Tshirt_Image $tshirtImage): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image_file' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], [
            'name.required' => 'O nome é obrigatório.',
            'category_id.required' => 'Selecione uma categoria válida.',
            'image_file.image' => 'O ficheiro de substituição deve ser uma imagem válida.',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'category_id' => $validated['category_id'],
        ];

        if ($request->hasFile('image_file')) {
            $extension = $request->file('image_file')->getClientOriginalExtension();
            $newFileName = 'catalogImage_' . $tshirtImage->id . '.' . $extension;

            // Apagar a imagem antiga se ela existir
            if ($tshirtImage->image_url && Storage::disk('public')->exists('tshirt_images/' . $tshirtImage->image_url)) {
                Storage::disk('public')->delete('tshirt_images/' . $tshirtImage->image_url);
            }

            // Upload da nova
            $request->file('image_file')->storeAs('tshirt_images', $newFileName, 'public');
            $updateData['image_url'] = $newFileName;
        }

        $tshirtImage->update($updateData);

        return redirect()
            ->route('staff.gestao')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Imagem do catálogo atualizada com sucesso!');
    }

    public function destroy(Tshirt_Image $tshirtImage): RedirectResponse
    {
        try {
            DB::transaction(function () use ($tshirtImage) {
                // 1. Apagar o ficheiro físico do storage primeiro
                if ($tshirtImage->image_url && Storage::disk('public')->exists('tshirt_images/' . $tshirtImage->image_url)) {
                    Storage::disk('public')->delete('tshirt_images/' . $tshirtImage->image_url);
                }

                // 2. Apagar o registo da BD
                $tshirtImage->delete();
            });

            return redirect()->route('staff.gestao')
                ->with('alert-type', 'success')
                ->with('alert-msg', "A imagem <b>{$tshirtImage->name}</b> foi removida do catálogo.");
        } catch (\Exception $error) {
            return redirect()->back()
                ->with('alert-type', 'danger')
                ->with('alert-msg', "Não foi possível eliminar a imagem porque já existem encomendas associadas a ela.");
        }
    }

    public function updatePrices(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'unit_price_catalog' => 'required|numeric|min:0',
            'unit_price_own' => 'required|numeric|min:0',
            'qty_discount' => 'required|integer|min:1',
        ], [
            'unit_price_catalog.required' => 'O preço do catálogo é obrigatório.',
            'unit_price_own.required' => 'O preço da t-shirt personalizada é obrigatório.',
            'qty_discount.required' => 'A quantidade para desconto é obrigatória.',
            'qty_discount.integer' => 'A quantidade deve ser um número inteiro.',
        ]);

        // Busca as configurações atuais (ou cria uma se a tabela estiver vazia)
        $prices = Price::first();

        if (!$prices) {
            $prices = new Price();
        }

        // Atualiza os valores vindos do formulário
        $prices->unit_price_catalog = $validated['unit_price_catalog'];
        $prices->unit_price_own = $validated['unit_price_own'];
        $prices->qty_discount = $validated['qty_discount'];

        $prices->unit_price_catalog_discount = $prices->unit_price_catalog_discount ?? 0;
        $prices->unit_price_own_discount = $prices->unit_price_own_discount ?? 0;

        $prices->save();

        return redirect()->route('staff.gestao')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Preços e regras de desconto atualizados com sucesso!');
    }

    /*
    |--------------------------------------------------------------------------
    | GESTÃO DE CATEGORIAS 
    |--------------------------------------------------------------------------
    */
    public function storeCategory(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ], [
            'name.required' => 'O nome da categoria é obrigatório.',
            'name.unique' => 'Esta categoria já existe.',
        ]);

        Category::create([
            'name' => $validated['name']
        ]);

        return redirect()->route('staff.gestao')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Nova categoria criada com sucesso!');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($validated);

        return redirect()->back()->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroyCategory(Category $category): RedirectResponse
    {
        try {
            DB::transaction(function () use ($category) {
                $category->delete();
            });

            return redirect()->route('staff.gestao')
                ->with('alert-type', 'success')
                ->with('alert-msg', "A categoria <b>{$category->name}</b> foi eliminada com sucesso!");
        } catch (\Exception $error) {
            return redirect()->back()
                ->with('alert-type', 'danger')
                ->with('alert-msg', "Não é possível eliminar esta categoria porque existem imagens do catálogo ou t-shirts associadas a ela.");
        }
    }

    /*
    |--------------------------------------------------------------------------
    | GESTÃO DE CORES (Novo)
    |--------------------------------------------------------------------------
    */
    public function storeColor(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:6|unique:colors,code',
            'name' => 'required|string|max:255',
            'tshirt_image' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], [
            'code.required' => 'O código HEX é obrigatório.',
            'code.unique' => 'Já existe uma cor registada com esse código HEX.',
            'name.required' => 'O nome da cor é obrigatório.',
            'tshirt_image.required' => 'O upload da imagem da t-shirt base é obrigatório.',
            'tshirt_image.max' => 'A imagem da t-shirt não pode ter mais do que 2MB.',
        ]);

        try {
            DB::transaction(function () use ($request, $validated) {
                $fileName = strtolower($validated['code']) . '.jpg';

                $request->file('tshirt_image')->storeAs('tshirt_base', $fileName, 'public');

                Color::create([
                    'code' => strtoupper($validated['code']),
                    'name' => $validated['name'],
                ]);
            });

            return redirect()->route('staff.gestao')
                ->with('alert-type', 'success')
                ->with('alert-msg', "A cor <b>{$validated['name']}</b> e a respetiva t-shirt base foram adicionadas com sucesso!");
        } catch (\Exception $error) {
            return redirect()->back()
                ->withInput()
                ->with('alert-type', 'danger')
                ->with('alert-msg', 'Ocorreu um erro ao salvar a cor. Certifique-se de que os dados são válidos.');
        }
    }

    public function updateColor(Request $request, Color $color)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:6',
            'name' => 'required|string|max:255',
            'tshirt_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        // tudo trabalha em minúsculas
        $oldCode = strtolower($color->code);
        $newCode = strtolower($validated['code']);

        if ($request->hasFile('tshirt_image')) {
            // Apaga as imagens antigas se existirem 
            if (Storage::disk('public')->exists("tshirt_base/{$oldCode}.jpg")) {
                Storage::disk('public')->delete("tshirt_base/{$oldCode}.jpg");
            }
            if (Storage::disk('public')->exists("tshirt_base/{$oldCode}.png")) {
                Storage::disk('public')->delete("tshirt_base/{$oldCode}.png");
            }

            // Guarda a nova imagem acompanhando o novo código 
            $extension = $request->file('tshirt_image')->getClientOriginalExtension();
            $fileName = $newCode . '.' . $extension;
            $request->file('tshirt_image')->storeAs('tshirt_base', $fileName, 'public');
        } elseif ($oldCode !== $newCode) {
            // Se mudou o código mas NÃO enviou imagem, apenas renomeia o ficheiro existente
            if (Storage::disk('public')->exists("tshirt_base/{$oldCode}.jpg")) {
                Storage::disk('public')->move("tshirt_base/{$oldCode}.jpg", "tshirt_base/{$newCode}.jpg");
            }
            if (Storage::disk('public')->exists("tshirt_base/{$oldCode}.png")) {
                Storage::disk('public')->move("tshirt_base/{$oldCode}.png", "tshirt_base/{$newCode}.png");
            }
        }

        // Para evitar fazer update à própria Chave Primária
        $updateData = ['name' => $validated['name']];
        if ($oldCode !== $newCode) {
            $updateData['code'] = $newCode;
        }

        $color->update($updateData);

        return redirect()->back()->with('success', 'Cor atualizada com sucesso!');
    }

    public function destroyColor(Color $color): RedirectResponse
    {
        try {
            DB::transaction(function () use ($color) {
                $color->delete();
            });

            return redirect()->route('staff.gestao')
                ->with('alert-type', 'success')
                ->with('alert-msg', "A cor <b>{$color->name}</b> foi removida do catálogo.");
        } catch (\Exception $error) {
            return redirect()->back()
                ->with('alert-type', 'danger')
                ->with('alert-msg', "Não é possível eliminar esta cor porque existem t-shirts em stock ou encomendas associadas a ela.");
        }
    }
}
