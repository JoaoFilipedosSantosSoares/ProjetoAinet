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
class ManagementController extends Controller
{
    public function index(Request $request): View
    {
        $filterByCategory = $request->query('category_id');
        $filterBySearch = $request->query('search');

        $categories = Category::orderBy('name')->get();
        $colors = Color::orderBy('name')->get();

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

        return view('staff.gestao' , compact('catalogImages', 'categories', 'colors', 'filterByCategory', 'filterBySearch'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        return view('staff.gestao_create', compact('categories'));
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
            $tshirtImage = Tshirt_Image::create([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'category_id' => $validated['category_id'],
                'customer_id' => null,
            ]);

            $extension = $request->file('image_file')->getClientOriginalExtension();
            $newFileName = 'catalogImage_' . $tshirtImage->id . '.' . $extension;
            
            $request->file('image_file')->storeAs('tshirt_images', $newFileName, 'public');

            $tshirtImage->image_url = $newFileName;
            $tshirtImage->save();
        });

        return redirect()->route('staff.gestao')->with('alert-type', 'success')->with('alert-msg', 'Nova imagem adicionada ao catálogo!');
    }

    public function edit(Tshirt_Image $tshirtImage): View
    {
        // Garante que o admin não está a tentar editar uma imagem privada de um cliente por este URL
        if ($tshirtImage->customer_id !== null) {
            abort(403, 'Não pode editar imagens privadas de clientes por aqui.');
        }

        $categories = Category::orderBy('name')->get();
        return view('staff.gestao_edit', compact('tshirtImage', 'categories'));
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

    /*
    |--------------------------------------------------------------------------
    | GESTÃO DE CATEGORIAS (Novo)
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
            'code' => 'required|string|size:6|unique:colors,code', // Código HEX sem o # (ex: FFFFFF)
            'name' => 'required|string|max:255|unique:colors,name',
        ], [
            'code.required' => 'O código hexadecimal da cor é obrigatório.',
            'code.size' => 'O código da cor deve ter exatamente 6 caracteres (ex: FF0000).',
            'code.unique' => 'Já existe uma cor com esse código.',
            'name.required' => 'O nome da cor é obrigatório.',
            'name.unique' => 'Já existe uma cor com esse nome.',
        ]);

        Color::create([
            'code' => strtoupper($validated['code']),
            'name' => $validated['name']
        ]);

        return redirect()->route('staff.gestao')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Nova cor adicionada com sucesso!');
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