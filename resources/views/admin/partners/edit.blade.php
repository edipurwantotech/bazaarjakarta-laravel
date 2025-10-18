@extends('layouts.admin')

@section('content')
<div class="container mx-auto max-w-4xl">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('admin.partners.index') }}" class="btn btn-ghost btn-sm">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Partners
            </a>
        </div>
        <h1 class="text-3xl font-bold text-orange-600">Edit Partner</h1>
        <p class="text-base-content/70">Update partner information</p>
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

    <!-- Edit Form -->
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body">
            <form action="{{ route('admin.partners.update', $partner) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Name Field -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold flex items-center gap-2">
                            <i class="fas fa-building text-orange-500"></i>
                            Partner Name
                            <span class="label-text-alt text-error">*</span>
                        </span>
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="name" 
                               value="{{ old('name', $partner->name) }}" 
                               class="input input-bordered w-full @error('name') input-error @enderror pl-10" 
                               placeholder="Enter partner name"
                               required>
                        <i class="fas fa-building absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
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

                <!-- Logo Field -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold flex items-center gap-2">
                            <i class="fas fa-image text-orange-500"></i>
                            Partner Logo
                        </span>
                    </label>
                    @if($partner->logo)
                    <div class="mb-2">
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="w-24 h-24 object-cover rounded">
                            <div>
                                <p class="text-sm">Current logo</p>
                                <p class="text-xs opacity-70">Upload a new image to replace</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    <input type="file" 
                           name="logo" 
                           class="file-input file-input-bordered w-full @error('logo') file-input-error @enderror" 
                           accept="image/*">
                    @error('logo')
                    <label class="label">
                        <span class="label-text-alt text-error flex items-center gap-1">
                            <i class="fas fa-exclamation-triangle text-xs"></i>
                            {{ $message }}
                        </span>
                    </label>
                    @enderror
                    <label class="label">
                        <span class="label-text-alt text-xs">Optional: Upload partner logo (JPEG, PNG, JPG, GIF - Max 2MB)</span>
                    </label>
                </div>

                <!-- Website Field -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold flex items-center gap-2">
                            <i class="fas fa-globe text-orange-500"></i>
                            Website
                        </span>
                    </label>
                    <div class="relative">
                        <input type="url" 
                               name="website" 
                               value="{{ old('website', $partner->website) }}" 
                               class="input input-bordered w-full @error('website') input-error @enderror pl-10" 
                               placeholder="https://example.com">
                        <i class="fas fa-globe absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    @error('website')
                    <label class="label">
                        <span class="label-text-alt text-error flex items-center gap-1">
                            <i class="fas fa-exclamation-triangle text-xs"></i>
                            {{ $message }}
                        </span>
                    </label>
                    @enderror
                </div>

                <!-- Description Field -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold flex items-center gap-2">
                            <i class="fas fa-align-left text-orange-500"></i>
                            Description
                        </span>
                    </label>
                    <textarea name="description"
                              class="textarea textarea-bordered h-24 w-full @error('description') textarea-error @enderror"
                              placeholder="Brief description about the partner">{{ old('description', $partner->description) }}</textarea>
                    @error('description')
                    <label class="label">
                        <span class="label-text-alt text-error flex items-center gap-1">
                            <i class="fas fa-exclamation-triangle text-xs"></i>
                            {{ $message }}
                        </span>
                    </label>
                    @enderror
                </div>

                <!-- Order Number Field -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold flex items-center gap-2">
                            <i class="fas fa-sort text-orange-500"></i>
                            Display Order
                        </span>
                    </label>
                    <div class="relative">
                        <input type="number" 
                               name="order_number" 
                               value="{{ old('order_number', $partner->order_number) }}" 
                               class="input input-bordered w-full @error('order_number') input-error @enderror pl-10" 
                               placeholder="0"
                               min="0">
                        <i class="fas fa-sort absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    <label class="label">
                        <span class="label-text-alt text-xs">Lower numbers will appear first</span>
                    </label>
                    @error('order_number')
                    <label class="label">
                        <span class="label-text-alt text-error flex items-center gap-1">
                            <i class="fas fa-exclamation-triangle text-xs"></i>
                            {{ $message }}
                        </span>
                    </label>
                    @enderror
                </div>

                <!-- Status Field -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold flex items-center gap-2">
                            <i class="fas fa-flag text-orange-500"></i>
                            Status
                            <span class="label-text-alt text-error">*</span>
                        </span>
                    </label>
                    <div class="flex gap-4">
                        <label class="cursor-pointer">
                            <input type="radio" name="is_active" value="1" class="radio radio-primary" {{ old('is_active', $partner->is_active) ? 'checked' : '' }}>
                            <span class="ml-2">Active</span>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="is_active" value="0" class="radio radio-primary" {{ old('is_active', $partner->is_active) ? '' : 'checked' }}>
                            <span class="ml-2">Inactive</span>
                        </label>
                    </div>
                    @error('is_active')
                    <label class="label">
                        <span class="label-text-alt text-error flex items-center gap-1">
                            <i class="fas fa-exclamation-triangle text-xs"></i>
                            {{ $message }}
                        </span>
                    </label>
                    @enderror
                </div>

                <!-- Partner Info -->
                <div class="alert alert-info mb-6">
                    <i class="fas fa-info-circle mr-2"></i>
                    <div>
                        <p class="font-semibold">Partner Information</p>
                        <p class="text-sm">Created: {{ $partner->created_at->format('d M Y H:i') }}</p>
                        <p class="text-sm">Last Updated: {{ $partner->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-between items-center pt-4 border-t">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.partners.index') }}" class="btn btn-ghost">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </a>
                        <button type="submit" class="btn bg-orange-600 hover:bg-orange-700 text-white border-none">
                            <i class="fas fa-save mr-2"></i>
                            Update Partner
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
                    <p class="text-sm text-gray-600">Once you delete a partner, there is no going back.</p>
                </div>
                <form action="{{ route('admin.partners.destroy', $partner) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this partner? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error">
                        <i class="fas fa-trash mr-2"></i>
                        Delete Partner
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection