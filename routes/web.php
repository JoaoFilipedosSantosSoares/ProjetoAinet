<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CustomizationController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TshirtImageController;

// Controladores de autenticação e gestão
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManagementController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Acessíveis por qualquer pessoa: Visitantes e Logados)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Catálogo de T-Shirts
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/{tshirt}', [CatalogController::class, 'show'])->name('catalog.show');

// Carrinho de Compras (Todas as rotas públicas agora, incluindo o STORE)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/store', [CartController::class, 'store'])->name('cart.store'); // <-- MOVIDO PARA AQUI!
Route::post('/cart/update/{itemId}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{itemId}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');


/*
|--------------------------------------------------------------------------
| GUEST ROUTES (Apenas para quem NÃO tem sessão iniciada)
|--------------------------------------------------------------------------
*/
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate'); // <-- ADICIONADO (Submissão do Login)
    
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');

    Route::get('/reset-password', function () {
        return redirect()->route('login')
            ->withErrors(['email' => 'Link de redefinição inválido ou expirado.']);
    });
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES (Apenas para utilizadores Logados e Verificados)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Rota de Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // <-- ADICIONADO (Terminar Sessão)

    // Buscar imagens guardadas no storage privado
    Route::get('tshirt_images/{filename}', [TshirtImageController::class, 'showImage'])
        ->name('tshirt_images.show');
    
    // Perfil Comum: Qualquer user logado pode editar o seu próprio perfil
    Route::get('/profile', [AccountController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [AccountController::class, 'updateProfile'])->name('profile.update');

    Route::get('/orders/{order}/receipt', [OrderController::class, 'downloadReceipt'])->name('orders.receipt');
    /*
    |--------------------------------------------------------------------------
    | MIDDLEWARE: CLIENTE
    |--------------------------------------------------------------------------
    |*/
    Route::middleware('can:cliente')->group(function () {
        Route::get('/account', [AccountController::class, 'index'])->name('account.index');
        Route::get('/account/order/{order}', [OrderController::class, 'show'])->name('orders.show');

        // Carrinho de Compras

        // Personalização de T-Shirts
        Route::get('/customization', [CustomizationController::class, 'index'])->name('customization.index');
        Route::post('/customization/upload', [CustomizationController::class, 'upload'])->name('customization.upload');
        Route::get('/customization/{id}/edit', [CustomizationController::class, 'edit'])->name('customization.edit');
        Route::put('/customization/{id}', [CustomizationController::class, 'update'])->name('customization.update');
        Route::delete('/customization/{tshirtImage}', [CustomizationController::class, 'destroy'])->name('customization.destroy');

        // Processo de Checkout
        Route::get('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
        Route::post('/checkout', [OrderController::class, 'storeCheckout'])->name('orders.storeCheckout');
    });

    /*
    |--------------------------------------------------------------------------
    | MIDDLEWARE: FUNCIONÁRIO + ADMIN
    |--------------------------------------------------------------------------
    |*/
    Route::middleware('can:employee')->group(function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    });

    /*
    |--------------------------------------------------------------------------
    | MIDDLEWARE: ADMIN
    |--------------------------------------------------------------------------
    |*/
    Route::middleware('can:admin')->group(function () {
        // DASHBOARD
        Route::get('/staff/estatisticas', [DashboardController::class, 'index'])->name('staff.estatisticas');

        // GESTÃO GLOBAL DA LOJA (ManagementController)
        Route::get('/staff/gestao', [ManagementController::class, 'index'])->name('staff.gestao');
        Route::put('/staff/gestao/precos', [ManagementController::class, 'updatePrices'])->name('staff.gestao.updatePrices');

        // GESTÃO DE T-SHIRTS
        Route::get('/staff/gestao/create', [ManagementController::class, 'create'])->name('staff.gestao.create');
        Route::post('/staff/gestao/store', [ManagementController::class, 'store'])->name('staff.gestao.store');
        Route::get('/staff/gestao/{tshirtImage}/edit', [ManagementController::class, 'edit'])->name('staff.gestao.edit');
        Route::put('/staff/gestao/{tshirtImage}', [ManagementController::class, 'update'])->name('staff.gestao.update');
        Route::delete('/staff/gestao/{tshirtImage}', [ManagementController::class, 'destroy'])->name('staff.gestao.destroy');

        // GESTÃO DE CATEGORIAS
        Route::post('/staff/gestao/categoria', [ManagementController::class, 'storeCategory'])->name('staff.gestao.storeCategory');
        Route::delete('/staff/gestao/categoria/{category}', [ManagementController::class, 'destroyCategory'])->name('staff.gestao.destroyCategory');

        // GESTÃO DE CORES
        Route::post('/staff/gestao/cor', [ManagementController::class, 'storeColor'])->name('staff.gestao.storeColor');
        Route::put('/staff/gestao/cores/{color}', [ManagementController::class, 'updateColor'])->name('staff.gestao.updateColor');
        Route::delete('/staff/gestao/cor/{color}', [ManagementController::class, 'destroyColor'])->name('staff.gestao.destroyColor');
        
        // GESTÃO DE CATEGORIAS (UPDATE)
        Route::put('/staff/gestao/categorias/{category}', [ManagementController::class, 'updateCategory'])->name('staff.gestao.updateCategory');

        // GESTÃO DE EQUIPA (StaffController)
        Route::get('/staff/index', [StaffController::class, 'index'])->name('staff.index');
        Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.add');
        Route::post('/staff/store', [StaffController::class, 'store'])->name('staff.store');
        Route::get('/staff/{user}', [StaffController::class, 'show'])->name('staff.show');
        Route::put('/staff/{user}', [StaffController::class, 'update'])->name('staff.update');

        // GESTÃO DE CLIENTES
        Route::get('/clients/index', [ClientController::class, 'index'])->name('clients.index');
        Route::post('/clients/index/{user}/block', [AccountController::class, 'toggleBlock'])->name('clients.block');
        Route::delete('/clients/index/{user}', [ClientController::class, 'destroy'])->name('account.destroy');

        // Bloquear e Eliminar Staff
        Route::post('/staff/index/{user}/block', [AccountController::class, 'toggleBlock'])->name('account.block');
        Route::delete('/staff/index/{user}', [StaffController::class, 'destroy'])->name('account.destroy');
    });
});