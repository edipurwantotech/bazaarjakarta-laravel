@extends('layouts.admin')

@section('content')
<div class="container mx-auto max-w-4xl">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('admin.events.index') }}" class="btn btn-ghost btn-sm">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Events
            </a>
        </div>
        <h1 class="text-3xl font-bold text-orange-600">Edit Event</h1>
        <p class="text-base-content/70">Update event information</p>
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
            <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Title Field -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold flex items-center gap-2">
                            <i class="fas fa-heading text-orange-500"></i>
                            Event Title
                            <span class="label-text-alt text-error">*</span>
                        </span>
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="title" 
                               value="{{ old('title', $event->title) }}" 
                               class="input input-bordered w-full @error('title') input-error @enderror pl-10" 
                               placeholder="Enter event title"
                               required
                               id="eventTitle">
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

                <!-- Slug Field -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold flex items-center gap-2">
                            <i class="fas fa-link text-orange-500"></i>
                            URL Slug
                        </span>
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="slug" 
                               value="{{ old('slug', $event->slug) }}" 
                               class="input input-bordered w-full @error('slug') input-error @enderror pl-10" 
                               placeholder="event-url-slug"
                               id="eventSlug">
                        <i class="fas fa-link absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    @error('slug')
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
                    <div class="flex gap-2 mb-2">
                        <button type="button" id="toggleWysiwyg" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye mr-1"></i> Visual Editor
                        </button>
                        <button type="button" id="toggleSource" class="btn btn-sm btn-outline">
                            <i class="fas fa-code mr-1"></i> HTML Code
                        </button>
                    </div>
                    <div id="wysiwyg-container">
                        <div id="description-editor">
                            <textarea name="description"
                                      id="description"
                                      class="hidden"
                                      placeholder="Describe the event...">{{ old('description', $event->description) }}</textarea>
                        </div>
                    </div>
                    <div id="description-source" style="display: none;">
                        <textarea name="description_source"
                                  id="description-source-textarea"
                                  class="textarea textarea-bordered h-64 w-full font-mono text-sm"
                                  placeholder="Enter HTML code...">{{ old('description', $event->description) }}</textarea>
                    </div>
                    @error('description')
                    <label class="label">
                        <span class="label-text-alt text-error flex items-center gap-1">
                            <i class="fas fa-exclamation-triangle text-xs"></i>
                            {{ $message }}
                        </span>
                    </label>
                    @enderror
                </div>

                <!-- Thumbnail Field -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold flex items-center gap-2">
                            <i class="fas fa-image text-orange-500"></i>
                            Event Thumbnail
                        </span>
                    </label>
                    @if($event->thumbnail)
                    <div class="mb-2">
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('storage/' . $event->thumbnail) }}" alt="{{ $event->title }}" class="w-24 h-24 object-cover rounded">
                            <div>
                                <p class="text-sm">Current thumbnail</p>
                                <p class="text-xs opacity-70">Upload a new image to replace</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    <input type="file"
                           name="thumbnail"
                           class="file-input file-input-bordered w-full @error('thumbnail') file-input-error @enderror"
                           accept="image/*"
                           id="thumbnailInput">
                    @error('thumbnail')
                    <label class="label">
                        <span class="label-text-alt text-error flex items-center gap-1">
                            <i class="fas fa-exclamation-triangle text-xs"></i>
                            {{ $message }}
                        </span>
                    </label>
                    @enderror
                    <label class="label">
                        <span class="label-text-alt text-xs">Optional: Upload event thumbnail (JPEG, PNG, JPG, GIF - Max 2MB)</span>
                    </label>
                </div>

                <!-- Date and Time Fields -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold flex items-center gap-2">
                                <i class="fas fa-calendar-day text-orange-500"></i>
                                Start Date
                                <span class="label-text-alt text-error">*</span>
                            </span>
                        </label>
                        <input type="date" 
                               name="start_date" 
                               value="{{ old('start_date', $event->start_date->format('Y-m-d')) }}" 
                               class="input input-bordered w-full @error('start_date') input-error @enderror" 
                               required>
                        @error('start_date')
                        <label class="label">
                            <span class="label-text-alt text-error flex items-center gap-1">
                                <i class="fas fa-exclamation-triangle text-xs"></i>
                                {{ $message }}
                            </span>
                        </label>
                        @enderror
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold flex items-center gap-2">
                                <i class="fas fa-calendar-check text-orange-500"></i>
                                End Date
                            </span>
                        </label>
                        <input type="date" 
                               name="end_date" 
                               value="{{ old('end_date', $event->end_date?->format('Y-m-d')) }}" 
                               class="input input-bordered w-full @error('end_date') input-error @enderror">
                        @error('end_date')
                        <label class="label">
                            <span class="label-text-alt text-error flex items-center gap-1">
                                <i class="fas fa-exclamation-triangle text-xs"></i>
                                {{ $message }}
                            </span>
                        </label>
                        @enderror
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold flex items-center gap-2">
                                <i class="fas fa-clock text-orange-500"></i>
                                Time
                            </span>
                        </label>
                        <input type="time" 
                               name="time" 
                               value="{{ old('time', $event->time) }}" 
                               class="input input-bordered w-full @error('time') input-error @enderror">
                        @error('time')
                        <label class="label">
                            <span class="label-text-alt text-error flex items-center gap-1">
                                <i class="fas fa-exclamation-triangle text-xs"></i>
                                {{ $message }}
                            </span>
                        </label>
                        @enderror
                    </div>
                </div>

                <!-- Location Field -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-orange-500"></i>
                            Location
                        </span>
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="location" 
                               value="{{ old('location', $event->location) }}" 
                               class="input input-bordered w-full @error('location') input-error @enderror pl-10" 
                               placeholder="Event location">
                        <i class="fas fa-map-marker-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    @error('location')
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
                            <input type="radio" name="status" value="draft" class="radio radio-primary" {{ old('status', $event->status) == 'draft' ? 'checked' : '' }}>
                            <span class="ml-2">Draft</span>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="status" value="published" class="radio radio-primary" {{ old('status', $event->status) == 'published' ? 'checked' : '' }}>
                            <span class="ml-2">Published</span>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="status" value="archived" class="radio radio-primary" {{ old('status', $event->status) == 'archived' ? 'checked' : '' }}>
                            <span class="ml-2">Archived</span>
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

                <!-- Categories Field -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold flex items-center gap-2">
                            <i class="fas fa-tags text-orange-500"></i>
                            Categories
                        </span>
                    </label>
                    <div class="border border-base-300 rounded-lg p-4 bg-base-100">
                        @if($categories->count() > 0)
                            <div class="grid grid-cols-1 gap-2 max-h-48 overflow-y-auto">
                                @foreach($categories as $category)
                                <label class="cursor-pointer flex items-center gap-2">
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                           class="checkbox checkbox-sm checkbox-primary"
                                           {{ old('categories') && in_array($category->id, old('categories')) ? 'checked' : '' }}
                                           {{ $event->categories->contains($category->id) ? 'checked' : '' }}>
                                    <span class="text-sm">{{ $category->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm opacity-70">No categories available. Please create categories first.</p>
                        @endif
                    </div>
                    @error('categories')
                    <label class="label">
                        <span class="label-text-alt text-error flex items-center gap-1">
                            <i class="fas fa-exclamation-triangle text-xs"></i>
                            {{ $message }}
                        </span>
                    </label>
                    @enderror
                    <label class="label">
                        <span class="label-text-alt text-xs">Optional: Select categories for this event</span>
                    </label>
                </div>

                <!-- Highlight Events Field -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold flex items-center gap-2">
                            <i class="fas fa-star text-orange-500"></i>
                            Highlight Events
                        </span>
                    </label>
                    <div class="relative">
                        <div class="input input-bordered w-full pl-10 flex items-center gap-2" id="highlightEventsInput">
                            <i class="fas fa-search text-gray-400"></i>
                            <input type="text"
                                   id="highlightEventsSearch"
                                   class="flex-grow bg-transparent outline-none"
                                   placeholder="Search and select highlight events..."
                                   autocomplete="off">
                            <div id="selectedHighlightEvents" class="flex flex-wrap gap-1">
                                <!-- Selected highlight events will be displayed here -->
                            </div>
                        </div>
                        <div id="highlightEventsDropdown" class="absolute z-10 w-full bg-base-100 border border-base-300 rounded-lg shadow-lg mt-1 hidden">
                            <div class="max-h-48 overflow-y-auto">
                                @if($highlightEvents->count() > 0)
                                    @foreach($highlightEvents as $highlightEvent)
                                    <div class="highlight-event-item px-4 py-2 hover:bg-base-200 cursor-pointer flex items-center gap-2"
                                         data-id="{{ $highlightEvent->id }}"
                                         data-name="{{ $highlightEvent->name }}">
                                        @if($highlightEvent->icon)
                                        <i class="{{ $highlightEvent->icon }} text-orange-500"></i>
                                        @endif
                                        <span>{{ $highlightEvent->name }}</span>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="px-4 py-2 text-gray-500">No highlight events available</div>
                                @endif
                            </div>
                        </div>
                        <!-- Hidden input to store selected highlight event IDs -->
                        <input type="hidden" name="highlight_events" id="highlightEventsIds" value="">
                    </div>
                    @error('highlight_events')
                    <label class="label">
                        <span class="label-text-alt text-error flex items-center gap-1">
                            <i class="fas fa-exclamation-triangle text-xs"></i>
                            {{ $message }}
                        </span>
                    </label>
                    @enderror
                    <label class="label">
                        <span class="label-text-alt text-xs">Optional: Select highlight events to feature this event</span>
                    </label>
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
                           value="{{ old('meta_title', $event->meta_title) }}" 
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
                              placeholder="Optional: Meta description for SEO">{{ old('meta_description', $event->meta_description) }}</textarea>
                </div>

                <!-- Meta Keywords -->
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text font-semibold">Meta Keywords</span>
                    </label>
                    <input type="text" 
                           name="meta_keywords" 
                           value="{{ old('meta_keywords', $event->meta_keywords) }}" 
                           class="input input-bordered w-full" 
                           placeholder="Optional: Comma-separated keywords">
                </div>


                <!-- Event Info -->
                <div class="alert alert-info mb-6">
                    <i class="fas fa-info-circle mr-2"></i>
                    <div>
                        <p class="font-semibold">Event Information</p>
                        <p class="text-sm">Created: {{ $event->created_at->format('d M Y H:i') }}</p>
                        <p class="text-sm">Last Updated: {{ $event->updated_at->format('d M Y H:i') }}</p>
                        <p class="text-sm">Author: {{ $event->creator?->name ?? 'Unknown' }}</p>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-between items-center pt-4 border-t">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.events.index') }}" class="btn btn-ghost">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </a>
                        <button type="submit" class="btn bg-orange-600 hover:bg-orange-700 text-white border-none">
                            <i class="fas fa-save mr-2"></i>
                            Update Event
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
                    <p class="text-sm text-gray-600">Once you delete an event, there is no going back.</p>
                </div>
                <form action="{{ route('admin.events.destroy', $event) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this event? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error">
                        <i class="fas fa-trash mr-2"></i>
                        Delete Event
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('eventTitle');
    const slugInput = document.getElementById('eventSlug');
    
    titleInput.addEventListener('input', function() {
        const title = this.value.trim();
        if (title) {
            slugInput.value = title.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
        }
    });
    
    // Also update slug when slug input changes manually
    slugInput.addEventListener('input', function() {
        if (!this.value.trim()) {
            const title = titleInput.value.trim();
            if (title) {
                this.value = title.toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-|-$/g, '');
            }
        }
    });
    
    // Initialize CKEditor for description
    ClassicEditor
        .create(document.querySelector('#description-editor'), {
            toolbar: [
                'heading', '|',
                'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                'outdent', 'indent', '|',
                'imageUpload', 'blockQuote', 'insertTable', 'mediaEmbed', '|',
                'undo', 'redo'
            ],
            placeholder: 'Describe the event...',
            height: 200
        })
        .then(editor => {
            // Store the editor instance
            window.descriptionEditor = editor;
            
            // Set initial content
            const initialContent = document.getElementById('description').value;
            if (initialContent) {
                editor.setData(initialContent);
                document.getElementById('description-source-textarea').value = initialContent;
            }
            
            // Update the hidden textarea when content changes
            editor.model.document.on('change:data', () => {
                const content = editor.getData();
                document.getElementById('description').value = content;
                document.getElementById('description-source-textarea').value = content;
            });
        })
        .catch(error => {
            console.error(error);
        });
    
    // Toggle between WYSIWYG and source code
    const toggleWysiwyg = document.getElementById('toggleWysiwyg');
    const toggleSource = document.getElementById('toggleSource');
    const wysiwygContainer = document.getElementById('wysiwyg-container');
    const sourceContainer = document.getElementById('description-source');
    const sourceTextarea = document.getElementById('description-source-textarea');
    const hiddenTextarea = document.getElementById('description');
    
    // Initialize with source container hidden
    sourceContainer.style.display = 'none';
    
    toggleWysiwyg.addEventListener('click', function() {
        console.log('Switching to WYSIWYG mode');
        
        // Update editor content from source
        if (window.descriptionEditor && sourceTextarea.value) {
            const sourceContent = sourceTextarea.value;
            window.descriptionEditor.setData(sourceContent);
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
        if (window.descriptionEditor) {
            const editorContent = window.descriptionEditor.getData();
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
        if (window.descriptionEditor) {
            const content = window.descriptionEditor.getData();
            document.getElementById('description').value = content;
        }
    });
});
</script>
@endpush
@endsection