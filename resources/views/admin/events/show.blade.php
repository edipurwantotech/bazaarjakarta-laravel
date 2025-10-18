@extends('layouts.admin')

@section('content')
<div class="container mx-auto max-w-4xl">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('admin.events.index') }}" class="btn btn-ghost btn-sm">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Events
            </a>
        </div>
        <h1 class="text-3xl font-bold text-orange-600">{{ $event->title }}</h1>
        <p class="text-base-content/70">Event details and information</p>
    </div>

    <!-- Event Details -->
    <div class="card bg-base-100 shadow-lg mb-6">
        <div class="card-body">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h2 class="text-xl font-bold mb-2">{{ $event->title }}</h2>
                    <div class="flex gap-2 mb-4">
                        <span class="badge {{ 
                            $event->status == 'published' ? 'badge-success' : 
                            ($event->status == 'draft' ? 'badge-warning' : 'badge-info') 
                        }} badge-sm">
                            {{ ucfirst($event->status) }}
                        </span>
                        <span class="badge badge-ghost badge-sm">{{ $event->slug }}</span>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-edit mr-2"></i>
                        Edit
                    </a>
                </div>
            </div>

            <!-- Event Image -->
            @if($event->thumbnail)
            <div class="mb-6">
                <img src="{{ asset('storage/' . $event->thumbnail) }}" alt="{{ $event->title }}" class="rounded-lg w-full max-h-96 object-cover">
            </div>
            @endif

            <!-- Event Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="flex items-center gap-2">
                    <i class="fas fa-calendar-day text-orange-500"></i>
                    <div>
                        <p class="font-semibold">Date</p>
                        <p>{{ $event->start_date->format('d M Y') }}
                            @if($event->end_date && $event->end_date->format('Y-m-d') != $event->start_date->format('Y-m-d'))
                            to {{ $event->end_date->format('d M Y') }}
                            @endif
                        </p>
                    </div>
                </div>
                
                @if($event->time)
                <div class="flex items-center gap-2">
                    <i class="fas fa-clock text-orange-500"></i>
                    <div>
                        <p class="font-semibold">Time</p>
                        <p>{{ $event->time }}</p>
                    </div>
                </div>
                @endif
                
                @if($event->location)
                <div class="flex items-center gap-2">
                    <i class="fas fa-map-marker-alt text-orange-500"></i>
                    <div>
                        <p class="font-semibold">Location</p>
                        <p>{{ $event->location }}</p>
                    </div>
                </div>
                @endif
                
                <div class="flex items-center gap-2">
                    <i class="fas fa-user text-orange-500"></i>
                    <div>
                        <p class="font-semibold">Created By</p>
                        <p>{{ $event->creator?->name ?? 'Unknown' }}</p>
                    </div>
                </div>
            </div>

            <!-- Categories -->
            @if($event->categories->count() > 0)
            <div class="mb-6">
                <h3 class="font-semibold mb-2">Categories</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($event->categories as $category)
                    <span class="badge badge-primary badge-sm">{{ $category->name }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Highlight Events -->
            @if($event->highlightEvents->count() > 0)
            <div class="mb-6">
                <h3 class="font-semibold mb-2">Highlight Events</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($event->highlightEvents as $highlightEvent)
                    <span class="badge badge-warning badge-sm flex items-center gap-1">
                        @if($highlightEvent->icon)
                        <i class="{{ $highlightEvent->icon }} text-xs"></i>
                        @endif
                        {{ $highlightEvent->name }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Description -->
            <div class="divider">Description</div>
            <div class="prose max-w-none my-4">
                @if($event->description)
                    {!! $event->description !!}
                @else
                    <p class="text-gray-500">No description provided.</p>
                @endif
            </div>

            <!-- SEO Information -->
            <div class="divider">SEO Information</div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <h3 class="font-semibold mb-2">Meta Title</h3>
                    <p class="text-sm bg-base-200 p-2 rounded">{{ $event->meta_title ?? 'Not set' }}</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Canonical URL</h3>
                    <p class="text-sm bg-base-200 p-2 rounded">{{ $event->canonical_url ?? 'Not set' }}</p>
                </div>
                <div class="md:col-span-2">
                    <h3 class="font-semibold mb-2">Meta Description</h3>
                    <p class="text-sm bg-base-200 p-2 rounded">{{ $event->meta_description ?? 'Not set' }}</p>
                </div>
                <div class="md:col-span-2">
                    <h3 class="font-semibold mb-2">Meta Keywords</h3>
                    <p class="text-sm bg-base-200 p-2 rounded">{{ $event->meta_keywords ?? 'Not set' }}</p>
                </div>
            </div>

            <!-- Event Information -->
            <div class="divider">Event Information</div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                <div>
                    <h3 class="font-semibold mb-2">Created</h3>
                    <p class="text-sm">{{ $event->created_at->format('d M Y H:i') }}</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Last Updated</h3>
                    <p class="text-sm">{{ $event->updated_at->format('d M Y H:i') }}</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Event URL</h3>
                    <a href="{{ url('/events/' . $event->slug) }}" target="_blank" class="text-sm text-blue-500 hover:underline">
                        {{ url('/events/' . $event->slug) }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection