@extends('layouts.admin')

@section('content')
<div class="container mx-auto max-w-2xl">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('admin.highlight-events.index') }}" class="btn btn-ghost btn-sm">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Highlight Events
            </a>
        </div>
        <h1 class="text-3xl font-bold text-orange-600">Create New Highlight Event</h1>
        <p class="text-base-content/70">Add a new event highlight to feature on the website</p>
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

    <!-- Create Form -->
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body">
            <form action="{{ route('admin.highlight-events.store') }}" method="POST">
                @csrf
                
                <!-- Highlight Info Card -->
                <div class="bg-orange-50 border-l-4 border-orange-400 p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-orange-600 mr-3"></i>
                        <div>
                            <p class="font-semibold text-orange-800">Highlight Event Information</p>
                            <p class="text-sm text-orange-700">Create highlights to feature special events on the website</p>
                        </div>
                    </div>
                </div>
                
                <!-- Name Field -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold flex items-center gap-2">
                            <i class="fas fa-star text-orange-500"></i>
                            Highlight Name
                            <span class="label-text-alt text-error">*</span>
                        </span>
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="name" 
                               value="{{ old('name') }}" 
                               class="input input-bordered w-full @error('name') input-error @enderror pl-10" 
                               placeholder="e.g., Featured Events, This Week's Highlights"
                               required>
                        <i class="fas fa-star absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
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
                            <i class="fas fa-icons text-orange-500"></i>
                            Icon
                        </span>
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="icon" 
                               value="{{ old('icon') }}" 
                               class="input input-bordered w-full @error('icon') input-error @enderror pl-10" 
                               placeholder="e.g., fas fa-calendar-star">
                        <i class="fas fa-icons absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
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
                                  placeholder="Brief description about this highlight">{{ old('content') }}</textarea>
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
                    <label class="label">
                        <span class="label-text-alt text-xs">Optional: Brief description about this highlight</span>
                    </label>
                </div>

                <!-- Events Field -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold flex items-center gap-2">
                            <i class="fas fa-calendar text-orange-500"></i>
                            Associated Events
                        </span>
                    </label>
                    <div class="border border-base-300 rounded-lg p-4 bg-base-100">
                        @if($events->count() > 0)
                            <div class="grid grid-cols-1 gap-2 max-h-48 overflow-y-auto">
                                @foreach($events as $event)
                                <label class="cursor-pointer flex items-center gap-2">
                                    <input type="checkbox" name="events[]" value="{{ $event->id }}" 
                                           class="checkbox checkbox-sm checkbox-primary"
                                           {{ old('events') && in_array($event->id, old('events')) ? 'checked' : '' }}>
                                    <span class="text-sm">{{ $event->title }}</span>
                                    <span class="text-xs opacity-50">({{ $event->start_date }})</span>
                                </label>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm opacity-70">No events available. Please create events first.</p>
                        @endif
                    </div>
                    @error('events')
                    <label class="label">
                        <span class="label-text-alt text-error flex items-center gap-1">
                            <i class="fas fa-exclamation-triangle text-xs"></i>
                            {{ $message }}
                        </span>
                    </label>
                    @enderror
                    <label class="label">
                        <span class="label-text-alt text-xs">Optional: Select events to include in this highlight</span>
                    </label>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-between items-center pt-4 border-t">
                    <a href="{{ route('admin.highlight-events.index') }}" class="btn btn-ghost">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn bg-orange-600 hover:bg-orange-700 text-white border-none">
                        <i class="fas fa-save mr-2"></i>
                        Create Highlight
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection