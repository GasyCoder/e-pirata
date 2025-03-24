@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-gray-800/50 backdrop-blur-xl rounded-2xl overflow-hidden shadow-xl border border-yellow-600/30">
            <!-- Banner avec effet parallaxe -->
            <div class="relative h-48 bg-gradient-to-r from-yellow-600/20 to-purple-600/20 overflow-hidden">
                <div class="absolute inset-0 bg-[url('/images/treasure-map-bg.jpg')] bg-cover bg-center opacity-10"></div>
                <div class="absolute -bottom-16 left-8">
                    <div class="relative group">
                        @if($user->avatar)
                            <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" 
                                 class="w-32 h-32 rounded-full border-4 border-gray-800 object-cover transform group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-32 h-32 rounded-full border-4 border-gray-800 bg-yellow-600/20 flex items-center justify-center transform group-hover:scale-105 transition-transform duration-300">
                                <i class="fas fa-user text-4xl text-yellow-500"></i>
                            </div>
                        @endif
                        <a href="{{ route('profile.edit') }}" 
                           class="absolute bottom-0 right-0 bg-yellow-500 rounded-full p-2 border-2 border-gray-800 hover:bg-yellow-400 transition-colors transform hover:scale-110 duration-300">
                            <i class="fas fa-camera text-gray-900"></i>
                        </a>
                        <!-- Badge de rang -->
                        <div class="absolute -top-2 -right-2 bg-yellow-500 rounded-full p-2 border-2 border-gray-800 animate-pulse-slow">
                            <span class="text-xs font-bold text-gray-900">#{{ $user->getRank() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-20 px-8 pb-8">
                <!-- En-tête du profil -->
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-yellow-500 flex items-center gap-3">
                            {{ $user->name }}
                            @if($user->getRank() <= 3)
                                <i class="fas fa-crown text-2xl {{ $user->getRank() === 1 ? 'text-yellow-400' : ($user->getRank() === 2 ? 'text-gray-400' : 'text-yellow-700') }}"></i>
                            @endif
                        </h1>
                        <p class="text-gray-400">{{ $user->email }}</p>
                        <p class="text-sm text-gray-500 mt-1">Membre depuis {{ $user->created_at->diffForHumans() }}</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" 
                       class="px-4 py-2 bg-yellow-500 bg-opacity-20 hover:bg-opacity-30 text-yellow-300 rounded-lg transition-all duration-300 flex items-center space-x-2 border border-yellow-500/30 hover:scale-105">
                        <i class="fas fa-edit"></i>
                        <span>Modifier le profil</span>
                    </a>
                </div>

                @if($user->bio)
                    <div class="mb-8 bg-gray-700/30 rounded-xl p-6 border border-yellow-600/20">
                        <h2 class="text-xl font-semibold text-yellow-500 mb-3 flex items-center gap-2">
                            <i class="fas fa-book-open"></i>
                            À propos
                        </h2>
                        <p class="text-gray-300 italic">{{ $user->bio }}</p>
                    </div>
                @endif

                <!-- Statistiques -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Points -->
                    <div class="bg-gray-700/50 rounded-xl p-6 border border-yellow-600/30 transform hover:scale-105 transition-transform duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-semibold text-yellow-500">Points</h2>
                            <i class="fas fa-star text-2xl text-yellow-500 animate-pulse-slow"></i>
                        </div>
                        <p class="text-3xl font-bold text-gray-300">{{ number_format($user->points) }}</p>
                        <div class="mt-2 text-sm text-gray-400">
                            Points totaux accumulés
                        </div>
                    </div>

                    <!-- Rang -->
                    <div class="bg-gray-700/50 rounded-xl p-6 border border-yellow-600/30 transform hover:scale-105 transition-transform duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-semibold text-yellow-500">Classement</h2>
                            <i class="fas fa-trophy text-2xl text-yellow-500"></i>
                        </div>
                        <p class="text-3xl font-bold text-gray-300">#{{ $user->getRank() }}</p>
                        <div class="mt-2 text-sm text-gray-400">
                            Sur {{ \App\Models\User::count() }} pirates
                        </div>
                    </div>

                    <!-- Énigmes -->
                    <div class="bg-gray-700/50 rounded-xl p-6 border border-yellow-600/30 transform hover:scale-105 transition-transform duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-semibold text-yellow-500">Énigmes résolues</h2>
                            <i class="fas fa-puzzle-piece text-2xl text-yellow-500"></i>
                        </div>
                        @php
                            $completedCount = $user->enigmas()->wherePivot('completed', true)->count();
                            $totalCount = \App\Models\Enigma::count();
                            $percentage = $totalCount > 0 ? ($completedCount / $totalCount) * 100 : 0;
                        @endphp
                        <p class="text-3xl font-bold text-gray-300">{{ $completedCount }}</p>
                        <div class="mt-2">
                            <div class="w-full bg-gray-600 rounded-full h-2.5">
                                <div class="bg-yellow-500 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            <p class="text-sm text-gray-400 mt-1">{{ number_format($percentage, 1) }}% complété</p>
                        </div>
                    </div>
                </div>

                <!-- Derniers succès -->
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-yellow-500 mb-4 flex items-center gap-2">
                        <i class="fas fa-medal"></i>
                        Derniers succès
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($user->achievements()->latest()->take(3)->get() as $achievement)
                            <div class="bg-gray-700/30 rounded-lg p-4 border border-yellow-600/20 flex items-center gap-4 transform hover:scale-105 transition-transform duration-300">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-{{ $achievement->icon ?? 'trophy' }} text-yellow-500 text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-yellow-400">{{ $achievement->title }}</h3>
                                    <p class="text-sm text-gray-400">{{ $achievement->description }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-8 text-gray-400">
                                <i class="fas fa-trophy text-4xl mb-2 text-gray-600"></i>
                                <p>Aucun succès débloqué pour le moment</p>
                                <p class="text-sm mt-2">Continuez à résoudre des énigmes pour gagner des succès !</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .animate-pulse-slow {
        animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: .7; }
    }
</style>
@endpush
@endsection
