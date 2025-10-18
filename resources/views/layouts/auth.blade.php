<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'Login | BazaarJakartaID' }}</title>
    
    <!-- DaisyUI & Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.19/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Custom animations */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        @keyframes pulse-glow {
            0% { box-shadow: 0 0 5px rgba(251, 146, 60, 0.5); }
            50% { box-shadow: 0 0 20px rgba(251, 146, 60, 0.8); }
            100% { box-shadow: 0 0 5px rgba(251, 146, 60, 0.5); }
        }
        
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
        
        .glow-animation {
            animation: pulse-glow 2s ease-in-out infinite;
        }
        
        /* Background gradient */
        .gradient-bg {
            background: linear-gradient(135deg, #ff9a56 0%, #ff6a00 100%);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Custom input styling */
        .custom-input {
            transition: all 0.3s ease;
        }
        
        .custom-input:focus {
            border-color: #ff9a56;
            box-shadow: 0 0 0 3px rgba(251, 146, 60, 0.2);
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-base-200 min-h-screen">
    <!-- Background with pattern -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-orange-300 rounded-full mix-blend-multiply filter blur-xl opacity-20"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-orange-400 rounded-full mix-blend-multiply filter blur-xl opacity-20"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-orange-200 rounded-full mix-blend-multiply filter blur-xl opacity-20"></div>
    </div>

    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Logo Section -->
            <div class="text-center mb-8 float-animation">
                <div class="inline-flex items-center justify-center mb-4 bg-white p-4 rounded-2xl shadow-lg">
                    <img src="{{ asset('images/logo-bazaar.png') }}" alt="Bazaar Jakarta" class="h-24" />
                </div>
            </div>

            <!-- Login Card -->
            <div class="card glass-effect shadow-2xl">
                <div class="card-body p-8">
                    <!-- Success Message -->
                    @if (session('status'))
                    <div class="alert alert-success mb-6 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('status') }}</span>
                    </div>
                    @endif

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <!-- Email Field -->
                        <div class="form-control mb-6">
                            <label class="label">
                                <span class="label-text font-semibold flex items-center gap-2">
                                    <i class="fas fa-envelope text-orange-500"></i>
                                    Email Address
                                </span>
                            </label>
                            <div class="relative">
                                <input
                                    type="email"
                                    name="email"
                                    class="input input-bordered w-full custom-input pl-10 {{ $errors->has('email') ? 'input-error' : '' }}"
                                    placeholder="admin@bazaarjakarta.id"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email"
                                    autofocus
                                />
                                <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            @error('email')
                            <label class="label">
                                <span class="label-text-alt text-error flex items-center gap-1">
                                    <i class="fas fa-exclamation-triangle text-xs"></i>
                                    {{ $message }}
                                </span>
                            </label>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="form-control mb-6">
                            <label class="label">
                                <span class="label-text font-semibold flex items-center gap-2">
                                    <i class="fas fa-lock text-orange-500"></i>
                                    Password
                                </span>
                            </label>
                            <div class="relative">
                                <input
                                    type="password"
                                    name="password"
                                    class="input input-bordered w-full custom-input pl-10 pr-10 {{ $errors->has('password') ? 'input-error' : '' }}"
                                    placeholder="••••••••"
                                    required
                                    autocomplete="current-password"
                                    id="password"
                                />
                                <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400" onclick="togglePassword()">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                            @error('password')
                            <label class="label">
                                <span class="label-text-alt text-error flex items-center gap-1">
                                    <i class="fas fa-exclamation-triangle text-xs"></i>
                                    {{ $message }}
                                </span>
                            </label>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="form-control mb-6">
                            <label class="cursor-pointer label justify-start gap-2">
                                <input type="checkbox" name="remember" class="checkbox checkbox-primary" {{ old('remember') ? 'checked' : '' }} />
                                <span class="label-text">Remember me</span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-control mt-2">
                            <button type="submit" class="btn bg-orange-600 hover:bg-orange-700 text-white w-full border-none glow-animation">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Sign In
                            </button>
                        </div>
                    </form>

                    <!-- Additional Options -->
                    <div class="divider mt-6">OR</div>

                    <div class="text-center mt-4">
                        <p class="text-sm text-gray-600 mb-2">
                            Need help with your account?
                        </p>
                        <div class="flex justify-center gap-4">
                            <a href="#" class="text-orange-600 text-sm hover:underline flex items-center gap-1">
                                <i class="fas fa-question-circle"></i>
                                Forgot Password?
                            </a>
                            <a href="#" class="text-orange-600 text-sm hover:underline flex items-center gap-1">
                                <i class="fas fa-headset"></i>
                                Contact Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8 text-sm text-gray-500">
                <p>&copy; {{ date('Y') }} BazaarJakarta.ID. All rights reserved.</p>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
        
        // Auto-hide success messages after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert-success');
            alerts.forEach(alert => {
                alert.style.display = 'none';
            });
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>