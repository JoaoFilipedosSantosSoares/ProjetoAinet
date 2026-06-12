<?php

namespace App\Http\Controllers;

use App\Models\Tshirt_image;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Vai buscar 4 imagens aleatórias do catálogo (onde não pertencem a nenhum cliente)
        $featuredImages = Tshirt_image::whereNull('customer_id')
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('home', compact('featuredImages'));
    }
}