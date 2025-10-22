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
        <h1 class="text-3xl font-bold text-orange-600">Create New Page</h1>
        <p class="text-base-content/70">Add a new page to your website</p>
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
            <form action="{{ route('admin.pages.store') }}" method="POST">
                @csrf
                
                <!-- Page Info Card -->
                <div class="bg-orange-50 border-l-4 border-orange-400 p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-orange-600 mr-3"></i>
                        <div>
                            <p class="font-semibold text-orange-800">Page Information</p>
                            <p class="text-sm text-orange-700">Pages are used for static content like About Us, Contact, etc.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Title Field -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold flex items-center gap-2">
                            <i class="fas fa-heading text-orange-500"></i>
                            Page Title
                            <span class="label-text-alt text-error">*</span>
                        </span>
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="title" 
                               value="{{ old('title') }}" 
                               class="input input-bordered w-full @error('title') input-error @enderror pl-10" 
                               placeholder="e.g., About Us, Contact, Privacy Policy"
                               required
                               id="pageTitle">
                        <i class="fas fa-heading absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    @error('title')
                    <label class="label">
                        <span class="label-text-alt text-error flex items-center gap-1">
                            <i class="fas fa-exclamation-triangle text-xs"></i>
                            {{ $message }}
                        </span>
                    </label>
                    @enderror
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
                        <span class="text-sm text-base-content/70">{{ url('/page/') }}</span>
                        <span id="slugPreview" class="font-mono text-sm">page-title</span>
                    </div>
                    <label class="label">
                        <span class="label-text-alt text-xs">Slug will be automatically generated from the page title</span>
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
                    <div class="flex gap-2 mb-2">
                        <button type="button" id="toggleWysiwyg" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye mr-1"></i> Visual Editor
                        </button>
                        <button type="button" id="toggleSource" class="btn btn-sm btn-outline">
                            <i class="fas fa-code mr-1"></i> HTML Source
                        </button>
                    </div>
                    <div id="wysiwyg-container">
                        <div id="content-editor">
                            <textarea name="content"
                                      id="content"
                                      class="hidden"
                                      placeholder="Enter the page content...">{{ old('content') }}</textarea>
                        </div>
                    </div>
                    <div id="content-source" style="display: none;">
                        <textarea name="content_source"
                                  id="content-source-textarea"
                                  class="textarea textarea-bordered h-64 w-full font-mono text-sm"
                                  placeholder="Enter HTML code...">{{ old('content') }}</textarea>
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
                            <input type="radio" name="status" value="draft" class="radio radio-primary" checked>
                            <span class="ml-2">Draft</span>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="status" value="published" class="radio radio-primary">
                            <span class="ml-2">Published</span>
                        </label>
                    </div>
                    @error('status')
                    <label class="label">
                        <span class="label-text-alt text-error flex items-center gap-1">
                            <i class="fas fa-exclamation-triangle text-xs"></i>
                            {{ $message }}
                        </span>
                    </label>
                    @enderror
                </div>

                <!-- SEO Fields -->
                <div class="divider">SEO Options</div>
                
                <!-- Meta Title -->
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text font-semibold">Meta Title</span>
                    </label>
                    <input type="text" 
                           name="meta_title" 
                           value="{{ old('meta_title') }}" 
                           class="input input-bordered w-full" 
                           placeholder="Optional: Meta title for SEO">
                </div>

                <!-- Meta Description -->
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text font-semibold">Meta Description</span>
                    </label>
                    <textarea name="meta_description" 
                              class="textarea textarea-bordered h-20 w-full" 
                              placeholder="Optional: Meta description for SEO">{{ old('meta_description') }}</textarea>
                </div>

                <!-- Meta Keywords -->
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text font-semibold">Meta Keywords</span>
                    </label>
                    <input type="text" 
                           name="meta_keywords" 
                           value="{{ old('meta_keywords') }}" 
                           class="input input-bordered w-full" 
                           placeholder="Optional: Comma-separated keywords">
                </div>

                <!-- Canonical URL -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold">Canonical URL</span>
                    </label>
                    <input type="url" 
                           name="canonical_url" 
                           value="{{ old('canonical_url') }}" 
                           class="input input-bordered w-full" 
                           placeholder="Optional: Canonical URL">
                </div>

                <!-- Form Actions -->
                <div class="flex justify-between items-center pt-4 border-t">
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-ghost">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn bg-orange-600 hover:bg-orange-700 text-white border-none">
                        <i class="fas fa-save mr-2"></i>
                        Create Page
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('pageTitle');
    const slugPreview = document.getElementById('slugPreview');
    
    titleInput.addEventListener('input', function() {
        const title = this.value.trim();
        if (title) {
            slugPreview.textContent = title.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
        } else {
            slugPreview.textContent = 'page-title';
        }
    });
    
    // Initialize CKEditor for content
    ClassicEditor
        .create(document.querySelector('#content-editor'), {
            toolbar: [
                'heading', '|',
                'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                'outdent', 'indent', '|',
                'imageUpload', 'blockQuote', 'insertTable', 'mediaEmbed', '|',
                'undo', 'redo'
            ],
            placeholder: 'Enter the page content...',
            height: 300
        })
        .then(editor => {
            // Store the editor instance
            window.contentEditor = editor;
            
            // Set initial content
            const initialContent = document.getElementById('content').value;
            if (initialContent) {
                editor.setData(initialContent);
                document.getElementById('content-source-textarea').value = initialContent;
            }
            
            // Update the hidden textarea when content changes
            editor.model.document.on('change:data', () => {
                const content = editor.getData();
                document.getElementById('content').value = content;
                document.getElementById('content-source-textarea').value = content;
            });
        })
        .catch(error => {
            console.error(error);
        });
    
    // Toggle between WYSIWYG and source code
    const toggleWysiwyg = document.getElementById('toggleWysiwyg');
    const toggleSource = document.getElementById('toggleSource');
    const wysiwygContainer = document.getElementById('wysiwyg-container');
    const sourceContainer = document.getElementById('content-source');
    const sourceTextarea = document.getElementById('content-source-textarea');
    const hiddenTextarea = document.getElementById('content');
    
    // Initialize with source container hidden
    sourceContainer.style.display = 'none';
    
    toggleWysiwyg.addEventListener('click', function() {
        console.log('Switching to WYSIWYG mode');
        
        // Update editor content from source
        if (window.contentEditor && sourceTextarea.value) {
            const sourceContent = sourceTextarea.value;
            window.contentEditor.setData(sourceContent);
            hiddenTextarea.value = sourceContent;
        }
        
        // Show editor, hide source
        wysiwygContainer.style.display = 'block';
        sourceContainer.style.display = 'none';
        
        // Update button styles
        toggleWysiwyg.classList.add('btn-primary');
        toggleWysiwyg.classList.remove('btn-outline');
        toggleSource.classList.remove('btn-primary');
        toggleSource.classList.add('btn-outline');
    });
    
    toggleSource.addEventListener('click', function() {
        console.log('Switching to Source mode');
        
        // Update source from editor
        if (window.contentEditor) {
            const editorContent = window.contentEditor.getData();
            sourceTextarea.value = editorContent;
            hiddenTextarea.value = editorContent;
        }
        
        // Show source, hide editor
        wysiwygContainer.style.display = 'none';
        sourceContainer.style.display = 'block';
        
        // Update button styles
        toggleSource.classList.add('btn-primary');
        toggleSource.classList.remove('btn-outline');
        toggleWysiwyg.classList.remove('btn-primary');
        toggleWysiwyg.classList.add('btn-outline');
    });
    
    // Update hidden textarea when source textarea changes
    sourceTextarea.addEventListener('input', function() {
        hiddenTextarea.value = this.value;
    });
    
    // Initialize source textarea with any existing content
    if (hiddenTextarea.value) {
        sourceTextarea.value = hiddenTextarea.value;
    }
    
    // Before form submission, make sure CKEditor content is saved to the textarea
    document.querySelector('form').addEventListener('submit', function() {
        if (window.contentEditor) {
            const content = window.contentEditor.getData();
            document.getElementById('content').value = content;
        }
    });
});
</script>
@endpush
@endsection