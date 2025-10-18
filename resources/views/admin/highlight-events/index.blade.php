@extends('layouts.admin')

@section('content')
<div class="container mx-auto relative z-10">
    <style>
        .dropdown {
            z-index: 999 !important;
        }
    </style>
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-orange-600">Highlight Events</h1>
            <p class="text-base-content/70">Manage featured event highlights</p>
        </div>
        <a href="{{ route('admin.highlight-events.create') }}" class="btn bg-orange-600 hover:bg-orange-700 text-white border-none">
            <i class="fas fa-plus mr-2"></i>
            Add New Highlight
        </a>
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

    <!-- Highlight Events Table -->
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr class="bg-base-200">
                            <th class="rounded-tl-lg">No</th>
                            <th>Name</th>
                            <th>Icon</th>
                            <th>Content</th>
                            <th>Events</th>
                            <th class="rounded-tr-lg">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($highlightEvents as $index => $highlightEvent)
                        <tr class="hover">
                            <td>{{ ($highlightEvents->currentpage() - 1) * $highlightEvents->perpage() + $index + 1 }}</td>
                            <td>
                                <div class="font-bold">{{ $highlightEvent->name }}</div>
                            </td>
                            <td>
                                @if($highlightEvent->icon)
                                <i class="{{ $highlightEvent->icon }} text-2xl text-orange-500"></i>
                                @else
                                <div class="text-sm opacity-50">No icon</div>
                                @endif
                            </td>
                            <td>
                                <div class="max-w-xs truncate">
                                    {{ $highlightEvent->content ?? 'No content' }}
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-info badge-sm">{{ $highlightEvent->events->count() }} Events</span>
                            </td>
                            <td>
                                <div class="flex gap-1">
                                    <a href="{{ route('admin.highlight-events.show', $highlightEvent) }}" 
                                       class="btn btn-sm btn-ghost btn-circle" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.highlight-events.edit', $highlightEvent) }}" 
                                       class="btn btn-sm btn-info btn-circle" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.highlight-events.destroy', $highlightEvent) }}" method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this highlight?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-error btn-circle" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-16">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <i class="fas fa-star text-6xl mb-4 opacity-50"></i>
                                    <h3 class="text-xl font-semibold mb-2">No Highlights Found</h3>
                                    <p class="text-sm mb-4">Start by creating your first event highlight</p>
                                    <a href="{{ route('admin.highlight-events.create') }}" class="btn bg-orange-600 hover:bg-orange-700 text-white border-none btn-sm">
                                        <i class="fas fa-plus mr-2"></i>
                                        Create First Highlight
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($highlightEvents->hasPages())
            <div class="flex justify-center mt-6 p-4 border-t">
                {{ $highlightEvents->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection