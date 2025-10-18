<?php

namespace App\Http\Controllers\Admin;

use App\Models\HighlightEvent;
use App\Models\Event;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HighlightEventController extends BaseAdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $highlightEvents = HighlightEvent::latest()->paginate(10);
        
        // Get admin menus
        $adminMenus = Menu::active()
            ->parents()
            ->with(['children' => function ($query) {
                $query->active()->ordered();
            }])
            ->ordered()
            ->get();
            
        return view('admin.highlight-events.index', compact('highlightEvents', 'adminMenus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = Event::all();
        
        // Get admin menus
        $adminMenus = Menu::active()
            ->parents()
            ->with(['children' => function ($query) {
                $query->active()->ordered();
            }])
            ->ordered()
            ->get();
            
        return view('admin.highlight-events.create', compact('events', 'adminMenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'events' => 'nullable|array',
            'events.*' => 'exists:events,id',
        ]);

        $highlightEvent = HighlightEvent::create($validated);

        // Attach events
        if (isset($validated['events'])) {
            $highlightEvent->events()->attach($validated['events']);
        }

        return redirect()
            ->route('admin.highlight-events.index')
            ->with('success', 'Highlight event created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HighlightEvent $highlightEvent)
    {
        $highlightEvent->load('events');
        
        // Get admin menus
        $adminMenus = Menu::active()
            ->parents()
            ->with(['children' => function ($query) {
                $query->active()->ordered();
            }])
            ->ordered()
            ->get();
            
        return view('admin.highlight-events.show', compact('highlightEvent', 'adminMenus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HighlightEvent $highlightEvent)
    {
        $events = Event::all();
        $highlightEvent->load('events');
        
        // Get admin menus
        $adminMenus = Menu::active()
            ->parents()
            ->with(['children' => function ($query) {
                $query->active()->ordered();
            }])
            ->ordered()
            ->get();
            
        return view('admin.highlight-events.edit', compact('highlightEvent', 'events', 'adminMenus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HighlightEvent $highlightEvent)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('highlight_events')->ignore($highlightEvent->id),
            ],
            'content' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'events' => 'nullable|array',
            'events.*' => 'exists:events,id',
        ]);

        $highlightEvent->update($validated);

        // Sync events
        if (isset($validated['events'])) {
            $highlightEvent->events()->sync($validated['events']);
        } else {
            $highlightEvent->events()->detach();
        }

        return redirect()
            ->route('admin.highlight-events.index')
            ->with('success', 'Highlight event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HighlightEvent $highlightEvent)
    {
        $highlightEvent->events()->detach();
        $highlightEvent->delete();

        return redirect()
            ->route('admin.highlight-events.index')
            ->with('success', 'Highlight event deleted successfully.');
    }
}