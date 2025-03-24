@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-900 via-purple-900 to-gray-900 py-12 relative overflow-hidden">
    <!-- Effets de fond animés -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute w-full h-full bg-[url('/images/map-bg.png')] opacity-10"></div>
        <div class="absolute top-0 left-0 w-full h-full">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
            <div class="absolute top-1/3 right-1/4 w-96 h-96 bg-yellow-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-1/4 left-1/3 w-96 h-96 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- En-tête -->
        <div class="text-center mb-12">
            <h1 class="text-5xl md:text-6xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-red-400 to-purple-500 mb-4 font-pirate tracking-wider animate-title">
                Les Énigmes du Capitaine
            </h1>
            <p class="text-xl text-gray-300 font-pirate">Résolvez les mystères pour découvrir le trésor caché</p>
        </div>

        <!-- Filtres et recherche -->
        <div class="mb-8 flex flex-col sm:flex-row justify-between items-center gap-4">
            <!-- Filtres de statut -->
            <div class="flex items-center space-x-4">
                <a href="{{ request()->fullUrlWithQuery(['filter' => null]) }}" 
                   class="px-4 py-2 rounded-lg {{ !request('filter') ? 'bg-yellow-600 text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
                    Toutes
                </a>
                <a href="{{ request()->fullUrlWithQuery(['filter' => 'non-resolues']) }}" 
                   class="px-4 py-2 rounded-lg {{ request('filter') === 'non-resolues' ? 'bg-yellow-600 text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
                    Non résolues
                </a>
                <a href="{{ request()->fullUrlWithQuery(['filter' => 'completees']) }}" 
                   class="px-4 py-2 rounded-lg {{ request('filter') === 'completees' ? 'bg-yellow-600 text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700' }}">
                    Complétées
                </a>
            </div>

            <!-- Filtre par chapitre -->
            <div class="relative">
                <select onchange="window.location.href=this.value" 
                        class="bg-gray-800 text-gray-300 rounded-lg px-4 py-2 pr-8 appearance-none cursor-pointer hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-yellow-600">
                    <option value="{{ request()->fullUrlWithQuery(['chapter' => null]) }}" {{ !request('chapter') ? 'selected' : '' }}>
                        Tous les chapitres
                    </option>
                    @foreach($chapters as $chapter)
                        <option value="{{ request()->fullUrlWithQuery(['chapter' => $chapter->id]) }}" 
                                {{ request('chapter') == $chapter->id ? 'selected' : '' }}>
                            {{ $chapter->title }}
                        </option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Grille des énigmes -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($enigmas as $enigma)
                @php
                    $progress = $enigma->userProgress()->where('user_id', auth()->id())->first();
                    $isCompleted = $progress && $progress->completed;
                    $attemptsCount = $progress ? $progress->attempts : 0;
                    $hintsUsed = $progress ? $progress->hints_used : 0;
                @endphp

                <div class="bg-gray-800/90 backdrop-blur-xl rounded-xl p-4 shadow-xl border-2 {{ $isCompleted ? 'border-green-600/30' : 'border-yellow-600/30' }} relative overflow-hidden group">
                    <!-- Indicateur de complétion -->
                    @if($isCompleted)
                        <div class="absolute top-3 right-3">
                            <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        </div>
                    @endif

                    <!-- Image de l'énigme -->
                    <div class="w-full h-32 mb-4 overflow-hidden rounded-lg bg-gray-700/50 flex items-center justify-center p-4">
                        @php
                            $images = [
                                'mysterious-map', 'compass', 'ship', 'chest', 'skull',
                                'parrot', 'telescope', 'anchor', 'rum', 'sword',
                                'wheel', 'key', 'hourglass'
                            ];
                            // Utiliser une image spécifique pour l'énigme de la carte mystérieuse
                            $image = $enigma->title === 'La Carte Mystérieuse' ? 'mysterious-map' : $images[$enigma->id % count($images)];
                        @endphp
                        <img src="{{ asset('images/enigmas/' . $image . '.svg') }}" 
                             alt="Image de l'énigme" 
                             class="w-full h-full object-contain transform group-hover:scale-110 transition-transform duration-300">
                    </div>

                    <!-- Titre et description -->
                    <div class="space-y-2">
                        <h3 class="text-xl font-bold text-yellow-500">{{ $enigma->title }}</h3>
                        <p class="text-gray-400 text-sm line-clamp-2">{{ $enigma->description }}</p>
                    </div>

                    <!-- Points et difficulté -->
                    <div class="flex justify-between items-center mt-3">
                        <span class="text-yellow-500 font-semibold">{{ $enigma->points }} points</span>
                        <span class="text-gray-400">
                            Difficulté : {!! str_repeat('⭐', $enigma->difficulty) !!}
                        </span>
                    </div>

                    <!-- Statistiques -->
                    <div class="flex justify-between text-sm text-gray-400 mt-3">
                        <span><i class="fas fa-redo-alt mr-1"></i> {{ $attemptsCount }} essais</span>
                        <span><i class="fas fa-lightbulb mr-1"></i> {{ $hintsUsed }} indices</span>
                    </div>

                    <!-- Lien vers l'énigme -->
                    <a href="{{ route('enigmas.show', $enigma) }}" 
                       class="absolute inset-0 w-full h-full opacity-0">
                        <span class="sr-only">Voir l'énigme</span>
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            <div class="inline-block bg-gray-800/90 backdrop-blur-xl rounded-xl p-4 shadow-xl border-2 border-yellow-600/30">
                {{ $enigmas->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Animation des blobs */
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    
    .animate-blob {
        animation: blob 7s infinite;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    .animation-delay-4000 {
        animation-delay: 4s;
    }

    /* Animation du titre */
    @keyframes title {
        0% { transform: translateY(-20px); opacity: 0; }
        100% { transform: translateY(0); opacity: 1; }
    }

    .animate-title {
        animation: title 1s ease-out forwards;
    }

    /* Effet de brillance */
    .card-shine {
        position: absolute;
        top: 0;
        left: -100%;
        width: 50%;
        height: 100%;
        background: linear-gradient(
            90deg,
            transparent,
            rgba(255, 255, 255, 0.1),
            transparent
        );
        transition: 0.5s;
    }

    .group:hover .card-shine {
        left: 100%;
    }
</style>
@endpush
@endsection
