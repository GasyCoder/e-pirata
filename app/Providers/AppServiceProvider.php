<?php

namespace App\Providers;

use Dedoc\Scramble\Scramble;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

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

        Scramble::configure()
        ->routes(function (Route $route) {
            return Str::startsWith($route->uri, 'api/');
        });
        
        Gate::define('viewApiDocs', function (User $user) {
            return in_array($user->email, ['admin@test.fr']);
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
