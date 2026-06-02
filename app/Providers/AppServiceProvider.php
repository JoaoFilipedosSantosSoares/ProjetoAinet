<?php

namespace App\Providers;

use App\Models\User;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | CLIENTE
        |--------------------------------------------------------------------------
        */
        Gate::define("cliente", function (User $user) { 
            return $user->user_type === 'C';
        });

        /*
        |--------------------------------------------------------------------------
        | FUNCIONÁRIO
        |--------------------------------------------------------------------------
        */
        Gate::define('employee', function (User $user) {

            return in_array($user->user_type, ['F', 'A']);
        });

        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */
        Gate::define('admin', function (User $user) {

            return $user->user_type === 'A';
        });

        
    }
}
