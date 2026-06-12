<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CustomizationController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TshirtImageController;

/* ----- PUBLIC ROUTES ----- */

Route::get('/', [HomeController::class, 'index'])->name('home');

// Catálogo de T-Shirts
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/{tshirt}', [CatalogController::class, 'show'])->name('catalog.show');

// Carrinho de Compras
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

/* ----- GUEST ROUTES ----- */
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AccountController::class, 'login'])->name('login');
    Route::get('/register', [AccountController::class, 'register'])->name('register');
    Route::get('/forgot-password', [AccountController::class, 'forgotPassword'])->name('password.request');

    Route::get('/reset-password', function () {
        return redirect()->route('login')
            ->withErrors(['email' => 'Link de redefinição inválido ou expirado.']);
    });
});

/* ----- AUTHENTICATED ROUTES ----- */
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/customization', [CustomizationController::class, 'index'])->name('customization.index');
    
    //vai buscar a imagem da tshirt no private
    Route::get('tshirt_images/{filename}', [TshirtImageController::class, 'showImage'])
        ->name('tshirt_images.show');
    
     /*
    |--------------------------------------------------------------------------
    | CLIENTE
    |--------------------------------------------------------------------------
    */
    Route::middleware('can:cliente')->group(function () {
        Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    });

    /*
    |--------------------------------------------------------------------------
    | FUNCIONÁRIO + ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('can:employee')->group(function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

        // Não feito
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    Route::middleware('can:admin')->group(function () {
        Route::get('/staff/index', [AccountController::class, 'adminUsers'])->name('staff.index');        
        // Route::get('/admin/users', [AccountController::class, 'adminUsers'])->name('account.adminUsers');
        Route::post('/staff/index/{user}/block', [AccountController::class, 'toggleBlock'])->name('account.block');
        Route::delete('/staff/index/{user}', [AccountController::class, 'destroy'])->name('account.destroy');
    });
});
