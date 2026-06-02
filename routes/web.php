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
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/login', [AccountController::class, 'login'])->name('account.login');
Route::get('/register', [AccountController::class, 'register'])->name('account.register');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    

     /*
    |--------------------------------------------------------------------------
    | CLIENTE
    |--------------------------------------------------------------------------
    */
    Route::middleware('type:C')->group(function () {
        Route::get('/customization', [CustomizationController::class, 'index'])->name('customization.index');
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index'); // Só as suas encomendas
    });

    /*
    |--------------------------------------------------------------------------
    | FUNCIONÁRIO + ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('type:F')->group(function () {
        // Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    Route::middleware('type:A')->group(function () {

    });
});

Route::get('/customization', [CustomizationController::class, 'index'])->name('customization.index');
Route::get('/account', [AccountController::class, 'index'])->name('account.index');
/* Route::get('/login', [AccountController::class, 'login'])->name('account.login');
Route::get('/register', [AccountController::class, 'register'])->name('account.register'); */
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

