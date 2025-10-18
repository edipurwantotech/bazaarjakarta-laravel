<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layouts.admin', function ($view) {
            $menus = Menu::active()
                ->admin()
                ->parents()
                ->with(['children' => function ($query) {
                    $query->active()->admin()->ordered();
                }])
                ->ordered()
                ->get();
            
            $view->with('adminMenus', $menus);
        });
        
        // Also share with all views that extend layouts.admin
        View::composer('*', function ($view) {
            if (str_contains($view->getName(), 'admin')) {
                $menus = Menu::active()
                    ->admin()
                    ->parents()
                    ->with(['children' => function ($query) {
                        $query->active()->admin()->ordered();
                    }])
                    ->ordered()
                    ->get();
                
                $view->with('adminMenus', $menus);
            }
        });
    }
}