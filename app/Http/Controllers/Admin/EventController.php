<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\HighlightEvent;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EventController extends BaseAdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with('categories')->latest()->paginate(10);
        
        // Get admin menus
        $adminMenus = Menu::active()
            ->parents()
            ->with(['children' => function ($query) {
                $query->active()->ordered();
            }])
            ->ordered()
            ->get();
            
        return view('admin.events.index', compact('events', 'adminMenus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = EventCategory::all();
        $highlightEvents = HighlightEvent::all();
        
        // Get admin menus
        $adminMenus = Menu::active()
            ->parents()
            ->with(['children' => function ($query) {
                $query->active()->ordered();
            }])
            ->ordered()
            ->get();
            
        return view('admin.events.create', compact('categories', 'highlightEvents', 'adminMenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:events',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'time' => 'nullable|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published,archived',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|url|max:255',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:event_categories,id',
            'highlight_events' => 'nullable|array',
            'highlight_events.*' => 'exists:highlight_events,id',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('events', 'public');
            $validated['thumbnail'] = $thumbnailPath;
        }

        // Set creator
        $validated['created_by'] = Auth::id();

        $event = Event::create($validated);

        // Attach categories
        if (isset($validated['categories'])) {
            $event->categories()->attach($validated['categories']);
        }

        // Attach highlight events
        if (isset($validated['highlight_events'])) {
            $event->highlightEvents()->attach($validated['highlight_events']);
        }

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load('categories', 'creator');
        
        // Get admin menus
        $adminMenus = Menu::active()
            ->parents()
            ->with(['children' => function ($query) {
                $query->active()->ordered();
            }])
            ->ordered()
            ->get();
            
        return view('admin.events.show', compact('event', 'adminMenus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $categories = EventCategory::all();
        $highlightEvents = HighlightEvent::all();
        $event->load(['categories', 'highlightEvents']);
        
        // Get admin menus
        $adminMenus = Menu::active()
            ->parents()
            ->with(['children' => function ($query) {
                $query->active()->ordered();
            }])
            ->ordered()
            ->get();
            
        return view('admin.events.edit', compact('event', 'categories', 'highlightEvents', 'adminMenus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('events')->ignore($event->id),
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('events')->ignore($event->id),
            ],
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'time' => 'nullable|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published,archived',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|url|max:255',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:event_categories,id',
            'highlight_events' => 'nullable|array',
            'highlight_events.*' => 'exists:highlight_events,id',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($event->thumbnail) {
                $oldThumbnailPath = public_path('storage/' . $event->thumbnail);
                if (file_exists($oldThumbnailPath)) {
                    unlink($oldThumbnailPath);
                }
            }
            
            $thumbnailPath = $request->file('thumbnail')->store('events', 'public');
            $validated['thumbnail'] = $thumbnailPath;
        }

        $event->update($validated);

        // Sync categories
        if (isset($validated['categories'])) {
            $event->categories()->sync($validated['categories']);
        } else {
            $event->categories()->detach();
        }

        // Sync highlight events
        if (isset($validated['highlight_events'])) {
            $event->highlightEvents()->sync($validated['highlight_events']);
        } else {
            $event->highlightEvents()->detach();
        }

        // Clear the cache for this event
        cache()->forget("event_detail_{$event->slug}");
        
        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        // Delete thumbnail if exists
        if ($event->thumbnail) {
            $thumbnailPath = public_path('storage/' . $event->thumbnail);
            if (file_exists($thumbnailPath)) {
                unlink($thumbnailPath);
            }
        }
        
        // Detach categories
        $event->categories()->detach();
        
        // Detach highlight events
        $event->highlightEvents()->detach();
        
        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }
}