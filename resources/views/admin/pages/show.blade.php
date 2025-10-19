@extends('layouts.admin')

@section('content')
<div class="container mx-auto max-w-4xl">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('admin.pages.index') }}" class="btn btn-ghost btn-sm">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Pages
            </a>
        </div>
        <h1 class="text-3xl font-bold text-orange-600">{{ $page->title }}</h1>
        <p class="text-base-content/70">Page details and content</p>
    </div>

    <!-- Page Details -->
    <div class="card bg-base-100 shadow-lg mb-6">
        <div class="card-body">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h2 class="text-xl font-bold mb-2">{{ $page->title }}</h2>
                    <div class="flex gap-2 mb-4">
                        <span class="badge {{ $page->status == 'published' ? 'badge-success' : 'badge-warning' }} badge-sm">
                            {{ ucfirst($page->status) }}
                        </span>
                        <span class="badge badge-ghost badge-sm">{{ $page->slug }}</span>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-edit mr-2"></i>
                        Edit
                    </a>
                </div>
            </div>

            <!-- Content -->
            <div class="divider">Content</div>
            <div class="prose max-w-none my-4">
                {!! Purifier::clean($page->content) !!}
            </div>

            <!-- SEO Information -->
            <div class="divider">SEO Information</div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <h3 class="font-semibold mb-2">Meta Title</h3>
                    <p class="text-sm bg-base-200 p-2 rounded">{{ $page->meta_title ?? 'Not set' }}</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Canonical URL</h3>
                    <p class="text-sm bg-base-200 p-2 rounded">{{ $page->canonical_url ?? 'Not set' }}</p>
                </div>
                <div class="md:col-span-2">
                    <h3 class="font-semibold mb-2">Meta Description</h3>
                    <p class="text-sm bg-base-200 p-2 rounded">{{ $page->meta_description ?? 'Not set' }}</p>
                </div>
                <div class="md:col-span-2">
                    <h3 class="font-semibold mb-2">Meta Keywords</h3>
                    <p class="text-sm bg-base-200 p-2 rounded">{{ $page->meta_keywords ?? 'Not set' }}</p>
                </div>
            </div>

            <!-- Page Information -->
            <div class="divider">Page Information</div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                <div>
                    <h3 class="font-semibold mb-2">Created</h3>
                    <p class="text-sm">{{ $page->created_at->format('d M Y H:i') }}</p>
                    <p class="text-sm">By: {{ $page->creator?->name ?? 'Unknown' }}</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Last Updated</h3>
                    <p class="text-sm">{{ $page->updated_at->format('d M Y H:i') }}</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Page URL</h3>
                    <a href="{{ url('/page/' . $page->slug) }}" target="_blank" class="text-sm text-blue-500 hover:underline">
                        {{ url('/page/' . $page->slug) }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection