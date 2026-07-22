<?php

namespace App\Providers;

use App\Models\NavigationItem;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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
        View::composer('partials.public-navigation', function ($view): void {
            $items = Schema::hasTable('navigation_items')
                ? NavigationItem::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get()
                : collect();

            $view->with('navigationItems', $items);
        });
    }
}
