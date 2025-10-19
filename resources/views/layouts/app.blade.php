<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    
    <title>{{ $title ?? 'BazaarJakartaID | Your Partner Event' }}</title>
    
    <!-- Meta Description -->
    @if(isset($metaDescription))
    <meta name="description" content="{{ e($metaDescription) }}">
    @else
    <meta name="description" content="{{ e(\App\Models\Setting::getValue('seo_description', 'Bazaar Jakarta adalah platform bazaar online terbesar di Jakarta untuk jual beli produk lokal dan event komunitas. Temukan produk unik dan ikuti event menarik di kota Anda.')) }}">
    @endif
    
    <!-- Meta Keywords -->
    @if(isset($metaKeywords))
    <meta name="keywords" content="{{ e($metaKeywords) }}">
    @else
    <meta name="keywords" content="{{ e(\App\Models\Setting::getValue('seo_keywords', 'Bazaar Jakarta, Event Bazaar, Jual Beli, UMKM, Pasar Lokal, Komunitas')) }}">
    @endif
    
    <!-- Sitemap -->
    <link rel="sitemap" type="application/xml" href="{{ url('/sitemap.xml') }}">
    
    <!-- Google Site Verification -->
    @php
        $googleSiteVerification = \App\Models\Setting::getValue('google_site_verification');
    @endphp
    @if($googleSiteVerification)
    <meta name="google-site-verification" content="{{ e($googleSiteVerification) }}" />
    @endif
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              'poppins': ['Poppins', 'sans-serif'],
            },
            animation: {
              'fade-in': 'fadeIn 0.8s ease-out',
            },
            keyframes: {
              fadeIn: {
                '0%': { opacity: '0', transform: 'translateY(20px)' },
                '100%': { opacity: '1', transform: 'translateY(0)' },
              }
            }
          }
        }
      }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @stack('styles')
  </head>
  <body class="bg-gray-50 text-gray-800 font-poppins">

    <!-- HEADER -->
    <header class="bg-gradient-to-r from-orange-600 to-orange-700 text-white shadow-lg sticky top-0 z-50">
      <div class="container mx-auto flex justify-between items-center py-4 px-4 md:px-8">
        <a href="{{ url('/') }}" class="flex items-center gap-2 transition-transform hover:scale-105">
          <img src="{{ asset('images/logo-bazaar-white.png') }}" alt="Bazaar Jakarta" class="h-12" />
        </a>
        <nav class="hidden md:flex gap-6 font-semibold">
          @forelse($frontendMenus ?? [] as $menu)
            @if($menu->children->count() > 0)
              <!-- Parent Menu with Children -->
              <div class="relative group">
                <button class="hover:text-yellow-200 transition-colors duration-300 relative group flex items-center gap-1 {{ request()->is(ltrim($menu->url, '/')) || request()->is(ltrim($menu->url, '/*')) ? 'text-yellow-200' : '' }}">
                  {{ e($menu->title) }}
                  <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-yellow-200 transition-all duration-300 group-hover:w-full {{ request()->is(ltrim($menu->url, '/')) || request()->is(ltrim($menu->url, '/*')) ? 'w-full' : '' }}"></span>
                  <i class="fas fa-chevron-down text-xs transition-transform duration-300 group-hover:rotate-180"></i>
                </button>
                <div class="absolute top-full left-0 mt-2 w-48 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                  <div class="py-2">
                    @foreach($menu->children as $child)
                      <a href="{{ e($child->url) }}" class="block px-4 py-2 text-sm text-gray-800 hover:bg-orange-50 hover:text-orange-600 transition-colors {{ request()->is(ltrim($child->url, '/')) || request()->is(ltrim($child->url, '/*')) ? 'bg-orange-50 text-orange-600' : '' }}">
                        {{ e($child->title) }}
                      </a>
                    @endforeach
                  </div>
                </div>
              </div>
            @else
              <!-- Single Menu Item -->
              <a href="{{ e($menu->url) }}" class="hover:text-yellow-200 transition-colors duration-300 relative group {{ request()->is(ltrim($menu->url, '/')) || request()->is(ltrim($menu->url, '/*')) ? 'text-yellow-200' : '' }}">
                {{ e($menu->title) }}
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-yellow-200 transition-all duration-300 group-hover:w-full {{ request()->is(ltrim($menu->url, '/')) || request()->is(ltrim($menu->url, '/*')) ? 'w-full' : '' }}"></span>
              </a>
            @endif
          @empty
            <a href="{{ url('/') }}" class="hover:text-yellow-200 transition-colors duration-300 relative group {{ request()->is('/') ? 'text-yellow-200' : '' }}">
              Home
              <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-yellow-200 transition-all duration-300 group-hover:w-full {{ request()->is('/') ? 'w-full' : '' }}"></span>
            </a>
            <a href="#" class="hover:text-yellow-200 transition-colors duration-300 relative group">
              Company Profil
              <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-yellow-200 transition-all duration-300 group-hover:w-full"></span>
            </a>
            <a href="#" class="hover:text-yellow-200 transition-colors duration-300 relative group">
              Event
              <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-yellow-200 transition-all duration-300 group-hover:w-full"></span>
            </a>
            <a href="#" class="hover:text-yellow-200 transition-colors duration-300 relative group">
              Contact Us
              <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-yellow-200 transition-all duration-300 group-hover:w-full"></span>
            </a>
          @endforelse
          <!-- Search Form -->
          <form action="{{ route('events.search') }}" method="GET" class="flex items-center">
            <div class="relative">
              <input type="text" name="q" placeholder="Cari event..."
                     class="search-input px-4 py-2 pr-10 rounded-lg text-gray-800 w-48 focus:outline-none focus:ring-2 focus:ring-yellow-300 transition-all duration-300 focus:w-56">
              <button type="submit" class="absolute right-0 top-0 h-full px-3 text-orange-600 hover:text-orange-700">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </form>
        </nav>
        <!-- Mobile menu button -->
        <button class="md:hidden text-white focus:outline-none" id="mobile-menu-button">
          <i class="fas fa-bars text-2xl"></i>
        </button>
      </div>
      <!-- Mobile menu -->
      <div class="hidden md:hidden bg-orange-700 px-4 py-3" id="mobile-menu">
        <nav class="flex flex-col gap-3 font-semibold">
          @forelse($frontendMenus ?? [] as $menu)
            @if($menu->children->count() > 0)
              <!-- Parent Menu with Children -->
              <div class="relative">
                <button onclick="toggleMobileMenu('{{ $menu->id }}')" class="hover:text-yellow-200 transition-colors duration-300 cursor-pointer flex items-center justify-between w-full text-left">
                  {{ e($menu->title) }}
                  <i id="icon-{{ $menu->id }}" class="fas fa-chevron-down text-xs transition-transform duration-300"></i>
                </button>
                <div id="mobile-menu-{{ $menu->id }}" class="hidden pl-4 mt-2 space-y-2">
                  @foreach($menu->children as $child)
                    <a href="{{ e($child->url) }}" class="block py-1 text-sm hover:text-yellow-200 transition-colors">
                      {{ e($child->title) }}
                    </a>
                  @endforeach
                </div>
              </div>
            @else
              <!-- Single Menu Item -->
              <a href="{{ e($menu->url) }}" class="hover:text-yellow-200 transition-colors duration-300">
                {{ e($menu->title) }}
              </a>
            @endif
          @empty
            <a href="{{ url('/') }}" class="hover:text-yellow-200 transition-colors duration-300">Home</a>
            <a href="#" class="hover:text-yellow-200 transition-colors duration-300">Company Profil</a>
            <a href="#" class="hover:text-yellow-200 transition-colors duration-300">Event</a>
            <a href="#" class="hover:text-yellow-200 transition-colors duration-300">Contact Us</a>
          @endforelse
          <!-- Mobile Search Form -->
          <form action="{{ route('events.search') }}" method="GET" class="mb-3">
            <div class="relative">
              <input type="text" name="q" placeholder="Cari event..."
                     class="search-input w-full px-4 py-2 pr-10 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-yellow-300 transition-all duration-300">
              <button type="submit" class="absolute right-0 top-0 h-full px-3 text-orange-600 hover:text-orange-700">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </form>
        </nav>
      </div>
    </header>

    <!-- MAIN CONTENT -->
    <main>
      @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-gradient-to-r from-orange-600 to-orange-700 text-white">
      <div class="container mx-auto px-4 md:px-8 py-8">
        <div class="grid md:grid-cols-4 gap-8">
          <div class="md:col-span-2">
            <div class="flex items-center gap-2 mb-4">
              <img src="{{ asset('images/logo-bazaar-white.png') }}" alt="Logo Bazaar Jakarta" class="h-10" />
            </div>
            <p class="text-sm leading-relaxed mb-4">
              BazaarJakarta.id di bawah PT. Kreatif Jakarta Indotama adalah perusahaan di bidang event organizer, event production, sewa tenda, digital campaign, expo, concert, corporate event, dan kegiatan kreatif lainnya.
            </p>
            <div class="flex gap-3">
              @if(isset($socialMedia['facebook']) && $socialMedia['facebook'] !== '#')
              <a href="{{ e($socialMedia['facebook']) }}" target="_blank" rel="noopener noreferrer" class="bg-white/20 hover:bg-white/30 w-10 h-10 rounded-full flex items-center justify-center transition-colors">
                <i class="fab fa-facebook-f"></i>
              </a>
              @endif
              @if(isset($socialMedia['instagram']) && $socialMedia['instagram'] !== '#')
              <a href="{{ e($socialMedia['instagram']) }}" target="_blank" rel="noopener noreferrer" class="bg-white/20 hover:bg-white/30 w-10 h-10 rounded-full flex items-center justify-center transition-colors">
                <i class="fab fa-instagram"></i>
              </a>
              @endif
              @if(isset($socialMedia['youtube']) && $socialMedia['youtube'] !== '#')
              <a href="{{ e($socialMedia['youtube']) }}" target="_blank" rel="noopener noreferrer" class="bg-white/20 hover:bg-white/30 w-10 h-10 rounded-full flex items-center justify-center transition-colors">
                <i class="fab fa-youtube"></i>
              </a>
              @endif
              @if(isset($socialMedia['tiktok']) && $socialMedia['tiktok'] !== '#')
              <a href="{{ e($socialMedia['tiktok']) }}" target="_blank" rel="noopener noreferrer" class="bg-white/20 hover:bg-white/30 w-10 h-10 rounded-full flex items-center justify-center transition-colors">
                <i class="fab fa-tiktok"></i>
              </a>
              @endif
            </div>
          </div>
          <div>
            <h3 class="font-bold text-lg mb-4">Quick Links</h3>
            <ul class="space-y-2 text-sm">
              <li><a href="{{ url('/') }}" class="hover:text-yellow-200 transition-colors">Home</a></li>
              <li><a href="#" class="hover:text-yellow-200 transition-colors">Tentang Kami</a></li>
              <li><a href="#" class="hover:text-yellow-200 transition-colors">Layanan</a></li>
              <li><a href="#" class="hover:text-yellow-200 transition-colors">Portfolio</a></li>
            </ul>
          </div>
          <div>
            <h3 class="font-bold text-lg mb-4">Kontak</h3>
            <ul class="space-y-2 text-sm">
              <li class="flex items-start gap-2">
                <i class="fas fa-map-marker-alt mt-1 text-yellow-200"></i>
                <span>PT. Kreatif Jakarta Indotama<br>Palmer Cine Jl. Raya Rambu Auas, Kota Jakarta.</span>
              </li>
              <li class="flex items-center gap-2">
                <i class="fas fa-phone text-yellow-200"></i>
                <span>+62 21 1234 5678</span>
              </li>
              <li class="flex items-center gap-2">
                <i class="fas fa-envelope text-yellow-200"></i>
                <span>info@bazaarjakarta.id</span>
              </li>
            </ul>
          </div>
        </div>
        <div class="border-t border-orange-400 mt-8 pt-8 text-center text-sm">
          <p>© <a href="https://bazaarjakarta.id/" class="text-yellow-200 hover:text-white transition-colors">Bazaar Jakarta</a> 2025 | <a href="https://jasawebpekanbaru.com/" class="text-yellow-200 hover:text-white transition-colors">Jasa Pembuatan Website</a></p>
        </div>
      </div>
    </footer>

    <!-- BACK TO TOP BUTTON -->
    <button id="backToTop" class="fixed bottom-8 right-8 bg-orange-600 text-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center opacity-0 invisible transition-all duration-300 hover:bg-orange-700 z-40">
      <i class="fas fa-arrow-up"></i>
    </button>

    <!-- FLOATING WHATSAPP BUTTON -->
    @if(isset($whatsappNumber) && $whatsappNumber)
    <a href="https://wa.me/{{ preg_replace('/[^0-9+]/', '', htmlspecialchars($whatsappNumber, ENT_QUOTES, 'UTF-8')) }}?text=Halo%20BazaarJakarta.ID,%20saya%20ingin%20bertanya%20tentang%20event%20anda"
       target="_blank"
       rel="noopener noreferrer"
       class="fixed bottom-8 right-20 bg-green-500 text-white w-14 h-14 rounded-full shadow-lg flex items-center justify-center transition-all duration-300 hover:bg-green-600 hover:scale-110 z-40 animate-pulse">
      <i class="fab fa-whatsapp text-2xl"></i>
    </a>
    @endif

    <!-- JAVASCRIPT -->
    <script>
      // Mobile menu toggle
      const mobileMenuButton = document.getElementById('mobile-menu-button');
      const mobileMenu = document.getElementById('mobile-menu');
      
      mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
      });
      
      // Mobile submenu toggle
      function toggleMobileMenu(menuId) {
        const submenu = document.getElementById(`mobile-menu-${menuId}`);
        const icon = document.getElementById(`icon-${menuId}`);
        
        submenu.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
      }
      
      // Make function globally available
      window.toggleMobileMenu = toggleMobileMenu;
      
      // Back to top button
      const backToTopButton = document.getElementById('backToTop');
      
      window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
          backToTopButton.classList.remove('opacity-0', 'invisible');
          backToTopButton.classList.add('opacity-100', 'visible');
        } else {
          backToTopButton.classList.add('opacity-0', 'invisible');
          backToTopButton.classList.remove('opacity-100', 'visible');
        }
      });
      
      backToTopButton.addEventListener('click', () => {
        window.scrollTo({
          top: 0,
          behavior: 'smooth'
        });
      });
      
      // Add animation on scroll
      const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
      };
      
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('animate-fade-in');
          }
        });
      }, observerOptions);
      
      // Observe all sections
      document.querySelectorAll('section').forEach(section => {
        observer.observe(section);
      });
      
      // Search input focus effect
      const searchInputs = document.querySelectorAll('.search-input');
      searchInputs.forEach(input => {
        input.addEventListener('focus', function() {
          this.parentElement.classList.add('scale-105');
        });
        
        input.addEventListener('blur', function() {
          this.parentElement.classList.remove('scale-105');
        });
      });
    </script>
    
    @stack('scripts')
  </body>
</html>