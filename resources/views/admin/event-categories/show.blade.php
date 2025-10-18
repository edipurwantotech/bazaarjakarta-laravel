@extends('layouts.admin')

@section('content')
<div class="container mx-auto max-w-4xl">
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">Event Category Details</h1>
                <p class="text-base-content/70">View category information</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.event-categories.edit', $eventCategory) }}" class="btn btn-info">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                <a href="{{ route('admin.event-categories.index') }}" class="btn btn-ghost">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Category Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2">
            <div class="card bg-base-100 shadow-lg">
                <div class="card-body">
                    <h2 class="card-title mb-4">
                        <i class="fas fa-folder text-orange-600"></i>
                        Category Information
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Name -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Name</span>
                            </label>
                            <div class="bg-base-200 p-3 rounded-lg">
                                {{ $eventCategory->name }}
                            </div>
                        </div>

                        <!-- Slug -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Slug</span>
                            </label>
                            <div class="bg-base-200 p-3 rounded-lg">
                                <span class="badge badge-ghost">{{ $eventCategory->slug }}</span>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="form-control md:col-span-2">
                            <label class="label">
                                <span class="label-text font-semibold">Description</span>
                            </label>
                            <div class="bg-base-200 p-3 rounded-lg min-h-[100px]">
                                {!! $eventCategory->description ?? 'No description provided' !!}
                            </div>
                        </div>

                        <!-- Created At -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Created At</span>
                            </label>
                            <div class="bg-base-200 p-3 rounded-lg">
                                {{ $eventCategory->created_at->format('d M Y H:i:s') }}
                            </div>
                        </div>

                        <!-- Updated At -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Last Updated</span>
                            </label>
                            <div class="bg-base-200 p-3 rounded-lg">
                                {{ $eventCategory->updated_at->format('d M Y H:i:s') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Information -->
        <div class="lg:col-span-1">
            <!-- Statistics -->
            <div class="card bg-base-100 shadow-lg mb-6">
                <div class="card-body">
                    <h2 class="card-title mb-4">
                        <i class="fas fa-chart-bar text-orange-600"></i>
                        Statistics
                    </h2>
                    
                    <div class="space-y-3">
                        <div class="stat">
                            <div class="stat-title">Total Events</div>
                            <div class="stat-value text-primary">{{ $eventCategory->events->count() }}</div>
                        </div>
                        
                        @if($eventCategory->events->count() > 0)
                        <div class="stat">
                            <div class="stat-title">Published Events</div>
                            <div class="stat-value text-success">
                                {{ $eventCategory->events->where('status', 'published')->count() }}
                            </div>
                        </div>
                        
                        <div class="stat">
                            <div class="stat-title">Draft Events</div>
                            <div class="stat-value text-warning">
                                {{ $eventCategory->events->where('status', 'draft')->count() }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card bg-base-100 shadow-lg">
                <div class="card-body">
                    <h2 class="card-title mb-4">
                        <i class="fas fa-cog text-orange-600"></i>
                        Actions
                    </h2>
                    
                    <div class="space-y-2">
                        <a href="{{ route('admin.event-categories.edit', $eventCategory) }}" 
                           class="btn btn-info btn-block">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Category
                        </a>
                        
                        @if($eventCategory->events->count() == 0)
                        <form action="{{ route('admin.event-categories.destroy', $eventCategory) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this category?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-error btn-block">
                                <i class="fas fa-trash mr-2"></i>
                                Delete Category
                            </button>
                        </form>
                        @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Cannot delete category with associated events</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Events in this Category -->
    @if($eventCategory->events->count() > 0)
    <div class="card bg-base-100 shadow-lg mt-6">
        <div class="card-body">
            <h2 class="card-title mb-4">
                <i class="fas fa-calendar text-orange-600"></i>
                Events in this Category ({{ $eventCategory->events->count() }})
            </h2>
            
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Start Date</th>
                            <th>Location</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($eventCategory->events as $event)
                        <tr>
                            <td>
                                <div class="font-semibold">{{ $event->title }}</div>
                            </td>
                            <td>
                                <span class="badge {{ $event->status === 'published' ? 'badge-success' : ($event->status === 'draft' ? 'badge-warning' : 'badge-error') }}">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </td>
                            <td>
                                {{ $event->start_date ? $event->start_date->format('d M Y') : '-' }}
                            </td>
                            <td>{{ $event->location ?? '-' }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-ghost" title="View Event">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection