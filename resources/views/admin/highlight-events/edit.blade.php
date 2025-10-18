@extends('layouts.admin')

@section('content')
<div class="container mx-auto max-w-2xl">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('admin.highlight-events.index') }}" class="btn btn-ghost btn-sm">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Highlights
            </a>
        </div>
        <h1 class="text-3xl font-bold text-orange-600">Edit Highlight</h1>
        <p class="text-base-content/70">Update event highlight information</p>
    </div>

    <!-- Validation Errors -->
    @if($errors->any())
    <div class="alert alert-error mb-6 shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div>
            <p class="font-bold">Please fix the following errors:</p>
            <ul class="list-disc list-inside mt-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- Highlight Preview Card -->
    <div class="card bg-gradient-to-r from-orange-50 to-yellow-50 border-l-4 border-orange-400 mb-6">
        <div class="card-body p-4">
            <div class="flex items-center gap-4">
                <div class="avatar placeholder">
                    <div class="bg-orange-100 text-orange-600 rounded-full w-16">
                        @if($highlightEvent->icon)
                        <i class="{{ $highlightEvent->icon }} text-2xl"></i>
                        @else
                        <span class="text-2xl">★</span>
                        @endif
                    </div>
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-orange-800">{{ $highlightEvent->name }}</h2>
                    <p class="text-sm text-orange-700">{{ $highlightEvent->content ?? 'No content provided' }}</p>
                    <div class="flex gap-2 mt-2">
                        <span class="badge badge-info badge-sm">{{ $highlightEvent->events->count() }} Events</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body">
            <form action="{{ route('admin.highlight-events.update', $highlightEvent) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Name Field -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold flex items-center gap-2">
                            <i class="fas fa-tag text-orange-500"></i>
                            Highlight Name
                            <span class="label-text-alt text-error">*</span>
                        </span>
                    </label>
                    <div class="relative">
                        <input type="text"
                               name="name"
                               value="{{ old('name', $highlightEvent->name) }}"
                               class="input input-bordered w-full @error('name') input-error @enderror pl-10"
                               placeholder="Enter highlight name"
                               required>
                        <i class="fas fa-tag absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    @error('name')
                    <label class="label">
                        <span class="label-text-alt text-error flex items-center gap-1">
                            <i class="fas fa-exclamation-triangle text-xs"></i>
                            {{ $message }}
                        </span>
                    </label>
                    @enderror
                </div>

                <!-- Icon Field -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold flex items-center gap-2">
                            <i class="fas fa-star text-orange-500"></i>
                            Icon Class
                        </span>
                    </label>
                    <div class="relative">
                        <input type="text"
                               name="icon"
                               value="{{ old('icon', $highlightEvent->icon) }}"
                               class="input input-bordered w-full @error('icon') input-error @enderror pl-10"
                               placeholder="e.g., fas fa-star, fas fa-heart">
                        <i class="fas fa-star absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    @error('icon')
                    <label class="label">
                        <span class="label-text-alt text-error flex items-center gap-1">
                            <i class="fas fa-exclamation-triangle text-xs"></i>
                            {{ $message }}
                        </span>
                    </label>
                    @enderror
                    <label class="label">
                        <span class="label-text-alt text-xs">Optional: Font Awesome icon class (e.g., fas fa-star)</span>
                    </label>
                </div>

                <!-- Content Field -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold flex items-center gap-2">
                            <i class="fas fa-align-left text-orange-500"></i>
                            Content
                        </span>
                    </label>
                    <div class="relative">
                        <textarea name="content"
                                  class="textarea textarea-bordered h-24 w-full @error('content') textarea-error @enderror pl-10"
                                  placeholder="Describe what makes this highlight special...">{{ old('content', $highlightEvent->content) }}</textarea>
                        <i class="fas fa-align-left absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    @error('content')
                    <label class="label">
                        <span class="label-text-alt text-error flex items-center gap-1">
                            <i class="fas fa-exclamation-triangle text-xs"></i>
                            {{ $message }}
                        </span>
                    </label>
                    @enderror
                </div>

                <!-- Highlight Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="stat bg-base-200 rounded-lg">
                        <div class="stat-figure text-primary">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="stat-title">Events</div>
                        <div class="stat-value text-lg">{{ $highlightEvent->events->count() }}</div>
                    </div>
                    
                    <div class="stat bg-base-200 rounded-lg">
                        <div class="stat-figure text-secondary">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-title">Created</div>
                        <div class="stat-value text-lg">{{ $highlightEvent->created_at->format('M d') }}</div>
                    </div>
                    
                    <div class="stat bg-base-200 rounded-lg">
                        <div class="stat-figure text-accent">
                            <i class="fas fa-sync"></i>
                        </div>
                        <div class="stat-title">Updated</div>
                        <div class="stat-value text-lg">{{ $highlightEvent->updated_at->diffForHumans() }}</div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end items-center pt-4 border-t">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.highlight-events.index') }}" class="btn btn-ghost">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </a>
                        <button type="submit" class="btn bg-orange-600 hover:bg-orange-700 text-white border-none">
                            <i class="fas fa-save mr-2"></i>
                            Update Highlight
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Delete Form - Outside the main form container -->
    <div class="card bg-base-100 shadow-lg mt-4">
        <div class="card-body p-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-red-600">Danger Zone</h3>
                    <p class="text-sm text-gray-600">Once you delete this highlight, there is no going back.</p>
                </div>
                <form action="{{ route('admin.highlight-events.destroy', $highlightEvent) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this highlight? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error">
                        <i class="fas fa-trash mr-2"></i>
                        Delete Highlight
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection