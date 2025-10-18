<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'Admin Dashboard | BazaarJakartaID' }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    
    <!-- DaisyUI & Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.19/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-base-200">
    <div class="drawer drawer-mobile">
        <input id="drawer-toggle" type="checkbox" class="drawer-toggle" />
        
        <!-- Drawer Content -->
        <div class="drawer-content flex flex-col">
            <!-- Navbar -->
            <div class="navbar bg-base-100 shadow-lg">
                <div class="flex-1">
                    <label for="drawer-toggle" class="btn btn-ghost drawer-button lg:hidden">
                        <i class="fas fa-bars"></i>
                    </label>
                    <a href="{{ route('admin.dashboard') }}" class=" normal-case text-xl">
                        <img src="{{ asset('images/logo-bazaar.png') }}" alt="Bazaar Jakarta" class="h-8 mr-2" />
                    </a>
                    
                    <!-- Navigation Menu -->
                    <div class="hidden lg:flex ml-8">
                        @include('admin.partials.menu')
                    </div>
                </div>
                
                <div class="flex-none gap-2">
                    <!-- Notifications -->
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="btn btn-ghost btn-circle">
                            <div class="indicator">
                                <i class="fas fa-bell"></i>
                                <span class="badge badge-xs badge-primary indicator-item">3</span>
                            </div>
                        </label>
                        <div tabindex="0" class="mt-3 z-[1] card card-compact dropdown-content w-80 bg-base-100 shadow">
                            <div class="card-body">
                                <h3 class="card-title">Notifications</h3>
                                <div class="space-y-2">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i>
                                        <div>
                                            <p class="text-sm">New event registration</p>
                                            <p class="text-xs opacity-70">2 minutes ago</p>
                                        </div>
                                    </div>
                                    <div class="alert alert-success">
                                        <i class="fas fa-check-circle"></i>
                                        <div>
                                            <p class="text-sm">Payment received</p>
                                            <p class="text-xs opacity-70">1 hour ago</p>
                                        </div>
                                    </div>
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <div>
                                            <p class="text-sm">Event starting soon</p>
                                            <p class="text-xs opacity-70">3 hours ago</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- User Menu -->
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                            <div class="w-10 rounded-full bg-orange-600 flex items-center justify-center text-white">
                                <i class="fas fa-user"></i>
                            </div>
                        </label>
                        <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                            <li>
                                <div class="justify-between">
                                    <span>{{ Auth::user()->name }}</span>
                                    <span class="badge badge-primary">Admin</span>
                                </div>
                            </li>
                            <li><a href="#"><i class="fas fa-user-circle mr-2"></i>Profile</a></li>
                            <li><a href="#"><i class="fas fa-cog mr-2"></i>Settings</a></li>
                            <li><hr class="my-1" /></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-6 h-full">
                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="footer footer-center p-4 bg-base-300 text-base-content">
                <div class="flex items-center">
                    <p>Develop By</p>
                    <a href="https://jasawebpekanbaru.com/" target="_blank" class="link link-hover text-orange-600 ml-1">Jasa Pembuatan Website</a>
                </div>
            </footer>
        </div>
        
        <!-- Sidebar -->
        <div class="drawer-side">
            <label for="drawer-toggle" class="drawer-overlay"></label>
            <aside class="w-64 min-h-full bg-base-100">
                <div class="p-4">
                    <div class="flex items-center gap-2 mb-8">
                        <img src="{{ asset('images/logo-bazaar.png') }}" alt="Bazaar Jakarta" class="h-10" />
                        <span class="font-bold text-xl text-orange-600">Admin Panel</span>
                    </div>
                    
                    <!-- User Info -->
                    <div class="card bg-base-200 shadow-sm mb-6">
                        <div class="card-body p-4">
                            <div class="flex items-center gap-3">
                                <div class="avatar">
                                    <div class="w-12 rounded-full bg-orange-600 flex items-center justify-center text-white">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-semibold">{{ Auth::user()->name }}</p>
                                    <p class="text-xs opacity-70">{{ Auth::user()->email }}</p>
                                    <div class="badge badge-primary badge-sm mt-1">Administrator</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Navigation Menu for Mobile -->
                    <div class="lg:hidden">
                        @include('admin.partials.menu')
                    </div>
                </div>
            </aside>
        </div>
    </div>
    
    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>
</html>