@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[url('/images/ship-bg.svg')] bg-cover bg-center bg-fixed relative overflow-hidden">
    <!-- Overlay pour l'effet de profondeur -->
    <div class="absolute inset-0 bg-blue-900/30"></div>
    
    <!-- Vagues animées -->
    <div class="absolute bottom-0 left-0 w-full">
        <div class="wave wave1"></div>
        <div class="wave wave2"></div>
        <div class="wave wave3"></div>
    </div>

    <div class="relative z-10 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- En-tête du chapitre -->
            <div class="bg-parchment bg-cover bg-center rounded-lg shadow-xl p-8 mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-4xl font-pirate text-yellow-800">Chapitre {{ $chapter->order }} : {{ $chapter->title }}</h1>
                    <a href="{{ route('chapters.index') }}" class="text-yellow-600 hover:text-yellow-700">
                        <span class="sr-only">Retour aux chapitres</span>
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                </div>

                <!-- Histoire du chapitre -->
                <div class="prose prose-lg max-w-none text-gray-800 mb-6 font-serif">
                    {!! nl2br(e($chapter->story_content)) !!}
                </div>

                <!-- Informations du chapitre -->
                <div class="grid grid-cols-2 gap-4 text-sm text-gray-600 mb-6">
                    <div>
                        <span class="font-semibold">Location :</span> {{ $chapter->location }}
                    </div>
                    <div>
                        <span class="font-semibold">Conditions :</span> {{ $chapter->weather_condition }}
                    </div>
                </div>

                <!-- Progression -->
                <div class="mb-6">
                    <div class="flex justify-between items-center text-sm text-gray-600 mb-2">
                        <span>Progression du chapitre</span>
                        <span>{{ $progress->pivot->points_earned ?? 0 }} points</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-yellow-600 rounded-full transition-all duration-500"
                             style="width: {{ ($progress && $progress->pivot->completed) ? '100' : '0' }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Mini-jeux disponibles -->
            @if($miniGames->isNotEmpty())
                <div class="bg-parchment bg-cover bg-center rounded-lg shadow-xl p-6 mb-8">
                    <h2 class="text-2xl font-pirate text-yellow-800 mb-4">Défis du Chapitre</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($miniGames as $game)
                            <div class="bg-white/80 rounded-lg p-4 shadow transform hover:scale-105 transition-all duration-300">
                                <h3 class="text-xl font-pirate text-yellow-800 mb-2">{{ $game->title }}</h3>
                                <p class="text-gray-600 mb-4">{{ $game->description }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-yellow-600">{{ $game->points_reward }} points</span>
                                    <a href="{{ route('chapters.play-mini-game', [$chapter, $game]) }}"
                                       class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg 
                                              font-pirate transform hover:scale-105 transition-all duration-300">
                                        Jouer
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Liste des énigmes -->
            <div class="bg-parchment bg-cover bg-center rounded-lg shadow-xl p-6">
                <h2 class="text-2xl font-pirate text-yellow-800 mb-4">Énigmes à Résoudre</h2>
                <div class="grid gap-6">
                    @foreach($enigmas as $enigma)
                        @php
                            $isCompleted = $enigma->isCompletedByUser(auth()->id());
                            $isUnlocked = $loop->first || 
                                $enigmas[$loop->index - 1]->isCompletedByUser(auth()->id());
                        @endphp

                        <div class="relative">
                            <!-- Ligne de connexion -->
                            @if(!$loop->first)
                                <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-4 
                                            w-1 h-8 bg-yellow-900"></div>
                            @endif

                            <!-- Carte de l'énigme -->
                            <div class="bg-white/80 rounded-lg p-6 shadow-lg 
                                      {{ $isUnlocked ? 'transform hover:scale-105 transition-all duration-300' : 'opacity-75' }}">
                                <!-- Indicateur de statut -->
                                <div class="absolute -top-4 -right-4 w-12 h-12 rounded-full flex items-center justify-center
                                            {{ $isCompleted ? 'bg-green-500' : ($isUnlocked ? 'bg-yellow-500 animate-pulse' : 'bg-gray-500') }}">
                                    @if($isCompleted)
                                        <span class="text-white text-2xl">✓</span>
                                    @elseif($isUnlocked)
                                        <span class="text-white text-2xl">→</span>
                                    @else
                                        <span class="text-white text-2xl">🔒</span>
                                    @endif
                                </div>

                                <h3 class="text-xl font-pirate text-yellow-800 mb-2">{{ $enigma->title }}</h3>
                                <p class="text-gray-600 mb-4">{{ $enigma->description }}</p>

                                @if($isUnlocked && !$isCompleted)
                                    <form action="{{ route('enigmas.validate', $enigma) }}" method="POST" class="space-y-4">
                                        @csrf
                                        <div>
                                            <label for="answer" class="block text-sm font-medium text-gray-700">
                                                Votre réponse
                                            </label>
                                            <input type="text" name="answer" id="answer"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                                          focus:border-yellow-500 focus:ring-yellow-500">
                                        </div>
                                        <button type="submit"
                                                class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 
                                                       rounded-lg font-pirate transform hover:scale-105 
                                                       transition-all duration-300">
                                            Valider
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Bouton pour compléter le chapitre -->
            @if(!($progress && $progress->pivot->completed))
                <div class="mt-8 text-center">
                    <form action="{{ route('chapters.complete', $chapter) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="bg-yellow-600 hover:bg-yellow-700 text-white px-8 py-4 rounded-lg 
                                       font-pirate text-xl transform hover:scale-105 transition-all duration-300">
                            Valider le Chapitre
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Sons d'ambiance -->
@push('scripts')
<script>
    // Chargement des sons
    const wavesSound = new Audio('/sounds/waves.mp3');
    wavesSound.loop = true;
    wavesSound.volume = 0.3;

    const successSound = new Audio('/sounds/success.mp3');
    const errorSound = new Audio('/sounds/error.mp3');

    // Jouer le son des vagues au chargement
    document.addEventListener('DOMContentLoaded', () => {
        const playSound = () => {
            wavesSound.play().catch(() => {
                console.log('Autoplay blocked');
            });
        };

        // Ajouter un bouton pour activer le son
        const soundButton = document.createElement('button');
        soundButton.innerHTML = '🔊';
        soundButton.className = 'fixed bottom-4 right-4 bg-yellow-600 text-white p-3 rounded-full shadow-lg z-50';
        soundButton.onclick = playSound;
        document.body.appendChild(soundButton);

        // Gérer les sons de succès/erreur pour les formulaires
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', () => {
                // Le son sera joué en fonction de la réponse du serveur
                setTimeout(() => {
                    const flashSuccess = document.querySelector('.alert-success');
                    if (flashSuccess) {
                        successSound.play();
                    } else {
                        errorSound.play();
                    }
                }, 500);
            });
        });
    });
</script>
@endpush
@endsection
