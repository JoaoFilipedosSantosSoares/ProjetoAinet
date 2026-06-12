<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Tshirt_Image;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
}