@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="relative group perspective-1000">
            <!-- Carte face avant (énigme) -->
            <div class="relative z-10 bg-gray-800/90 rounded-xl shadow-xl border-2 border-yellow-600/30 p-8 transform transition-transform duration-1000 preserve-3d group-hover:rotate-y-180 min-h-[500px]">
                <div class="flex flex-col items-center">
                    <h2 class="text-3xl font-pirate text-yellow-500 mb-6">{{ $enigma->title }}</h2>
                    <p class="text-gray-300 text-lg mb-8">{{ $enigma->description }}</p>

                    <form action="{{ route('enigmas.verify', $enigma) }}" method="POST" class="w-full max-w-md">
                        @csrf
                        <div class="mb-6">
                            <label for="answer" class="block text-sm font-medium text-yellow-500 mb-2">Votre réponse</label>
                            <input type="text" name="answer" id="answer" required
                                   class="w-full px-4 py-2 bg-gray-700 border-2 border-yellow-600/30 rounded-lg
                                          text-gray-100 placeholder-gray-400
                                          focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                        </div>

                        @if ($errors->any())
                            <div class="mb-4 p-4 bg-red-500/10 border border-red-500 rounded-lg">
                                @foreach ($errors->all() as $error)
                                    <p class="text-red-500">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <div class="flex justify-between items-center">
                            <button type="submit"
                                    class="px-6 py-3 bg-yellow-500 text-gray-900 rounded-lg font-semibold
                                           hover:bg-yellow-400 transition-colors duration-300">
                                Valider
                            </button>
                            
                            <a href="{{ route('enigmas.hint', $enigma) }}"
                               class="px-6 py-3 bg-gray-700 text-yellow-500 rounded-lg font-semibold
                                      hover:bg-gray-600 transition-colors duration-300">
                                Indice (-5 points)
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Carte face arrière (image) -->
            <div class="absolute inset-0 bg-gray-800/90 rounded-xl shadow-xl border-2 border-yellow-600/30 p-8
                        transform rotate-y-180 backface-hidden">
                <div class="w-full h-full flex items-center justify-center">
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
                         alt="Illustration de l'énigme" 
                         class="w-full h-full object-contain">
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.perspective-1000 {
    perspective: 1000px;
}

.preserve-3d {
    transform-style: preserve-3d;
}

.backface-hidden {
    backface-visibility: hidden;
}

.rotate-y-180 {
    transform: rotateY(180deg);
}

.group:hover .group-hover\:rotate-y-180 {
    transform: rotateY(180deg);
}
</style>
@endsection
