<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/event/{slug}', [HomeController::class, 'eventDetail'])->name('event.detail');

Route::get('/page/{slug}', [HomeController::class, 'pageDetail'])->name('page.detail');

Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');

Route::get('/events/load-more', [HomeController::class, 'loadMoreEvents'])->name('events.load-more');
Route::get('/events/search', [HomeController::class, 'searchEvents'])->name('events.search');
Route::get('/events/category/{slug}', [HomeController::class, 'eventsByCategory'])->name('events.category');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Settings Routes
    Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('admin.settings.update');
    Route::post('/settings/general', [App\Http\Controllers\Admin\SettingsController::class, 'updateGeneral'])->name('admin.settings.update.general');
    Route::post('/settings/seo', [App\Http\Controllers\Admin\SettingsController::class, 'updateSeo'])->name('admin.settings.update.seo');
    Route::post('/settings/homepage', [App\Http\Controllers\Admin\SettingsController::class, 'updateHomepage'])->name('admin.settings.update.homepage');
    
    // Menu Management Routes
    Route::get('/menus', [App\Http\Controllers\Admin\MenuController::class, 'index'])->name('admin.menus.index');
    Route::post('/menus', [App\Http\Controllers\Admin\MenuController::class, 'store'])->name('admin.menus.store');
    Route::get('/menus/{menu}', [App\Http\Controllers\Admin\MenuController::class, 'show'])->name('admin.menus.show');
    Route::put('/menus/{menu}', [App\Http\Controllers\Admin\MenuController::class, 'update'])->name('admin.menus.update');
    Route::post('/menus/{menu}/toggle', [App\Http\Controllers\Admin\MenuController::class, 'toggle'])->name('admin.menus.toggle');
    Route::delete('/menus/{menu}', [App\Http\Controllers\Admin\MenuController::class, 'destroy'])->name('admin.menus.destroy');
    Route::post('/menus/order', [App\Http\Controllers\Admin\MenuController::class, 'updateOrder'])->name('admin.menus.updateOrder');
    Route::get('/menus/url-options', [App\Http\Controllers\Admin\MenuController::class, 'getUrlOptions'])->name('admin.menus.urlOptions');
    
    // Events Routes
    Route::resource('events', App\Http\Controllers\Admin\EventController::class)->names([
        'index' => 'admin.events.index',
        'create' => 'admin.events.create',
        'store' => 'admin.events.store',
        'show' => 'admin.events.show',
        'edit' => 'admin.events.edit',
        'update' => 'admin.events.update',
        'destroy' => 'admin.events.destroy',
    ]);
    
    // Event Categories Routes
    Route::resource('event-categories', App\Http\Controllers\Admin\EventCategoryController::class)->names([
        'index' => 'admin.event-categories.index',
        'create' => 'admin.event-categories.create',
        'store' => 'admin.event-categories.store',
        'show' => 'admin.event-categories.show',
        'edit' => 'admin.event-categories.edit',
        'update' => 'admin.event-categories.update',
        'destroy' => 'admin.event-categories.destroy',
    ]);
    
    // Pages Routes
    Route::resource('pages', App\Http\Controllers\Admin\PageController::class)->names([
        'index' => 'admin.pages.index',
        'create' => 'admin.pages.create',
        'store' => 'admin.pages.store',
        'show' => 'admin.pages.show',
        'edit' => 'admin.pages.edit',
        'update' => 'admin.pages.update',
        'destroy' => 'admin.pages.destroy',
    ]);
    
    // Partners Routes
    Route::resource('partners', App\Http\Controllers\Admin\PartnerController::class)->names([
        'index' => 'admin.partners.index',
        'create' => 'admin.partners.create',
        'store' => 'admin.partners.store',
        'show' => 'admin.partners.show',
        'edit' => 'admin.partners.edit',
        'update' => 'admin.partners.update',
        'destroy' => 'admin.partners.destroy',
    ]);
    
    // Highlight Events Routes
    Route::resource('highlight-events', App\Http\Controllers\Admin\HighlightEventController::class)->names([
        'index' => 'admin.highlight-events.index',
        'create' => 'admin.highlight-events.create',
        'store' => 'admin.highlight-events.store',
        'show' => 'admin.highlight-events.show',
        'edit' => 'admin.highlight-events.edit',
        'update' => 'admin.highlight-events.update',
        'destroy' => 'admin.highlight-events.destroy',
    ]);
});
