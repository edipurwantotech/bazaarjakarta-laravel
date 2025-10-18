<div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
  <div class="relative h-64 overflow-hidden">
    @if($event->thumbnail)
      <img src="{{ asset('storage/' . $event->thumbnail) }}" alt="{{ $event->title }}" class="w-full h-full object-cover" />
    @else
      <div class="absolute inset-0 bg-gradient-to-br {{ $index % 3 == 0 ? 'from-orange-400 to-orange-600' : ($index % 3 == 1 ? 'from-purple-400 to-pink-600' : 'from-green-400 to-blue-600') }}"></div>
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
    @if($event->categories->isNotEmpty())
      <a href="{{ route('events.category', $event->categories->first()->slug) }}" class="absolute top-4 left-4 bg-{{ $index % 3 == 0 ? 'orange' : ($index % 3 == 1 ? 'purple' : 'green') }}-500 text-white text-xs px-3 py-1 rounded-full hover:opacity-80 transition-opacity">
        {{ $event->categories->first()->name }}
      </a>
    @else
      <span class="absolute top-4 left-4 bg-orange-500 text-white text-xs px-3 py-1 rounded-full">Event</span>
    @endif
    <div class="absolute bottom-4 left-4 text-white">
      <p class="text-sm font-semibold"><i class="far fa-calendar mr-2"></i>{{ $event->start_date->format('d F Y') }} @if($event->end_date && $event->end_date->format('Y-m-d') !== $event->start_date->format('Y-m-d'))- {{ $event->end_date->format('d F Y') }}@endif</p>
      @if($event->location)
        <p class="text-xs"><i class="fas fa-map-marker-alt mr-2"></i>{{ $event->location }}</p>
      @endif
    </div>
  </div>
  <div class="p-6">
    <h3 class="text-orange-600 font-bold text-xl mb-3">{{ $event->title }}</h3>
    <p class="text-gray-600 text-sm mb-4">{!! Str::limit($event->description, 100) !!}</p>
    <div class="flex justify-between items-center">
      <a href="{{ route('event.detail', $event->slug) }}" class="text-orange-600 font-semibold text-sm hover:text-orange-700 transition-colors inline-flex items-center gap-1">
        SELENGKAPNYA <i class="fas fa-arrow-right text-xs"></i>
      </a>
      <div class="flex gap-2">
        <a href="#" class="text-gray-400 hover:text-blue-500 transition-colors">
          <i class="fab fa-facebook text-lg"></i>
        </a>
        <a href="#" class="text-gray-400 hover:text-pink-500 transition-colors">
          <i class="fab fa-instagram text-lg"></i>
        </a>
      </div>
    </div>
  </div>
</div>