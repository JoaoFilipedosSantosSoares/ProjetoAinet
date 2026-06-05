<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CustomizationController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\OrderController;

/* ----- PUBLIC ROUTES ----- */
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/{tshirt}', [CatalogController::class, 'show'])->name('catalog.show');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/forgot-password', [AccountController::class, 'forgotPassword'])->name('password.request');
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::patch('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
Route::get('/reset-password', function () {
    return redirect()->route('login')
        ->withErrors(['email' => 'Link de redefinição inválido ou expirado.']);
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    

     /*
    |--------------------------------------------------------------------------
    | CLIENTE
    |--------------------------------------------------------------------------
    */
    Route::middleware('can:cliente')->group(function () {
        Route::get('/customization', [CustomizationController::class, 'index'])->name('customization.index');
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    });

    /*
    |--------------------------------------------------------------------------
    | FUNCIONÁRIO + ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('can:employee')->group(function () {
        // Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    Route::middleware('can:admin')->group(function () {

    });
});




