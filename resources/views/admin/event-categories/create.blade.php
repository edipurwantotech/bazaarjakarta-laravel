@extends('layouts.admin')

@section('content')
<div class="container mx-auto max-w-2xl">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('admin.event-categories.index') }}" class="btn btn-ghost btn-sm">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Categories
            </a>
        </div>
        <h1 class="text-3xl font-bold text-orange-600">Create New Category</h1>
        <p class="text-base-content/70">Add a new event category to organize your bazaar events</p>
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
            <form action="{{ route('admin.event-categories.store') }}" method="POST">
                @csrf
                
                <!-- Category Info Card -->
                <div class="bg-orange-50 border-l-4 border-orange-400 p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-orange-600 mr-3"></i>
                        <div>
                            <p class="font-semibold text-orange-800">Category Information</p>
                            <p class="text-sm text-orange-700">Categories help organize your events and make them easier for visitors to find</p>
                        </div>
                    </div>
                </div>
                
                <!-- Name Field -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold flex items-center gap-2">
                            <i class="fas fa-tag text-orange-500"></i>
                            Category Name
                            <span class="label-text-alt text-error">*</span>
                        </span>
                    </label>
                    <div class="relative">
                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               class="input input-bordered w-full @error('name') input-error @enderror pl-10"
                               placeholder="e.g., Fashion, Food, Technology"
                               required
                               id="categoryName">
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
                    <label class="label">
                        <span class="label-text-alt text-xs">This name will be displayed to visitors</span>
                    </label>
                </div>

                <!-- Slug Preview -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold flex items-center gap-2">
                            <i class="fas fa-link text-orange-500"></i>
                            URL Slug Preview
                        </span>
                    </label>
                    <div class="input input-bordered bg-base-200 flex items-center gap-2">
                        <span class="text-sm text-base-content/70">{{ url('/events/category/') }}</span>
                        <span id="slugPreview" class="font-mono text-sm">category-name</span>
                    </div>
                    <label class="label">
                        <span class="label-text-alt text-xs">Slug will be automatically generated from the category name</span>
                    </label>
                </div>

                <!-- Description Field -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold flex items-center gap-2">
                            <i class="fas fa-align-left text-orange-500"></i>
                            Description
                        </span>
                    </label>
                    <div class="relative">
                        <textarea name="description"
                                  class="textarea textarea-bordered h-24 w-full @error('description') textarea-error @enderror pl-10"
                                  placeholder="Describe what types of events belong in this category...">{{ old('description') }}</textarea>
                        <i class="fas fa-align-left absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    @error('description')
                    <label class="label">
                        <span class="label-text-alt text-error flex items-center gap-1">
                            <i class="fas fa-exclamation-triangle text-xs"></i>
                            {{ $message }}
                        </span>
                    </label>
                    @enderror
                    <label class="label">
                        <span class="label-text-alt text-xs">Optional: Help visitors understand what this category contains</span>
                    </label>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-between items-center pt-4 border-t">
                    <a href="{{ route('admin.event-categories.index') }}" class="btn btn-ghost">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn bg-orange-600 hover:bg-orange-700 text-white border-none">
                        <i class="fas fa-save mr-2"></i>
                        Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('categoryName');
    const slugPreview = document.getElementById('slugPreview');
    
    nameInput.addEventListener('input', function() {
        const name = this.value.trim();
        if (name) {
            slugPreview.textContent = name.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
        } else {
            slugPreview.textContent = 'category-name';
        }
    });
});
</script>
@endpush
@endsection