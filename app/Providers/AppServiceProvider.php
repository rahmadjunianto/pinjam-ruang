<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use App\Auth\NipUserProvider;

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
        Paginator::defaultView('vendor.pagination.adminlte');
        Paginator::defaultSimpleView('vendor.pagination.simple-adminlte');

        // Register custom NIP user provider
        Auth::provider('nip', function ($app, array $config) {
            return new NipUserProvider($app['hash'], $config['model']);
        });
    }
}
