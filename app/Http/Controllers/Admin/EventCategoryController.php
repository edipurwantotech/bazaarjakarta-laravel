<?php

namespace App\Http\Controllers\Admin;

use App\Models\EventCategory;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EventCategoryController extends BaseAdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = EventCategory::latest()->paginate(10);
        
        // Get admin menus
        $adminMenus = Menu::active()
            ->parents()
            ->with(['children' => function ($query) {
                $query->active()->ordered();
            }])
            ->ordered()
            ->get();
            
        return view('admin.event-categories.index', compact('categories', 'adminMenus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get admin menus
        $adminMenus = Menu::active()
            ->parents()
            ->with(['children' => function ($query) {
                $query->active()->ordered();
            }])
            ->ordered()
            ->get();
            
        return view('admin.event-categories.create', compact('adminMenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:event_categories',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        EventCategory::create($validated);

        return redirect()
            ->route('admin.event-categories.index')
            ->with('success', 'Event category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EventCategory $eventCategory)
    {
        // Get admin menus
        $adminMenus = Menu::active()
            ->parents()
            ->with(['children' => function ($query) {
                $query->active()->ordered();
            }])
            ->ordered()
            ->get();
            
        return view('admin.event-categories.show', compact('eventCategory', 'adminMenus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventCategory $eventCategory)
    {
        // Get admin menus
        $adminMenus = Menu::active()
            ->parents()
            ->with(['children' => function ($query) {
                $query->active()->ordered();
            }])
            ->ordered()
            ->get();
            
        return view('admin.event-categories.edit', compact('eventCategory', 'adminMenus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventCategory $eventCategory)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('event_categories')->ignore($eventCategory->id),
            ],
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $eventCategory->update($validated);

        return redirect()
            ->route('admin.event-categories.index')
            ->with('success', 'Event category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventCategory $eventCategory)
    {
        // Check if category has events
        if ($eventCategory->events()->count() > 0) {
            return redirect()
                ->route('admin.event-categories.index')
                ->with('error', 'Cannot delete category with associated events.');
        }

        $eventCategory->delete();

        return redirect()
            ->route('admin.event-categories.index')
            ->with('success', 'Event category deleted successfully.');
    }
}