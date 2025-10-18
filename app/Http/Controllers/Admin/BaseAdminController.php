<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;

class BaseAdminController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // Share menus with all admin views
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
    }
}