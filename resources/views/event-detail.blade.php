@extends('layouts.app')

@section('content')
    <!-- HERO EVENT -->
    <section class="relative py-10 bg-gradient-to-br from-orange-50 to-white">
      <div class="container mx-auto px-4 md:px-8">
        <div class="text-center mb-8 animate-fade-in">
          <div class="flex items-center justify-center gap-2 mb-4">
            @if($event->categories->isNotEmpty())
              <a href="{{ route('events.category', $event->categories->first()->slug) }}" class="bg-orange-500 text-white text-xs px-3 py-1 rounded-full hover:opacity-80 transition-opacity">{{ strtoupper($event->categories->first()->name) }}</a>
            @else
              <span class="bg-orange-500 text-white text-xs px-3 py-1 rounded-full">EVENT</span>
            @endif
            <span class="text-sm text-gray-600"><i class="far fa-calendar mr-1"></i>{{ $event->start_date->format('d F Y') }} @if($event->end_date && $event->end_date->format('Y-m-d') !== $event->start_date->format('Y-m-d'))- {{ $event->end_date->format('d F Y') }}@endif</span>
          </div>
          <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4 text-gray-800">{{ $event->title }}</h1>
          <p class="text-lg max-w-2xl mx-auto text-gray-600"><i class="fas fa-map-marker-alt mr-2"></i>{{ $event->location ?? 'Lokasi akan diinformasikan' }}</p>
        </div>
        
        <!-- Event Image Gallery -->
        <div class="max-w-4xl mx-auto">
          @if($event->thumbnail || $event->galleries->count() > 0)
            <!-- Main Thumbnail -->
            @if($event->thumbnail)
              <div class="mb-6">
                <img src="{{ asset('storage/' . $event->thumbnail) }}" alt="{{ $event->title }}" class="w-full rounded-xl shadow-lg" />
              </div>
            @endif
            
            <!-- Gallery Images -->
            @if($event->galleries->count() > 0)
              <h3 class="text-xl font-bold mb-4 text-gray-800">Galeri Event</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($event->galleries as $gallery)
                  <div class="mb-4">
                    <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->caption ?? $event->title }}" class="w-full rounded-xl shadow-lg" />
                    @if($gallery->caption)
                      <p class="text-center text-gray-600 text-sm mt-2">{{ $gallery->caption }}</p>
                    @endif
                  </div>
                @endforeach
              </div>
            @endif
          @else
            <div class="w-full h-96 bg-gradient-to-br from-orange-400 to-orange-600 rounded-xl shadow-lg flex items-center justify-center">
              <i class="fas fa-calendar-alt text-white text-6xl opacity-50"></i>
            </div>
          @endif
        </div>
      </div>
    </section>

    <!-- EVENT INFO -->
    <section class="py-10 bg-white">
      <div class="container mx-auto px-4 md:px-8">
        <div class="grid md:grid-cols-3 gap-8">
          <!-- Main Content -->
          <div class="md:col-span-2">
            <div class="mb-8">
              <h2 class="text-2xl font-bold mb-4">Tentang Event</h2>
              <div class="text-gray-600 leading-relaxed">
                {!! $event->description !!}
              </div>
            </div>

            @if($event->categories->isNotEmpty())
            <div class="mb-8">
              <h2 class="text-2xl font-bold mb-4">Kategori</h2>
              <div class="flex flex-wrap gap-2">
                @foreach($event->categories as $category)
                  <a href="{{ route('events.category', $category->slug) }}" class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm font-medium hover:bg-orange-200 transition-colors">
                    {{ $category->name }}
                  </a>
                @endforeach
              </div>
            </div>
            @endif

          </div>

          <!-- Sidebar -->
          <div>
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6 sticky top-24">
              <h3 class="text-xl font-bold mb-4">Informasi Event</h3>
              <div class="space-y-4">
                <div class="flex items-start gap-3">
                  <i class="fas fa-calendar text-orange-500 mt-1"></i>
                  <div>
                    <p class="font-semibold">Tanggal</p>
                    <p class="text-sm text-gray-600">{{ $event->start_date->format('d F Y') }} @if($event->end_date && $event->end_date->format('Y-m-d') !== $event->start_date->format('Y-m-d'))- {{ $event->end_date->format('d F Y') }}@endif</p>
                  </div>
                </div>
                @if($event->time)
                <div class="flex items-start gap-3">
                  <i class="fas fa-clock text-orange-500 mt-1"></i>
                  <div>
                    <p class="font-semibold">Waktu</p>
                    <p class="text-sm text-gray-600">{{ $event->time->format('H:i') }} WIB</p>
                  </div>
                </div>
                @endif
                @if($event->location)
                <div class="flex items-start gap-3">
                  <i class="fas fa-map-marker-alt text-orange-500 mt-1"></i>
                  <div>
                    <p class="font-semibold">Lokasi</p>
                    <p class="text-sm text-gray-600">{{ $event->location }}</p>
                  </div>
                </div>
                @endif
                <div class="flex items-start gap-3">
                  <i class="fas fa-ticket-alt text-orange-500 mt-1"></i>
                  <div>
                    <p class="font-semibold">Status</p>
                    <p class="text-sm text-gray-600">{{ ucfirst($event->status) }}</p>
                  </div>
                </div>
              </div>
              
              <div class="mt-6 space-y-3">
                <a href="https://wa.me/{{ preg_replace('/[^0-9+]/', '', $whatsappNumber ?? '+628123456789') }}?text=Halo%20BazaarJakarta.ID,%20saya%20ingin%20mendaftar%20untuk%20event:%20{{ urlencode($event->title) }}%20({{ $event->start_date->format('d F Y') }})"
                   target="_blank"
                   class="w-full bg-orange-600 text-white py-3 rounded-lg font-semibold hover:bg-orange-700 transition-colors text-center block">
                  <i class="fab fa-whatsapp mr-2"></i>Daftar Sekarang
                </a>
                <a href="#" class="w-full bg-gray-100 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-200 transition-colors text-center block">
                  <i class="fas fa-share-alt mr-2"></i>Bagikan Event
                </a>
              </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6">
              <h3 class="text-xl font-bold mb-4">Kontak Panitia</h3>
              <div class="space-y-3">
                <div class="flex items-center gap-3">
                  <i class="fas fa-phone text-orange-500"></i>
                  <p class="text-sm">+62 21 1234 5678</p>
                </div>
                <div class="flex items-center gap-3">
                  <i class="fas fa-envelope text-orange-500"></i>
                  <p class="text-sm">info@pekan-nusantara.id</p>
                </div>
                <div class="flex items-center gap-3">
                  <i class="fab fa-instagram text-orange-500"></i>
                  <p class="text-sm">@pekan_nusantara</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- RELATED EVENTS -->
    @if($relatedEvents->count() > 0)
    <section class="py-10 bg-gray-50">
      <div class="container mx-auto px-4 md:px-8">
        <h2 class="text-2xl font-bold mb-6">Event Terkait</h2>
        <div class="grid md:grid-cols-3 gap-6">
          @foreach($relatedEvents as $index => $relatedEvent)
          <div class="bg-white rounded-xl shadow overflow-hidden hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
            <div class="h-48 relative overflow-hidden">
              @if($relatedEvent->thumbnail)
                <img src="{{ asset('storage/' . $relatedEvent->thumbnail) }}" alt="{{ $relatedEvent->title }}" class="w-full h-full object-cover" />
              @else
                <div class="absolute inset-0 bg-gradient-to-br {{ $index % 3 == 0 ? 'from-orange-400 to-orange-600' : ($index % 3 == 1 ? 'from-purple-400 to-pink-600' : 'from-green-400 to-blue-600') }}"></div>
              @endif
              <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
              @if($relatedEvent->categories->isNotEmpty())
                <span class="absolute top-4 left-4 bg-{{ $index % 3 == 0 ? 'orange' : ($index % 3 == 1 ? 'purple' : 'green') }}-500 text-white text-xs px-3 py-1 rounded-full">
                  {{ $relatedEvent->categories->first()->name }}
                </span>
              @endif
            </div>
            <div class="p-4">
              <h3 class="font-bold text-lg text-orange-600 mb-2">{{ $relatedEvent->title }}</h3>
              <p class="text-sm text-gray-600 mb-3">
                {{ $relatedEvent->start_date->format('d F Y') }}
                @if($relatedEvent->location) | {{ $relatedEvent->location }} @endif
              </p>
              <a href="{{ route('event.detail', $relatedEvent->slug) }}" class="text-orange-600 font-semibold text-sm hover:text-orange-700 transition-colors inline-flex items-center gap-1">
                Lihat Detail <i class="fas fa-arrow-right text-xs"></i>
              </a>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </section>
    @endif
@endsection