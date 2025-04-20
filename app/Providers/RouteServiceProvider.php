<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Jalur default setelah login (digunakan oleh Laravel Breeze / Fortify / Jetstream)
     */
    public const HOME = '/redirect-after-login';

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
        //
        // Tidak perlu memetakan route di sini secara manual karena Laravel 11 sudah otomatis memuat:
        // - routes/web.php
        // - routes/api.php
    }
}
