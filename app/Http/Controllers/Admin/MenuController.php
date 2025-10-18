<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Page;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    /**
     * Display the menu management page.
     */
    public function index()
    {
        // Get frontend menus only
        $frontendMenus = Menu::frontend()->parents()->with(['children' => function ($query) {
            $query->frontend()->ordered();
        }])->ordered()->get();
        
        // Get pages and categories for menu options
        $pages = Page::active()->get(['id', 'title', 'slug']);
        $categories = EventCategory::active()->get(['id', 'name', 'slug']);
        
        return view('admin.menus.index', compact('frontendMenus', 'pages', 'categories'));
    }

    /**
     * Store a new menu.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'target' => 'nullable|in:_self,_blank',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Get the highest order for this parent and type
        $order = Menu::where('parent_id', $request->parent_id)
            ->where('type', 'frontend')
            ->max('order') + 1;

        $menu = Menu::create([
            'title' => $request->title,
            'url' => $request->url,
            'position' => 'sidebar',
            'type' => 'frontend',
            'parent_id' => $request->parent_id,
            'order' => $order,
            'target' => $request->target ?? '_self',
            'is_active' => 1,
        ]);

        return response()->json(['success' => true, 'menu' => $menu]);
    }

    /**
     * Update a menu.
     */
    public function update(Request $request, Menu $menu)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'target' => 'nullable|in:_self,_blank',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $menu->update([
            'title' => $request->title,
            'url' => $request->url,
            'target' => $request->target ?? '_self',
        ]);

        return response()->json(['success' => true, 'menu' => $menu]);
    }

    /**
     * Get a menu for editing.
     */
    public function show(Menu $menu)
    {
        return response()->json(['menu' => $menu]);
    }

    /**
     * Toggle menu active status.
     */
    public function toggle(Menu $menu)
    {
        $menu->update(['is_active' => !$menu->is_active]);
        return response()->json(['success' => true, 'status' => $menu->is_active]);
    }

    /**
     * Delete a menu.
     */
    public function destroy(Menu $menu)
    {
        // Check if menu has children
        if ($menu->children()->count() > 0) {
            return response()->json(['error' => 'Cannot delete menu with children'], 422);
        }

        $menu->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Update menu order.
     */
    public function updateOrder(Request $request)
    {
        $menuOrder = $request->input('menuOrder');
        
        DB::beginTransaction();
        try {
            foreach ($menuOrder as $index => $menuId) {
                Menu::where('id', $menuId)->update(['order' => $index + 1]);
            }
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Failed to update menu order'], 500);
        }
    }

    /**
     * Get options for URL field based on selected option type.
     */
    public function getUrlOptions(Request $request)
    {
        $type = $request->input('type');
        $options = [];

        switch ($type) {
            case 'pages':
                $options = Page::active()->get(['id', 'title', 'slug'])->map(function ($page) {
                    return [
                        'id' => $page->id,
                        'text' => $page->title,
                        'url' => '/page/' . $page->slug
                    ];
                });
                break;
            case 'categories':
                $options = EventCategory::active()->get(['id', 'name', 'slug'])->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'text' => $category->name,
                        'url' => '/events/category/' . $category->slug
                    ];
                });
                break;
            case 'custom':
                $options = [];
                break;
        }

        return response()->json($options);
    }
}