@extends('layouts.app')

@section('content')
    <!-- HERO / SLIDER -->
    <section class="relative py-10 overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-br from-orange-50 to-white -z-10"></div>
      <div class="container mx-auto px-4 md:px-8 animate-fade-in">
        <div class="text-center mb-8">
          <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">
            Event Terkini
          </h2>
          <p class="text-gray-600 max-w-2xl mx-auto">
            Temukan berbagai acara menarik yang diselenggarakan oleh BazaarJakarta.ID
          </p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
          @forelse($latestEvents as $index => $event)
            <div class="bg-white rounded-xl shadow overflow-hidden relative group hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
              <div class="h-56 relative overflow-hidden">
                @if($event->thumbnail)
                  <img
                    src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3Crect fill='%23f3f4f6' width='400' height='300'/%3E%3C/svg%3E"
                    data-src="{{ asset('storage/' . $event->thumbnail) }}"
                    alt="{{ $event->title }}"
                    class="w-full h-full object-cover lazy"
                    loading="lazy"
                  />
                @else
                  <div class="absolute inset-0 bg-gradient-to-br {{ $index == 0 ? 'from-orange-400 to-orange-600' : ($index == 1 ? 'from-purple-400 to-pink-600' : 'from-green-400 to-blue-600') }} flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-white text-5xl opacity-50"></i>
                  </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                @if($event->categories->isNotEmpty())
                  <a href="{{ route('events.category', $event->categories->first()->slug) }}" class="bg-{{ $index == 0 ? 'orange' : ($index == 1 ? 'purple' : 'green') }}-500 text-white text-xs px-3 py-1 rounded-full absolute top-4 right-4 z-10 hover:opacity-80 transition-opacity">
                    {{ strtoupper($event->categories->first()->name) }}
                  </a>
                @else
                  <span class="bg-orange-500 text-white text-xs px-3 py-1 rounded-full absolute top-4 right-4 z-10">EVENT</span>
                @endif
              </div>
              <div class="p-4">
                <h3 class="font-bold text-lg text-orange-600 mb-2">{{ $event->title }}</h3>
                <p class="text-gray-600 text-sm mb-3">{!! Str::limit($event->description, 100) !!}</p>
                <a href="{{ route('event.detail', $event->slug) }}" class="text-orange-600 font-semibold text-sm hover:text-orange-700 transition-colors inline-flex items-center gap-1">
                  SELENGKAPNYA <i class="fas fa-arrow-right text-xs"></i>
                </a>
              </div>
            </div>
          @empty
            <div class="col-span-3 text-center">
              <p class="text-gray-500">Belum ada event tersedia.</p>
            </div>
          @endforelse
        </div>
      </div>
    </section>

    <!-- STATISTICS SECTION -->
    <section class="py-10 bg-white">
      <div class="container mx-auto px-4 md:px-8">
        <div class="text-center mb-8">
          <h2 class="text-2xl font-bold text-gray-800 mb-4">Kami Percaya pada Angka</h2>
          <p class="text-gray-600 max-w-2xl mx-auto">
            Statistik kami menunjukkan komitmen dan pengalaman dalam mengorganisir acara-acara berkualitas
          </p>
        </div>
        <div class="grid md:grid-cols-4 gap-4">
          <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg p-4 text-white text-center">
            <i class="fas fa-calendar-check text-3xl mb-2"></i>
            <div class="text-2xl font-bold mb-1">{{ $homepageStats['event_sukses'] }}</div>
            <div class="text-xs opacity-90">Event Sukses</div>
          </div>
          <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg p-4 text-white text-center">
            <i class="fas fa-users text-3xl mb-2"></i>
            <div class="text-2xl font-bold mb-1">{{ $homepageStats['peserta'] }}</div>
            <div class="text-xs opacity-90">Peserta</div>
          </div>
          <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg p-4 text-white text-center">
            <i class="fas fa-handshake text-3xl mb-2"></i>
            <div class="text-2xl font-bold mb-1">{{ $homepageStats['partner_bisnis'] }}</div>
            <div class="text-xs opacity-90">Partner Bisnis</div>
          </div>
          <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg p-4 text-white text-center">
            <i class="fas fa-award text-3xl mb-2"></i>
            <div class="text-2xl font-bold mb-1">{{ $homepageStats['penghargaan'] }}</div>
            <div class="text-xs opacity-90">Penghargaan</div>
          </div>
        </div>
      </div>
    </section>

    <!-- BANNER -->
    <section class="relative py-12 overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-r from-orange-600 to-orange-700"></div>
      <div class="container mx-auto px-4 md:px-8 relative z-10">
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 text-center text-white">
          <h2 class="text-2xl md:text-3xl font-bold mb-4">BazaarJakartaID | Your Partner Event</h2>
          <p class="text-lg mb-6 max-w-2xl mx-auto">
            Kami adalah mitra terpercaya untuk semua kebutuhan acara Anda, dari konsep hingga eksekusi yang sempurna
          </p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="https://wa.me/{{ preg_replace('/[^0-9+]/', '', $whatsappNumber ?? '+628123456789') }}?text=Halo%20BazaarJakarta.ID,%20saya%20ingin%20bertanya%20tentang%20event%20anda"
               target="_blank"
               class="bg-white text-orange-600 px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition-colors">
              <i class="fas fa-phone-alt mr-2"></i>Hubungi Kami
            </a>
            <a href="#" class="bg-transparent border-2 border-white text-white px-6 py-3 rounded-full font-semibold hover:bg-white hover:text-orange-600 transition-all">
              <i class="fas fa-calendar mr-2"></i>Lihat Event
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- EVENT LIST -->
    <section class="py-16 bg-gray-50">
      <div class="container mx-auto px-4 md:px-8">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-800 mb-4">Event Mendatang</h2>
          <p class="text-gray-600 max-w-2xl mx-auto">
            Jangan lewatkan acara-acara menarik yang akan datang
          </p>
        </div>
        <div class="grid md:grid-cols-3 gap-8" id="events-container">
          @forelse($latestEvents as $index => $event)
            @include('partials.event-card', ['event' => $event, 'index' => $index])
          @empty
            <div class="col-span-3 text-center">
              <p class="text-gray-500">Belum ada event tersedia.</p>
            </div>
          @endforelse
        </div>
        <div class="text-center mt-12">
          <button id="load-more-events" class="bg-orange-600 text-white px-8 py-3 rounded-full font-semibold hover:bg-orange-700 transition-colors inline-flex items-center gap-2">
            Lihat Semua Event <i class="fas fa-arrow-right"></i>
          </button>
          <div id="loading" class="hidden">
            <i class="fas fa-spinner fa-spin text-orange-600 text-2xl"></i>
          </div>
        </div>
      </div>
    </section>

    <!-- PARTNERS -->
    <section class="bg-white py-16">
      <div class="container mx-auto px-4 md:px-8">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-800 mb-4">Mitra Kami</h2>
          <p class="text-gray-600 max-w-2xl mx-auto">
            Kami bangga bekerja sama dengan berbagai perusahaan dan organisasi terkemuka
          </p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center">
          @forelse($partners as $partner)
            <div class="bg-gray-50 p-4 rounded-xl flex flex-col items-center justify-center hover:bg-gray-100 transition-colors min-h-[100px]">
              @if($partner->logo)
                <img
                  src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 80'%3E%3Crect fill='%23e5e7eb' width='200' height='80'/%3E%3C/svg%3E"
                  data-src="{{ asset('storage/' . $partner->logo) }}"
                  alt="{{ $partner->name }}"
                  class="h-10 max-w-full object-contain filter grayscale hover:grayscale-0 transition-all mb-2 lazy"
                  loading="lazy"
                />
              @else
                <div class="h-10 w-20 bg-gray-300 rounded flex items-center justify-center mb-2">
                  <span class="text-gray-500 text-xs text-center">{{ Str::limit($partner->name, 15) }}</span>
                </div>
              @endif
              <p class="text-xs text-gray-700 font-medium text-center">{{ $partner->name }}</p>
            </div>
          @empty
            <div class="col-span-4 text-center">
              <p class="text-gray-500">Belum ada mitra tersedia.</p>
            </div>
          @endforelse
        </div>
      </div>
    </section>

    <!-- Lazy Loading and Infinite Scroll Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Lazy loading implementation
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            const src = img.getAttribute('data-src');
                            
                            if (src) {
                                img.src = src;
                                img.classList.remove('lazy');
                                imageObserver.unobserve(img);
                            }
                        }
                    });
                });

                // Observe all lazy images
                document.querySelectorAll('img.lazy').forEach(img => {
                    imageObserver.observe(img);
                });
            } else {
                // Fallback for browsers that don't support IntersectionObserver
                const lazyImages = document.querySelectorAll('img.lazy');
                
                function lazyLoad() {
                    lazyImages.forEach(img => {
                        if (img.getBoundingClientRect().top <= window.innerHeight && img.getBoundingClientRect().bottom >= 0 && getComputedStyle(img).display !== 'none') {
                            const src = img.getAttribute('data-src');
                            if (src) {
                                img.src = src;
                                img.classList.remove('lazy');
                            }
                        }
                    });
                    
                    // If all images are loaded, remove scroll event listener
                    if (lazyImages.length === 0) {
                        document.removeEventListener('scroll', lazyLoad);
                        window.removeEventListener('resize', lazyLoad);
                        window.removeEventListener('orientationChange', lazyLoad);
                    }
                }
                
                document.addEventListener('scroll', lazyLoad);
                window.addEventListener('resize', lazyLoad);
                window.addEventListener('orientationChange', lazyLoad);
                lazyLoad(); // Initial check
            }

            // Infinite scroll implementation
            let page = 2; // Start from page 2 since we already loaded the first 6 events
            const loadMoreBtn = document.getElementById('load-more-events');
            const loadingDiv = document.getElementById('loading');
            const eventsContainer = document.getElementById('events-container');
            
            loadMoreBtn.addEventListener('click', function() {
                loadMoreEvents();
            });

            // Auto scroll to load more when clicking "Lihat Semua Event"
            let isLoading = false;
            
            function loadMoreEvents() {
                if (isLoading) return;
                
                isLoading = true;
                loadMoreBtn.classList.add('hidden');
                loadingDiv.classList.remove('hidden');
                
                fetch(`{{ route('events.load-more') }}?page=${page}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.html) {
                            // Append new events
                            const tempDiv = document.createElement('div');
                            tempDiv.innerHTML = data.html;
                            
                            while (tempDiv.firstChild) {
                                eventsContainer.appendChild(tempDiv.firstChild);
                            }
                            
                            // Re-observe new lazy images after adding them to DOM
                            if ('IntersectionObserver' in window) {
                                document.querySelectorAll('img.lazy').forEach(img => {
                                    imageObserver.observe(img);
                                });
                            }
                            
                            page++;
                            
                            if (data.hasMore) {
                                loadMoreBtn.classList.remove('hidden');
                                // Auto scroll to load more
                                setTimeout(() => {
                                    if (data.hasMore) {
                                        loadMoreEvents();
                                    }
                                }, 1000);
                            } else {
                                // No more events, show message
                                const noMoreMessage = document.createElement('div');
                                noMoreMessage.className = 'col-span-3 text-center mt-4';
                                noMoreMessage.innerHTML = '<p class="text-gray-500">Semua event telah ditampilkan</p>';
                                eventsContainer.appendChild(noMoreMessage);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error loading more events:', error);
                        loadMoreBtn.classList.remove('hidden');
                    })
                    .finally(() => {
                        isLoading = false;
                        loadingDiv.classList.add('hidden');
                    });
            }
        });
    </script>
@endsection