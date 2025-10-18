@extends('layouts.admin')

@section('content')
<div class="container mx-auto">
    <!-- Page Header with Stats -->
    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-orange-600">Event Categories</h1>
                <p class="text-base-content/70">Manage event categories for your bazaar events</p>
            </div>
            <a href="{{ route('admin.event-categories.create') }}" class="btn bg-orange-600 hover:bg-orange-700 text-white border-none">
                <i class="fas fa-plus mr-2"></i>
                Add New Category
            </a>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="stat bg-base-100 shadow-lg rounded-lg">
                <div class="stat-figure text-primary">
                    <i class="fas fa-tags text-3xl"></i>
                </div>
                <div class="stat-title">Total Categories</div>
                <div class="stat-value text-primary">{{ $categories->total() }}</div>
                <div class="stat-desc">Active categories</div>
            </div>
            
            <div class="stat bg-base-100 shadow-lg rounded-lg">
                <div class="stat-figure text-secondary">
                    <i class="fas fa-calendar text-3xl"></i>
                </div>
                <div class="stat-title">Total Events</div>
                <div class="stat-value text-secondary">
                    {{ \App\Models\Event::count() }}
                </div>
                <div class="stat-desc">Across all categories</div>
            </div>
            
            <div class="stat bg-base-100 shadow-lg rounded-lg">
                <div class="stat-figure text-accent">
                    <i class="fas fa-chart-line text-3xl"></i>
                </div>
                <div class="stat-title">Avg Events/Category</div>
                <div class="stat-value text-accent">
                    {{ $categories->total() > 0 ? round(\App\Models\Event::count() / $categories->total(), 1) : 0 }}
                </div>
                <div class="stat-desc">Events per category</div>
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

    <!-- Error Message -->
    @if(session('error'))
    <div class="alert alert-error mb-6 shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Categories Table -->
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
                                    <i class="fas fa-tag text-sm"></i>
                                    Category Name
                                </div>
                            </th>
                            <th>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-link text-sm"></i>
                                    Slug
                                </div>
                            </th>
                            <th>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-align-left text-sm"></i>
                                    Description
                                </div>
                            </th>
                            <th>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-calendar-check text-sm"></i>
                                    Events
                                </div>
                            </th>
                            <th>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-clock text-sm"></i>
                                    Created
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
                        @forelse($categories as $index => $category)
                        <tr class="hover">
                            <td>{{ ($categories->currentpage() - 1) * $categories->perpage() + $index + 1 }}</td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar placeholder">
                                        <div class="bg-orange-100 text-orange-600 rounded-full w-10">
                                            <span class="text-lg">{{ strtoupper(substr($category->name, 0, 1)) }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold">{{ $category->name }}</div>
                                        <div class="text-xs opacity-50">ID: {{ $category->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-ghost badge-sm">{{ $category->slug }}</span>
                            </td>
                            <td>
                                <div class="max-w-xs">
                                    <p class="text-sm truncate" title="{{ $category->description ?? 'No description' }}">
                                        {{ $category->description ?? 'No description' }}
                                    </p>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <span class="badge {{ $category->events->count() > 0 ? 'badge-info' : 'badge-ghost' }} badge-sm">
                                        {{ $category->events->count() }}
                                    </span>
                                    @if($category->events->count() > 0)
                                    <i class="fas fa-check-circle text-success text-xs"></i>
                                    @else
                                    <i class="fas fa-times-circle text-gray-400 text-xs"></i>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="text-sm">
                                    <div>{{ $category->created_at->format('d M Y') }}</div>
                                    <div class="text-xs opacity-50">{{ $category->created_at->format('H:i') }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="flex gap-1">
                                    <a href="{{ route('admin.event-categories.show', $category) }}"
                                       class="btn btn-sm btn-ghost btn-circle" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.event-categories.edit', $category) }}"
                                       class="btn btn-sm btn-info btn-circle" title="Edit Category">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($category->events->count() == 0)
                                    <form action="{{ route('admin.event-categories.destroy', $category) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-error btn-circle" title="Delete Category">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @else
                                    <button class="btn btn-sm btn-ghost btn-circle"
                                            title="Cannot delete - category has events" disabled>
                                        <i class="fas fa-trash text-gray-400"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-16">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <i class="fas fa-folder-open text-6xl mb-4 opacity-50"></i>
                                    <h3 class="text-xl font-semibold mb-2">No Categories Found</h3>
                                    <p class="text-sm mb-4">Start by creating your first event category</p>
                                    <a href="{{ route('admin.event-categories.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus mr-2"></i>
                                        Create First Category
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($categories->hasPages())
            <div class="flex justify-between items-center p-4 border-t">
                <div class="text-sm text-base-content/70">
                    Showing {{ ($categories->currentpage() - 1) * $categories->perpage() + 1 }} to
                    {{ min($categories->currentpage() * $categories->perpage(), $categories->total()) }} of
                    {{ $categories->total() }} categories
                </div>
                <div class="btn-group">
                    {{ $categories->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection