<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'El Pirata') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Pirata+One&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Confetti -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Styles -->
    @stack('styles')
    
    <style>
        .font-pirate {
            font-family: 'Pirata One', cursive;
        }
        
        body {
            background-color: #111827;
        }
        
        .main-content {
            position: relative;
            z-index: 10;
        }
        
        .nav-wrapper {
            position: relative;
            z-index: 20;
        }
        
        .bg-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
            background-image: url('/images/old-map-bg.png');
            opacity: 0.1;
        }
        
        /* Animations globales */
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .animate-pulse-slow {
            animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .7; }
        }
        
        /* Effet de vague */
        .wave {
            position: relative;
            overflow: hidden;
        }
        
        .wave::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            background: radial-gradient(circle at center, rgba(255,255,255,0.1) 0%, transparent 80%);
            animation: rotate 8s linear infinite;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-900">
        <!-- Navigation -->
        <div class="nav-wrapper">
            @auth
            @if(auth()->user()->hasVerifiedEmail())
            <nav class="bg-gray-800 border-b border-gray-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <a href="{{ route('dashboard') }}" class="flex items-center">
                                <img src="{{ asset('images/logo.svg') }}" alt="El Pirata" class="h-8 w-8">
                                <span class="ml-2 text-xl font-bold text-yellow-500">El Pirata</span>
                            </a>
                            <div class="ml-10 flex items-center space-x-4">
                                <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-yellow-500 px-3 py-2 rounded-md text-sm font-medium">
                                    Tableau de bord
                                </a>
                                <div class="relative ml-3">
                                    <button type="button" onclick="toggleProfileMenu()" class="flex items-center text-gray-300 hover:text-yellow-500 px-3 py-2 rounded-md text-sm font-medium">
                                        <span>Mon Profil</span>
                                        <svg class="ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div id="profileMenu" class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-gray-800 ring-1 ring-black ring-opacity-5">
                                        <div class="py-1">
                                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-yellow-500">
                                                Voir le profil
                                            </a>
                                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-yellow-500">
                                                Modifier le profil
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('chapters.index') }}" class="text-gray-300 hover:text-yellow-500 px-3 py-2 rounded-md text-sm font-medium">
                                    Chapitres
                                </a>
                                <a href="{{ route('enigmas.index') }}" class="text-gray-300 hover:text-yellow-500 px-3 py-2 rounded-md text-sm font-medium">
                                    Énigmes
                                </a>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <span class="text-gray-300 mr-4">{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-gray-300 hover:text-yellow-500 px-3 py-2 rounded-md text-sm font-medium">
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
            @endif
            @endauth
        </div>

        <!-- Background Overlay -->
        <div class="bg-overlay"></div>

        <!-- Main Content -->
        <main class="main-content">
            @yield('content')
        </main>

        <!-- Flash Messages -->
        @if(session('success'))
        <div class="fixed bottom-4 right-4 z-50">
            <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg">
                <div class="flex items-center space-x-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="absolute top-2 right-2 text-white hover:text-green-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="fixed bottom-4 right-4 z-50">
            <div class="bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg">
                <div class="flex items-center space-x-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
                <button @click="show = false" class="absolute top-2 right-2 text-white hover:text-red-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif
    </div>

    @stack('scripts')
    
    <script>
        function toggleProfileMenu() {
            const menu = document.getElementById('profileMenu');
            menu.classList.toggle('hidden');
        }

        // Fermer le menu si on clique en dehors
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('profileMenu');
            const button = event.target.closest('button');
            
            if (!button && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
