@extends('layouts.admin')

@section('content')
<div class="container mx-auto max-w-2xl">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('admin.partners.index') }}" class="btn btn-ghost btn-sm">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Partners
            </a>
        </div>
        <h1 class="text-3xl font-bold text-orange-600">Create New Partner</h1>
        <p class="text-base-content/70">Add a new partner or sponsor</p>
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
            <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Partner Info Card -->
                <div class="bg-orange-50 border-l-4 border-orange-400 p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-orange-600 mr-3"></i>
                        <div>
                            <p class="font-semibold text-orange-800">Partner Information</p>
                            <p class="text-sm text-orange-700">Add partners and sponsors that support your events</p>
                        </div>
                    </div>
                </div>
                
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
                               value="{{ old('name') }}" 
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
                            Logo
                        </span>
                    </label>
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
                               value="{{ old('website') }}" 
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
                    <label class="label">
                        <span class="label-text-alt text-xs">Optional: Partner website URL</span>
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
                                  placeholder="Brief description about the partner">{{ old('description') }}</textarea>
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
                        <span class="label-text-alt text-xs">Optional: Brief description about the partner</span>
                    </label>
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
                               value="{{ old('order_number', 0) }}" 
                               class="input input-bordered w-full @error('order_number') input-error @enderror pl-10" 
                               min="0"
                               placeholder="0">
                        <i class="fas fa-sort absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    @error('order_number')
                    <label class="label">
                        <span class="label-text-alt text-error flex items-center gap-1">
                            <i class="fas fa-exclamation-triangle text-xs"></i>
                            {{ $message }}
                        </span>
                    </label>
                    @enderror
                    <label class="label">
                        <span class="label-text-alt text-xs">Order for displaying partners (0 = first)</span>
                    </label>
                </div>

                <!-- Is Active Field -->
                <div class="form-control mb-6">
                    <label class="label cursor-pointer">
                        <span class="label-text font-semibold flex items-center gap-2">
                            <i class="fas fa-eye text-orange-500"></i>
                            Active Status
                        </span>
                        <input type="checkbox" name="is_active" value="1" class="checkbox checkbox-primary" checked>
                    </label>
                    <label class="label">
                        <span class="label-text-alt text-xs">Check to make this partner visible on the website</span>
                    </label>
                    <input type="hidden" name="is_active" value="0">
                </div>

                <!-- Form Actions -->
                <div class="flex justify-between items-center pt-4 border-t">
                    <a href="{{ route('admin.partners.index') }}" class="btn btn-ghost">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn bg-orange-600 hover:bg-orange-700 text-white border-none">
                        <i class="fas fa-save mr-2"></i>
                        Create Partner
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection