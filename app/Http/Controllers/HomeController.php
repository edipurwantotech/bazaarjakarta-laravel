<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Event;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Display the home page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get frontend menus
        $frontendMenus = Menu::frontend()
            ->parents()
            ->with(['children' => function ($query) {
                $query->frontend()->ordered();
            }])
            ->ordered()
            ->get();
        
        // Get 3 latest events ordered by start_date
        $latestEvents = Event::where('status', 'published')
            ->orderBy('start_date', 'desc')
            ->with('categories')
            ->take(3)
            ->get();
        
        // Get all partners
        $partners = Partner::active()->ordered()->get();
        
        // Get WhatsApp number from settings
        $whatsappNumber = Setting::getValue('whatsapp_number', '+628123456789');
        
        // Get social media links from settings
        $socialMedia = [
            'facebook' => Setting::getValue('facebook', '#'),
            'instagram' => Setting::getValue('instagram', '#'),
            'youtube' => Setting::getValue('youtube', '#'),
            'tiktok' => Setting::getValue('tiktok', '#'),
        ];
        
        // Get homepage statistics from settings
        $homepageStats = [
            'event_sukses' => Setting::getValue('stat_event_sukses', '200+'),
            'peserta' => Setting::getValue('stat_peserta', '50K+'),
            'partner_bisnis' => Setting::getValue('stat_partner_bisnis', '100+'),
            'penghargaan' => Setting::getValue('stat_penghargaan', '15'),
        ];
        
        // Get SEO meta data from settings
        $metaDescription = Setting::getValue('seo_description');
        $metaKeywords = Setting::getValue('seo_keywords');
        
        return view('home', compact('frontendMenus', 'latestEvents', 'partners', 'whatsappNumber', 'socialMedia', 'homepageStats', 'metaDescription', 'metaKeywords'));
    }

    /**
     * Display the event detail page.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function eventDetail($slug)
    {
        // Fetch the event data from database
        $event = Event::where('slug', $slug)
            ->with('categories')
            ->firstOrFail();
        
        // Get WhatsApp number from settings
        $whatsappNumber = Setting::getValue('whatsapp_number', '+628123456789');
        
        // Prepare meta data for event
        $title = $event->meta_title ?? $event->title;
        $metaDescription = $event->meta_description ?? Str::limit(strip_tags($event->description), 160);
        $metaKeywords = $event->meta_keywords;
        
        return view('event-detail', compact('event', 'whatsappNumber', 'title', 'metaDescription', 'metaKeywords'));
    }

    /**
     * Load more events for infinite scroll
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loadMoreEvents(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = 6;
        
        $events = Event::where('status', 'published')
            ->orderBy('start_date', 'desc')
            ->with('categories')
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();
        
        $hasMore = $events->count() === $perPage;
        
        $html = '';
        foreach ($events as $index => $event) {
            $html .= view('partials.event-card', [
                'event' => $event,
                'index' => ($page - 1) * $perPage + $index
            ])->render();
        }
        
        return response()->json([
            'html' => $html,
            'hasMore' => $hasMore
        ]);
    }

    /**
     * Search events based on query
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function searchEvents(Request $request)
    {
        $query = $request->get('q', '');
        
        // Get frontend menus
        $frontendMenus = Menu::frontend()
            ->parents()
            ->with(['children' => function ($query) {
                $query->frontend()->ordered();
            }])
            ->ordered()
            ->get();
        
        // Get WhatsApp number from settings
        $whatsappNumber = Setting::getValue('whatsapp_number', '+628123456789');
        
        // Get social media links from settings
        $socialMedia = [
            'facebook' => Setting::getValue('facebook', '#'),
            'instagram' => Setting::getValue('instagram', '#'),
            'youtube' => Setting::getValue('youtube', '#'),
            'tiktok' => Setting::getValue('tiktok', '#'),
        ];
        
        // Search events
        $events = Event::where('status', 'published')
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhere('location', 'LIKE', "%{$query}%");
            })
            ->orderBy('start_date', 'desc')
            ->with('categories')
            ->paginate(6);
        
        // Prepare meta data for search page
        $title = "Pencarian Event: {$query}";
        $metaDescription = "Temukan event yang sesuai dengan pencarian Anda: {$query}";
        $metaKeywords = "pencarian event, {$query}, bazaar jakarta";
        
        return view('events.search', compact('frontendMenus', 'events', 'query', 'whatsappNumber', 'socialMedia', 'title', 'metaDescription', 'metaKeywords'));
    }

    /**
     * Display events by category
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function eventsByCategory($slug)
    {
        // Get the category
        $category = \App\Models\EventCategory::where('slug', $slug)->firstOrFail();
        
        // Get frontend menus
        $frontendMenus = Menu::frontend()
            ->parents()
            ->with(['children' => function ($query) {
                $query->frontend()->ordered();
            }])
            ->ordered()
            ->get();
        
        // Get WhatsApp number from settings
        $whatsappNumber = Setting::getValue('whatsapp_number', '+628123456789');
        
        // Get social media links from settings
        $socialMedia = [
            'facebook' => Setting::getValue('facebook', '#'),
            'instagram' => Setting::getValue('instagram', '#'),
            'youtube' => Setting::getValue('youtube', '#'),
            'tiktok' => Setting::getValue('tiktok', '#'),
        ];
        
        // Get events by category
        $events = Event::where('status', 'published')
            ->whereHas('categories', function ($query) use ($category) {
                $query->where('event_categories.id', $category->id);
            })
            ->orderBy('start_date', 'desc')
            ->with('categories')
            ->paginate(6);
        
        // Prepare meta data for category page
        $title = "Event Kategori: {$category->name}";
        $metaDescription = "Temukan semua event dalam kategori {$category->name} di Bazaar Jakarta";
        $metaKeywords = "event {$category->name}, {$category->name}, bazaar jakarta";
        
        return view('events.category', compact('frontendMenus', 'events', 'category', 'whatsappNumber', 'socialMedia', 'title', 'metaDescription', 'metaKeywords'));
    }
}