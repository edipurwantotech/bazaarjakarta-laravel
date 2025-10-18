<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Page;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    /**
     * Generate sitemap XML
     */
    public function index()
    {
        $events = Event::where('status', 'published')->orderBy('updated_at', 'desc')->get();
        $categories = EventCategory::orderBy('updated_at', 'desc')->get();
        $pages = Page::where('status', 'published')->orderBy('updated_at', 'desc')->get();
        
        return response()->view('sitemap', compact('events', 'categories', 'pages'))
            ->header('Content-Type', 'text/xml');
    }
}
