<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TshirtImageController extends Controller
{
    public function showImage($filename)
    {
        // 1. Define o caminho relativo (o Laravel vai meter o 'private/' sozinho)
        $path = 'tshirt_images_private/' . $filename;

        // 2. Obtém o caminho absoluto exato que viste no dd()
        $absolutePath = Storage::disk('local')->path($path);

        // 3. CORREÇÃO WINDOWS: Verifica diretamente se o ficheiro físico existe no Laragon
        if (!file_exists($absolutePath)) {
            abort(404, 'Imagem não encontrada no storage privado.');
        }

        // 4. Obtém o conteúdo do ficheiro de forma segura
        $file = file_get_contents($absolutePath);

        // 5. Lê o Mime Type real do ficheiro no Windows
        $type = mime_content_type($absolutePath) ?: 'image/png';

        // 6. Envia a imagem para o browser
        return response($file, 200)->header('Content-Type', $type);
    }
}