<?php

namespace App\Providers;

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
public const HOME = '/login';

    /**
     * Esto hace que después del registro, Laravel redirija al login en lugar de entrar directo al dashboard.

     */
    public function boot(): void
    {
        //
    }
}
