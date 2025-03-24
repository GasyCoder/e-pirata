<nav class="bg-gray-900/80 backdrop-blur-xl border-b border-yellow-600/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo et liens de navigation -->
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-pirate text-yellow-500 hover:text-yellow-400">
                        El Pirata
                    </a>
                </div>
                
                <!-- Liens de navigation -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    @auth
                        <a href="{{ route('dashboard') }}" 
                           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            Tableau de Bord
                        </a>
                        <a href="{{ route('chapters.index') }}"
                           class="nav-link {{ request()->routeIs('chapters.*') ? 'active' : '' }}">
                            Chapitres
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Menu utilisateur -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                @auth
                    <!-- Points -->
                    <div class="mr-4 flex items-center text-yellow-500">
                        <i class="fas fa-coins mr-2"></i>
                        <span>{{ number_format(auth()->user()->points) }} points</span>
                    </div>

                    <!-- Menu déroulant -->
                    <div class="ml-3 relative" x-data="{ open: false }">
                        <div>
                            <button @click="open = !open" class="flex items-center space-x-3 text-yellow-500 hover:text-yellow-400">
                                @if(auth()->user()->avatar)
                                    <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" 
                                         class="h-8 w-8 rounded-full object-cover border-2 border-yellow-500">
                                @else
                                    <div class="h-8 w-8 rounded-full bg-yellow-500/20 flex items-center justify-center border-2 border-yellow-500">
                                        <i class="fas fa-user text-yellow-500"></i>
                                    </div>
                                @endif
                                <span class="font-medium">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-sm"></i>
                            </button>
                        </div>

                        <!-- Menu déroulant -->
                        <div x-show="open" 
                             @click.away="open = false"
                             class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-gray-800 border border-yellow-600/30"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95">
                            
                            <a href="{{ route('profile.show') }}" 
                               class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-yellow-500">
                                <i class="fas fa-user-circle mr-2"></i> Mon Profil
                            </a>
                            
                            <a href="{{ route('dashboard') }}" 
                               class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-yellow-500">
                                <i class="fas fa-compass mr-2"></i> Tableau de Bord
                            </a>

                            <div class="border-t border-gray-700 my-1"></div>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-yellow-500">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-yellow-500 hover:text-yellow-400">Connexion</a>
                        <a href="{{ route('register') }}" class="text-yellow-500 hover:text-yellow-400">Inscription</a>
                    </div>
                @endauth
            </div>

            <!-- Menu mobile -->
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                 class="mobile-menu sm:hidden">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    @auth
                        <!-- Points en mobile -->
                        <div class="px-4 py-3 border-b border-gray-700 flex items-center text-yellow-500">
                            <i class="fas fa-coins mr-2"></i>
                            <span>{{ number_format(auth()->user()->points) }} points</span>
                        </div>

                        <!-- Liens de navigation mobile -->
                        <a href="{{ route('dashboard') }}" 
                           class="mobile-nav-link {{ request()->routeIs('dashboard') ? 'border-yellow-500 bg-gray-800/50' : '' }}">
                            <i class="fas fa-compass mr-2"></i>
                            Tableau de Bord
                        </a>

                        <a href="{{ route('chapters.index') }}"
                           class="mobile-nav-link {{ request()->routeIs('chapters.*') ? 'border-yellow-500 bg-gray-800/50' : '' }}">
                            <i class="fas fa-book mr-2"></i>
                            Chapitres
                        </a>

                        <a href="{{ route('profile.show') }}"
                           class="mobile-nav-link {{ request()->routeIs('profile.show') ? 'border-yellow-500 bg-gray-800/50' : '' }}">
                            <i class="fas fa-user-circle mr-2"></i>
                            Mon Profil
                        </a>

                        <!-- Déconnexion mobile -->
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="mobile-nav-link w-full text-left">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                Déconnexion
                            </button>
                        </form>
                    @else
                        <div class="px-2 space-y-1">
                            <a href="{{ route('login') }}" 
                               class="mobile-nav-link {{ request()->routeIs('login') ? 'border-yellow-500 bg-gray-800/50' : '' }}">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Connexion
                            </a>

                            <a href="{{ route('register') }}"
                               class="mobile-nav-link {{ request()->routeIs('register') ? 'border-yellow-500 bg-gray-800/50' : '' }}">
                                <i class="fas fa-user-plus mr-2"></i>
                                Inscription
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Menu mobile -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="inline-flex items-center justify-center p-2 rounded-md text-yellow-500 hover:text-yellow-400 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': mobileMenuOpen, 'inline-flex': !mobileMenuOpen }" 
                              class="inline-flex" stroke-linecap="round" 
                              stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !mobileMenuOpen, 'inline-flex': mobileMenuOpen }" 
                              class="hidden" stroke-linecap="round" 
                              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>

<style>
    .nav-link {
        @apply inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-300 hover:text-yellow-500 border-b-2 border-transparent hover:border-yellow-500;
    }
    .nav-link.active {
        @apply text-yellow-500 border-yellow-500;
    }
    .mobile-nav-link {
        @apply block px-4 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-yellow-500 border-l-4 border-transparent;
    }
</style>
