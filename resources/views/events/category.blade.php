@extends('layouts.app')

@section('content')
<!-- BREADCRUMB SECTION -->
<section class="bg-cover bg-center bg-no-repeat text-white py-12 relative" style="background-image: url('{{ asset('images/bazaar-category-bg.jpg') }}');">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="container mx-auto px-4 md:px-8 relative z-10">
        <div class="text-center">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $title }}</h1>
            <p class="text-orange-100">Temukan semua event dalam kategori {{ $category->name }}</p>
        </div>
    </div>
</section>

<!-- CATEGORY EVENTS SECTION -->
<section class="py-16">
    <div class="container mx-auto px-4 md:px-8">
        @if($events->count() > 0)
            <div class="mb-8">
                <p class="text-gray-600">Ditemukan {{ $events->total() }} event dalam kategori "<span class="font-semibold">{{ $category->name }}</span>"</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($events as $index => $event)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl animate-fade-in" style="animation-delay: {{ $index * 0.1 }}s">
                        @if($event->thumbnail)
                            <div class="h-48 overflow-hidden">
                                <img src="{{ asset('storage/' . $event->thumbnail) }}" alt="{{ $event->title }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                            </div>
                        @else
                            <div class="h-48 bg-gradient-to-r from-orange-400 to-orange-600 flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-white text-6xl"></i>
                            </div>
                        @endif
                        
                        <div class="p-6">
                            <div class="flex flex-wrap gap-2 mb-3">
                                @forelse($event->categories as $cat)
                                    <a href="{{ route('events.category', $cat->slug) }}" class="bg-orange-100 text-orange-600 text-xs px-2 py-1 rounded-full hover:bg-orange-200 transition-colors">{{ $cat->name }}</a>
                                @empty
                                    <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">Uncategorized</span>
                                @endforelse
                            </div>
                            
                            <h3 class="text-xl font-bold mb-2 line-clamp-2">{{ $event->title }}</h3>
                            
                            <div class="space-y-2 text-sm text-gray-600 mb-4">
                                @if($event->start_date)
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-calendar text-orange-500"></i>
                                        <span>{{ $event->start_date->format('d M Y') }} @if($event->end_date) - {{ $event->end_date->format('d M Y') }} @endif</span>
                                    </div>
                                @endif
                                
                                @if($event->time)
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-clock text-orange-500"></i>
                                        <span>{{ $event->time->format('H:i') }} WIB</span>
                                    </div>
                                @endif
                                
                                @if($event->location)
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-map-marker-alt text-orange-500"></i>
                                        <span>{{ Str::limit($event->location, 30) }}</span>
                                    </div>
                                @endif
                            </div>
                            
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ Str::limit(strip_tags($event->description), 100) }}</p>
                            
                            <a href="{{ route('event.detail', $event->slug) }}" class="block w-full bg-gradient-to-r from-orange-600 to-orange-700 text-white text-center py-2 rounded-lg font-semibold hover:from-orange-700 hover:to-orange-800 transition-all duration-300">
                                <i class="fas fa-arrow-right mr-2"></i>Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- PAGINATION -->
            <div class="mt-12">
                {{ $events->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="mb-8">
                    <i class="fas fa-folder-open text-6xl text-gray-300"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-700 mb-4">Belum Ada Event</h2>
                <p class="text-gray-600 mb-8">Belum ada event dalam kategori "<span class="font-semibold">{{ $category->name }}</span>"</p>
                <a href="{{ route('home') }}" class="inline-block bg-gradient-to-r from-orange-600 to-orange-700 text-white px-6 py-3 rounded-lg font-semibold hover:from-orange-700 hover:to-orange-800 transition-all duration-300">
                    <i class="fas fa-home mr-2"></i>Kembali ke Halaman Utama
                </a>
            </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let isLoading = false;
    let currentPage = {{ $events->currentPage() }};
    let hasMorePages = {{ $events->hasMorePages() ? 'true' : 'false' }};
    const eventsContainer = document.querySelector('.grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3');
    const paginationContainer = document.querySelector('.mt-12');
    
    // Hide pagination container
    if (paginationContainer) {
        paginationContainer.style.display = 'none';
    }
    
    // Function to load more events
    function loadMoreEvents() {
        if (isLoading || !hasMorePages) return;
        
        isLoading = true;
        
        // Show loading indicator
        const loadingDiv = document.createElement('div');
        loadingDiv.className = 'col-span-3 text-center mt-4';
        loadingDiv.innerHTML = '<i class="fas fa-spinner fa-spin text-orange-600 text-2xl"></i>';
        eventsContainer.appendChild(loadingDiv);
        
        // Fetch next page
        const url = new URL(window.location.href);
        url.searchParams.set('page', currentPage + 1);
        
        fetch(url.toString())
            .then(response => response.text())
            .then(html => {
                // Create a temporary DOM parser
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                // Extract new event cards
                const newEvents = doc.querySelectorAll('.grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3 > div');
                
                // Remove loading indicator
                loadingDiv.remove();
                
                // Add new events to the container
                newEvents.forEach((event, index) => {
                    // Clone the event element to avoid moving it from the parsed document
                    const eventClone = event.cloneNode(true);
                    // Add animation delay
                    eventClone.style.animationDelay = `${(currentPage - 1) * 6 + index) * 0.1}s`;
                    eventsContainer.appendChild(eventClone);
                });
                
                // Update current page
                currentPage++;
                
                // Check if there are more pages by looking for pagination in the fetched HTML
                const paginationLinks = doc.querySelectorAll('a[href*="page="]');
                hasMorePages = paginationLinks.length > {{ $events->lastPage() - $events->currentPage() }};
                
                // If no more pages, show message
                if (!hasMorePages) {
                    const noMoreMessage = document.createElement('div');
                    noMoreMessage.className = 'col-span-3 text-center mt-8';
                    noMoreMessage.innerHTML = '<p class="text-gray-500">Semua event telah ditampilkan</p>';
                    eventsContainer.appendChild(noMoreMessage);
                }
                
                isLoading = false;
            })
            .catch(error => {
                console.error('Error loading more events:', error);
                loadingDiv.remove();
                isLoading = false;
            });
    }
    
    // Infinite scroll implementation
    let scrollTimeout;
    window.addEventListener('scroll', function() {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(function() {
            // Check if user has scrolled to near bottom of page
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const windowHeight = window.innerHeight;
            const documentHeight = document.documentElement.scrollHeight;
            
            // Load more when user is within 200px of the bottom
            if (scrollTop + windowHeight >= documentHeight - 200) {
                loadMoreEvents();
            }
        }, 100);
    });
});
</script>
@endpush
@endsection