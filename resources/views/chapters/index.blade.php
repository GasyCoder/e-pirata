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
            <!-- Introduction -->
            <div class="bg-parchment bg-cover bg-center rounded-lg shadow-xl p-8 mb-8">
                <h1 class="text-4xl font-pirate text-yellow-800 mb-4 text-center">Le Journal de Bord</h1>
                <p class="text-lg text-gray-800 mb-4 font-serif italic text-center">
                    "Chaque chapitre de cette aventure vous rapprochera du trésor légendaire. 
                    Naviguez à travers les énigmes, relevez les défis et découvrez l'histoire du Capitaine Barbe-Rouge."
                </p>
            </div>

            <!-- Liste des chapitres -->
            <div class="grid gap-8">
                @foreach($chapters as $chapter)
                    @php
                        $isCompleted = $chapter->isCompletedByUser($user->id);
                        $isUnlocked = $chapter->order === 1 || 
                            $chapters->where('order', $chapter->order - 1)->first()->isCompletedByUser($user->id);
                    @endphp

                    <div class="relative">
                        <!-- Ligne de connexion -->
                        @if(!$loop->first)
                            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-4 w-1 h-8 bg-yellow-900"></div>
                        @endif

                        <!-- Carte du chapitre -->
                        <div class="bg-parchment bg-cover bg-center rounded-lg shadow-xl p-6 
                                  {{ $isUnlocked ? 'cursor-pointer transform hover:scale-105 transition-all duration-300' : 'opacity-75' }}">
                            <div class="relative">
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

                                <!-- Contenu du chapitre -->
                                <div class="mb-4">
                                    <h2 class="text-2xl font-pirate text-yellow-800 mb-2">Chapitre {{ $chapter->order }} : {{ $chapter->title }}</h2>
                                    <p class="text-gray-700">{{ $chapter->description }}</p>
                                </div>

                                <!-- Détails du chapitre -->
                                <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                                    <div>
                                        <span class="font-semibold">Location :</span> {{ $chapter->location }}
                                    </div>
                                    <div>
                                        <span class="font-semibold">Conditions :</span> {{ $chapter->weather_condition }}
                                    </div>
                                </div>

                                <!-- Progression -->
                                @if($isUnlocked)
                                    <div class="mt-4">
                                        <div class="flex justify-between items-center text-sm text-gray-600 mb-2">
                                            <span>Progression</span>
                                            <span>{{ $chapter->getPointsEarnedByUser($user->id) }} points</span>
                                        </div>
                                        <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-yellow-600 rounded-full transition-all duration-500"
                                                 style="width: {{ $isCompleted ? '100' : '0' }}%"></div>
                                        </div>
                                    </div>

                                    <!-- Bouton d'action -->
                                    <div class="mt-6 text-center">
                                        <a href="{{ route('chapters.show', $chapter) }}" 
                                           class="inline-block bg-yellow-600 hover:bg-yellow-700 text-white font-pirate 
                                                  px-6 py-3 rounded-lg transform hover:scale-105 transition-all duration-300">
                                            @if($isCompleted)
                                                Revisiter le Chapitre
                                            @else
                                                Commencer l'Aventure
                                            @endif
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
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
    });
</script>
@endpush
@endsection
