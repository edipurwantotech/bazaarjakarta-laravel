<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Menu;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends BaseAdminController
{
    public function dashboard()
    {
        // Check if user is admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Get admin menus
        $adminMenus = Menu::active()
            ->parents()
            ->with(['children' => function ($query) {
                $query->active()->ordered();
            }])
            ->ordered()
            ->get();

        // Get upcoming events (events that haven't ended yet)
        $upcomingEvents = Event::with('categories')
            ->where(function ($query) {
                $query->where('end_date', '>=', now())
                      ->orWhereNull('end_date');
            })
            ->orderBy('start_date', 'asc')
            ->limit(5)
            ->get();

        // Get statistics
        $totalEvents = Event::count();
        $activeEventsThisMonth = Event::where('status', 'published')
            ->whereMonth('start_date', now()->month)
            ->whereYear('start_date', now()->year)
            ->count();
        $totalUsers = \App\Models\User::count();
        $newUsersThisMonth = \App\Models\User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $totalCategories = \App\Models\EventCategory::count();
        $totalPartners = \App\Models\Partner::count();

        return view('admin.dashboard', compact(
            'adminMenus',
            'upcomingEvents',
            'totalEvents',
            'activeEventsThisMonth',
            'totalUsers',
            'newUsersThisMonth',
            'totalCategories',
            'totalPartners'
        ));
    }
}