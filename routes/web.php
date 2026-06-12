<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CustomizationController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TshirtImageController;

// Todos os teus controladores bem divididos
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ManagementController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

// Catálogo de T-Shirts
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/{tshirt}', [CatalogController::class, 'show'])->name('catalog.show');


/*
|--------------------------------------------------------------------------
| GUEST ROUTES 
|--------------------------------------------------------------------------
*/
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');

    Route::get('/reset-password', function () {
        return redirect()->route('login')
            ->withErrors(['email' => 'Link de redefinição inválido ou expirado.']);
    });
});


/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Vai buscar a imagem da tshirt no private
    Route::get('tshirt_images/{filename}', [TshirtImageController::class, 'showImage'])
        ->name('tshirt_images.show');

    // Perfil Comum: Qualquer user logado pode editar o seu próprio perfil
    Route::get('/profile', [AccountController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [AccountController::class, 'updateProfile'])->name('profile.update');

    /*
    |--------------------------------------------------------------------------
    | CLIENTE
    |--------------------------------------------------------------------------
    */
    Route::middleware('can:cliente')->group(function () {
        Route::get('/account', [AccountController::class, 'index'])->name('account.index');

        // Carrinho de Compras
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/store', [CartController::class, 'store'])->name('cart.store');
        Route::post('/cart/update/{itemId}', [CartController::class, 'update'])->name('cart.update');
        Route::post('/cart/remove/{itemId}', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

        // Personalização de T-Shirts
        Route::get('/customization', [CustomizationController::class, 'index'])->name('customization.index');
        Route::post('/customization/upload', [CustomizationController::class, 'upload'])->name('customization.upload');

        // Encomendas
        Route::post('/encomendas/checkout', [OrderController::class, 'storeCheckout'])
        ->name('orders.storeCheckout');
    });

    /*
    |--------------------------------------------------------------------------
    | FUNCIONÁRIO + ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('can:employee')->group(function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('can:admin')->group(function () {
        
        // --- GESTÃO GLOBAL DA LOJA (ManagementController) ---
        Route::get('/staff/gestao', [ManagementController::class, 'index'])->name('staff.gestao');

        Route::get('/staff/gestao/create', [ManagementController::class, 'create'])->name('staff.gestao.create');
        Route::post('/staff/gestao/store', [ManagementController::class, 'store'])->name('staff.gestao.store');
        Route::get('/staff/gestao/{tshirtImage}/edit', [ManagementController::class, 'edit'])->name('staff.gestao.edit');
        Route::put('/staff/gestao/{tshirtImage}', [ManagementController::class, 'update'])->name('staff.gestao.update');
        Route::delete('/staff/gestao/{tshirtImage}', [ManagementController::class, 'destroy'])->name('staff.gestao.destroy');

        Route::post('/staff/gestao/categoria', [ManagementController::class, 'storeCategory'])->name('staff.gestao.storeCategory');
        Route::delete('/staff/gestao/categoria/{category}', [ManagementController::class, 'destroyCategory'])->name('staff.gestao.destroyCategory');

        Route::post('/staff/gestao/cor', [ManagementController::class, 'storeColor'])->name('staff.gestao.storeColor');
        Route::delete('/staff/gestao/cor/{color}', [ManagementController::class, 'destroyColor'])->name('staff.gestao.destroyColor');

        // --- GESTÃO DE EQUIPA (StaffController) ---
        Route::get('/staff/index', [StaffController::class, 'index'])->name('staff.index');
        Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.add');
        Route::post('/staff/store', [StaffController::class, 'store'])->name('staff.store');
        Route::get('/staff/{user}', [StaffController::class, 'show'])->name('staff.show');
        Route::put('/staff/{user}', [StaffController::class, 'update'])->name('staff.update');

        // Bloquear e Eliminar Staff
        Route::post('/staff/index/{user}/block', [StaffController::class, 'toggleBlock'])->name('account.block');
        Route::delete('/staff/index/{user}', [StaffController::class, 'destroy'])->name('account.destroy');
    });
    
});