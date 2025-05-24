<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\CartDetail;

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
        View::composer('partials.header', function ($view) {
            $count = auth()->check()
                ? \App\Models\CartDetail::whereHas('cart', function ($query) {
                    $query->where('user_id', auth()->id());
                })->whereHas('product')->count()
                : 0;
        
            $view->with('cartCount', $count);
        });
    }
}
