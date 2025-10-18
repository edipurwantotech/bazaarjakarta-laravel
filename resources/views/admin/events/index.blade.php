@extends('layouts.admin')

@section('content')
<div class="container mx-auto">
    <!-- Page Header with Stats -->
    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-orange-600">Events</h1>
                <p class="text-base-content/70">Manage bazaar events and activities</p>
            </div>
            <a href="{{ route('admin.events.create') }}" class="btn bg-orange-600 hover:bg-orange-700 text-white border-none">
                <i class="fas fa-plus mr-2"></i>
                Add New Event
            </a>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="stat bg-base-100 shadow-lg rounded-lg">
                <div class="stat-figure text-primary">
                    <i class="fas fa-calendar text-3xl"></i>
                </div>
                <div class="stat-title">Total Events</div>
                <div class="stat-value text-primary">{{ $events->total() }}</div>
                <div class="stat-desc">All events</div>
            </div>
            
            <div class="stat bg-base-100 shadow-lg rounded-lg">
                <div class="stat-figure text-success">
                    <i class="fas fa-check-circle text-3xl"></i>
                </div>
                <div class="stat-title">Published</div>
                <div class="stat-value text-success">
                    {{ App\Models\Event::where('status', 'published')->count() }}
                </div>
                <div class="stat-desc">Live events</div>
            </div>
            
            <div class="stat bg-base-100 shadow-lg rounded-lg">
                <div class="stat-figure text-warning">
                    <i class="fas fa-edit text-3xl"></i>
                </div>
                <div class="stat-title">Drafts</div>
                <div class="stat-value text-warning">
                    {{ App\Models\Event::where('status', 'draft')->count() }}
                </div>
                <div class="stat-desc">Unpublished events</div>
            </div>
            
            <div class="stat bg-base-100 shadow-lg rounded-lg">
                <div class="stat-figure text-info">
                    <i class="fas fa-archive text-3xl"></i>
                </div>
                <div class="stat-title">Archived</div>
                <div class="stat-value text-info">
                    {{ App\Models\Event::where('status', 'archived')->count() }}
                </div>
                <div class="stat-desc">Archived events</div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success mb-6 shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Events Table -->
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr class="bg-base-200">
                            <th class="rounded-tl-lg">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-hashtag text-sm"></i>
                                    No
                                </div>
                            </th>
                            <th>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-calendar text-sm"></i>
                                    Event
                                </div>
                            </th>
                            <th>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-calendar-day text-sm"></i>
                                    Date
                                </div>
                            </th>
                            <th>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-sm"></i>
                                    Location
                                </div>
                            </th>
                            <th>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-tags text-sm"></i>
                                    Categories
                                </div>
                            </th>
                            <th>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-flag text-sm"></i>
                                    Status
                                </div>
                            </th>
                            <th class="rounded-tr-lg">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-cogs text-sm"></i>
                                    Actions
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $index => $event)
                        <tr class="hover">
                            <td>{{ ($events->currentpage() - 1) * $events->perpage() + $index + 1 }}</td>
                            <td>
                                <div class="flex items-center gap-3">
                                    @if($event->thumbnail)
                                    <div class="avatar">
                                        <div class="w-12 rounded">
                                            <img src="{{ asset('storage/' . $event->thumbnail) }}" alt="{{ $event->title }}" />
                                        </div>
                                    </div>
                                    @else
                                    <div class="avatar placeholder">
                                        <div class="bg-orange-100 text-orange-600 rounded-full w-12">
                                            <span class="text-lg">{{ strtoupper(substr($event->title, 0, 1)) }}</span>
                                        </div>
                                    </div>
                                    @endif
                                    <div>
                                        <div class="font-bold">{{ $event->title }}</div>
                                        <div class="text-xs opacity-50">{{ $event->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm">
                                    <div>{{ $event->start_date->format('d M Y') }}</div>
                                    @if($event->end_date && $event->end_date->format('Y-m-d') != $event->start_date->format('Y-m-d'))
                                    <div class="text-xs opacity-70">to {{ $event->end_date->format('d M Y') }}</div>
                                    @endif
                                    @if($event->time)
                                    <div class="text-xs opacity-70">{{ $event->time }}</div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="text-sm truncate max-w-xs">
                                    {{ $event->location ?? 'No location' }}
                                </div>
                            </td>
                            <td>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($event->categories->take(2) as $category)
                                    <span class="badge badge-ghost badge-xs">{{ $category->name }}</span>
                                    @endforeach
                                    @if($event->categories->count() > 2)
                                    <span class="badge badge-ghost badge-xs">+{{ $event->categories->count() - 2 }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="badge {{ 
                                    $event->status == 'published' ? 'badge-success' : 
                                    ($event->status == 'draft' ? 'badge-warning' : 'badge-info') 
                                }} badge-sm">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="flex gap-1">
                                    <a href="{{ route('admin.events.show', $event) }}" 
                                       class="btn btn-sm btn-ghost btn-circle" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.events.edit', $event) }}" 
                                       class="btn btn-sm btn-info btn-circle" title="Edit Event">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this event? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-error btn-circle" title="Delete Event">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-16">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <i class="fas fa-calendar-times text-6xl mb-4 opacity-50"></i>
                                    <h3 class="text-xl font-semibold mb-2">No Events Found</h3>
                                    <p class="text-sm mb-4">Start by creating your first event</p>
                                    <a href="{{ route('admin.events.create') }}" class="btn bg-orange-600 hover:bg-orange-700 text-white border-none btn-sm">
                                        <i class="fas fa-plus mr-2"></i>
                                        Create First Event
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($events->hasPages())
            <div class="flex justify-between items-center p-4 border-t">
                <div class="text-sm text-base-content/70">
                    Showing {{ ($events->currentpage() - 1) * $events->perpage() + 1 }} to 
                    {{ min($events->currentpage() * $events->perpage(), $events->total()) }} of 
                    {{ $events->total() }} events
                </div>
                <div class="btn-group">
                    {{ $events->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection