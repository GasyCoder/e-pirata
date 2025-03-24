@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="font-pirate text-5xl text-yellow-500 mb-4 drop-shadow-lg">Le Trésor d'El Pirata</h1>
            <p class="text-xl text-gray-300">Assemblez vos fragments pour découvrir le trésor légendaire</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Fragments collectés -->
            <div class="card p-6">
                <h2 class="text-2xl font-pirate text-yellow-500 mb-4">Vos Fragments</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @foreach($fragments as $fragment)
                    <div class="bg-gray-700/50 p-4 rounded-lg border border-yellow-600/30">
                        <p class="font-mono text-2xl text-yellow-500 text-center">{{ $fragment }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Formulaire de validation -->
            <div class="card p-6">
                <h2 class="text-2xl font-pirate text-yellow-500 mb-4">Validation du Code</h2>
                <form action="{{ route('treasure.check') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="code" class="block text-gray-300 mb-2">
                            Entrez le code complet en assemblant vos fragments dans le bon ordre
                        </label>
                        <input type="text" id="code" name="code" required
                            class="w-full input-primary font-mono text-lg uppercase"
                            placeholder="VOTRE CODE">
                    </div>
                    <button type="submit" class="w-full btn-primary">
                        Valider le Code
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Victoire -->
<div id="victoryModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="absolute inset-0 bg-black/75"></div>
    <div class="relative bg-gray-800 rounded-lg p-8 max-w-md mx-4 transform transition-all duration-300">
        <div class="text-center">
            <div class="text-6xl mb-4">🏆</div>
            <h3 class="text-2xl font-pirate text-yellow-500 mb-4">Félicitations !</h3>
            <p class="text-gray-300 mb-6">
                Vous avez découvert le trésor d'El Pirata ! Votre nom restera à jamais dans la légende des pirates !
            </p>
            <button onclick="closeVictoryModal()" class="btn-primary w-full">
                Continuer l'Aventure
            </button>
        </div>
    </div>
</div>

<script>
function showVictoryModal() {
    const modal = document.getElementById('victoryModal');
    modal.classList.remove('hidden');
    playSound('success');
}

function closeVictoryModal() {
    const modal = document.getElementById('victoryModal');
    modal.classList.add('hidden');
}

@if(session('victory'))
    document.addEventListener('DOMContentLoaded', showVictoryModal);
@endif
</script>
@endsection
