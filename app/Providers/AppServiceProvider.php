<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Vite;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configuration de Vite
        Vite::useBuildDirectory('/build'); // Recherche dans public_html/build

        // Configuration de la pagination
        Paginator::defaultView('vendor.pagination.tailwind');
        Paginator::defaultSimpleView('vendor.pagination.simple-tailwind');
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
