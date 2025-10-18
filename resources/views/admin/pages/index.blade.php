@extends('layouts.admin')

@section('content')
<div class="container mx-auto">
    <!-- Page Header with Stats -->
    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-orange-600">Pages</h1>
                <p class="text-base-content/70">Manage website pages and content</p>
            </div>
            <a href="{{ route('admin.pages.create') }}" class="btn bg-orange-600 hover:bg-orange-700 text-white border-none">
                <i class="fas fa-plus mr-2"></i>
                Add New Page
            </a>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="stat bg-base-100 shadow-lg rounded-lg">
                <div class="stat-figure text-primary">
                    <i class="fas fa-file-alt text-3xl"></i>
                </div>
                <div class="stat-title">Total Pages</div>
                <div class="stat-value text-primary">{{ $pages->total() }}</div>
                <div class="stat-desc">All pages</div>
            </div>
            
            <div class="stat bg-base-100 shadow-lg rounded-lg">
                <div class="stat-figure text-success">
                    <i class="fas fa-check-circle text-3xl"></i>
                </div>
                <div class="stat-title">Published</div>
                <div class="stat-value text-success">
                    {{ App\Models\Page::published()->count() }}
                </div>
                <div class="stat-desc">Live pages</div>
            </div>
            
            <div class="stat bg-base-100 shadow-lg rounded-lg">
                <div class="stat-figure text-warning">
                    <i class="fas fa-edit text-3xl"></i>
                </div>
                <div class="stat-title">Drafts</div>
                <div class="stat-value text-warning">
                    {{ App\Models\Page::draft()->count() }}
                </div>
                <div class="stat-desc">Unpublished pages</div>
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

    <!-- Pages Table -->
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
                                    <i class="fas fa-file-alt text-sm"></i>
                                    Page Title
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
                                    <i class="fas fa-flag text-sm"></i>
                                    Status
                                </div>
                            </th>
                            <th>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-user text-sm"></i>
                                    Author
                                </div>
                            </th>
                            <th>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-clock text-sm"></i>
                                    Updated
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
                        @forelse($pages as $index => $page)
                        <tr class="hover">
                            <td>{{ ($pages->currentpage() - 1) * $pages->perpage() + $index + 1 }}</td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar placeholder">
                                        <div class="bg-orange-100 text-orange-600 rounded-full w-10">
                                            <span class="text-lg">{{ strtoupper(substr($page->title, 0, 1)) }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold">{{ $page->title }}</div>
                                        <div class="text-xs opacity-50">ID: {{ $page->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-ghost badge-sm">{{ $page->slug }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $page->status == 'published' ? 'badge-success' : 'badge-warning' }} badge-sm">
                                    {{ ucfirst($page->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="text-sm">
                                    <div>{{ $page->creator?->name ?? 'Unknown' }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm">
                                    <div>{{ $page->updated_at->format('d M Y') }}</div>
                                    <div class="text-xs opacity-50">{{ $page->updated_at->format('H:i') }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="flex gap-1">
                                    <a href="{{ route('admin.pages.show', $page) }}" 
                                       class="btn btn-sm btn-ghost btn-circle" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.pages.edit', $page) }}" 
                                       class="btn btn-sm btn-info btn-circle" title="Edit Page">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this page? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-error btn-circle" title="Delete Page">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-16">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <i class="fas fa-file-alt text-6xl mb-4 opacity-50"></i>
                                    <h3 class="text-xl font-semibold mb-2">No Pages Found</h3>
                                    <p class="text-sm mb-4">Start by creating your first page</p>
                                    <a href="{{ route('admin.pages.create') }}" class="btn bg-orange-600 hover:bg-orange-700 text-white border-none btn-sm">
                                        <i class="fas fa-plus mr-2"></i>
                                        Create First Page
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($pages->hasPages())
            <div class="flex justify-between items-center p-4 border-t">
                <div class="text-sm text-base-content/70">
                    Showing {{ ($pages->currentpage() - 1) * $pages->perpage() + 1 }} to 
                    {{ min($pages->currentpage() * $pages->perpage(), $pages->total()) }} of 
                    {{ $pages->total() }} pages
                </div>
                <div class="btn-group">
                    {{ $pages->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection