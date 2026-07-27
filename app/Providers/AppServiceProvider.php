<?php

namespace App\Providers;

use App\Models\NavigationItem;
use App\Models\SiteSection;
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

            if (Schema::hasTable('site_sections')) {
                $active = SiteSection::where('is_active', true)->pluck('key')->all();
                $items = $items->filter(function (NavigationItem $item) use ($active): bool {
                    $key = SiteSection::keyForRoute($item->route_name);

                    return $key === null || in_array($key, $active, true);
                });
            }

            $view->with('navigationItems', $items);
        });

        View::composer(['public.*', 'partials.public-footer', 'board.*', 'services.*', 'specialties.*', 'workshops.*', 'calendar.*', 'directory.*', 'documents.*', 'experiences.*'], function ($view): void {
            $sections = Schema::hasTable('site_sections')
                ? SiteSection::pluck('is_active', 'key')->map(fn ($active) => (bool) $active)
                : collect();
            $view->with('siteSections', $sections);
        });
    }
}
