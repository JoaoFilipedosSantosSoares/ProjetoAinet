<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TshirtImageController extends Controller
{
    public function showImage($filename)
    {
        $path = 'tshirt_images_private/' . $filename;

        $absolutePath = Storage::disk('local')->path($path);

        if (!file_exists($absolutePath)) {
            abort(404, 'Imagem não encontrada no storage privado.');
        }

        $file = file_get_contents($absolutePath);

        $type = mime_content_type($absolutePath) ?: 'image/png';

        return response($file, 200)->header('Content-Type', $type);
    }
}