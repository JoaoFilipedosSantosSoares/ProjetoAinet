<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CustomizationController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AccountController;

/* ----- PUBLIC ROUTES ----- */
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');


Route::middleware(['auth', 'verified'])->group(function () {

     /*
    |--------------------------------------------------------------------------
    | CLIENTE
    |--------------------------------------------------------------------------
    */
    Route::middleware('type:C')->group(function () {

    });

    /*
    |--------------------------------------------------------------------------
    | FUNCIONÁRIO + ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('type:F,A')->group(function () {

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
Route::get('/login', [AccountController::class, 'login'])->name('account.login');
Route::get('/register', [AccountController::class, 'register'])->name('account.register');
