@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[url('/images/ship-bg.svg')] bg-cover bg-center bg-fixed relative overflow-hidden">
    <!-- Overlay pour l'effet de profondeur -->
    <div class="absolute inset-0 bg-blue-900/30"></div>
    
    <div class="relative z-10 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- En-tête du jeu -->
            <div class="bg-parchment bg-cover bg-center rounded-lg shadow-xl p-6 mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-3xl font-pirate text-yellow-800">{{ $miniGame->title }}</h1>
                    <div class="text-xl font-pirate text-yellow-600">
                        Temps: <span id="timer">{{ $gameData['time_limit'] }}</span>s
                    </div>
                </div>
                <p class="text-gray-700 mb-4">{{ $miniGame->description }}</p>
                <div class="flex justify-between items-center text-sm text-gray-600">
                    <div>Paires trouvées: <span id="pairs-found">0</span>/{{ $gameData['pairs_count'] }}</div>
                    <div>Points possibles: {{ $miniGame->points_reward }}</div>
                </div>
            </div>

            <!-- Grille de jeu -->
            <div class="grid grid-cols-4 gap-4 mb-8" id="game-grid">
                @foreach($gameData['cards'] as $index => $card)
                    <div class="memory-card" data-card-id="{{ $index }}">
                        <div class="card-inner">
                            <div class="card-front bg-parchment bg-cover bg-center rounded-lg shadow-xl p-4 
                                        aspect-square flex items-center justify-center cursor-pointer 
                                        transform hover:scale-105 transition-all duration-300">
                                <svg class="w-12 h-12 text-yellow-800" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zM5.172 9l2.828-2.828L10.828 9l-2.828 2.828L5.172 9zm6.828 0l2.828-2.828L17.656 9l-2.828 2.828L12 9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="card-back bg-parchment bg-cover bg-center rounded-lg shadow-xl p-4 
                                       aspect-square flex items-center justify-center">
                                <img src="{{ $card['image'] }}" alt="{{ $card['name'] }}" class="w-full h-full object-contain">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Actions -->
            <div class="text-center space-x-4">
                <button id="restart-game" 
                        class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-3 rounded-lg 
                               font-pirate transform hover:scale-105 transition-all duration-300">
                    Recommencer
                </button>
                <a href="{{ route('chapters.show', $miniGame->chapter) }}" 
                   class="inline-block bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg 
                          font-pirate transform hover:scale-105 transition-all duration-300">
                    Quitter
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .memory-card {
        perspective: 1000px;
    }

    .card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        text-align: center;
        transition: transform 0.8s;
        transform-style: preserve-3d;
    }

    .memory-card.flipped .card-inner {
        transform: rotateY(180deg);
    }

    .card-front,
    .card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
    }

    .card-back {
        transform: rotateY(180deg);
    }

    .disabled {
        pointer-events: none;
        opacity: 0.7;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        let hasFlippedCard = false;
        let lockBoard = false;
        let firstCard, secondCard;
        let pairsFound = 0;
        let timeLeft = {{ $gameData['time_limit'] }};
        let timerInterval;

        const cards = document.querySelectorAll('.memory-card');
        const timerDisplay = document.getElementById('timer');
        const pairsFoundDisplay = document.getElementById('pairs-found');
        const restartButton = document.getElementById('restart-game');

        function flipCard() {
            if (lockBoard) return;
            if (this === firstCard) return;

            this.classList.add('flipped');

            if (!hasFlippedCard) {
                hasFlippedCard = true;
                firstCard = this;
                return;
            }

            secondCard = this;
            checkForMatch();
        }

        function checkForMatch() {
            const isMatch = firstCard.dataset.cardId === secondCard.dataset.cardId;
            isMatch ? disableCards() : unflipCards();
        }

        function disableCards() {
            firstCard.removeEventListener('click', flipCard);
            secondCard.removeEventListener('click', flipCard);
            pairsFound++;
            pairsFoundDisplay.textContent = pairsFound;

            if (pairsFound === {{ $gameData['pairs_count'] }}) {
                gameWon();
            }

            resetBoard();
        }

        function unflipCards() {
            lockBoard = true;

            setTimeout(() => {
                firstCard.classList.remove('flipped');
                secondCard.classList.remove('flipped');
                resetBoard();
            }, 1500);
        }

        function resetBoard() {
            [hasFlippedCard, lockBoard] = [false, false];
            [firstCard, secondCard] = [null, null];
        }

        function shuffle() {
            cards.forEach(card => {
                let randomPos = Math.floor(Math.random() * cards.length);
                card.style.order = randomPos;
            });
        }

        function startTimer() {
            timerInterval = setInterval(() => {
                timeLeft--;
                timerDisplay.textContent = timeLeft;

                if (timeLeft <= 0) {
                    gameLost();
                }
            }, 1000);
        }

        function gameWon() {
            clearInterval(timerInterval);
            // Envoyer le score au serveur
            fetch('{{ route("mini-games.complete", $miniGame) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    timeLeft: timeLeft,
                    pairsFound: pairsFound
                })
            }).then(response => response.json())
              .then(data => {
                  if (data.success) {
                      alert(`Félicitations ! Vous avez gagné ${data.points} points !`);
                      window.location.href = '{{ route("chapters.show", $miniGame->chapter) }}';
                  }
              });
        }

        function gameLost() {
            clearInterval(timerInterval);
            alert('Temps écoulé ! Essayez encore !');
            resetGame();
        }

        function resetGame() {
            clearInterval(timerInterval);
            timeLeft = {{ $gameData['time_limit'] }};
            pairsFound = 0;
            pairsFoundDisplay.textContent = pairsFound;
            timerDisplay.textContent = timeLeft;

            cards.forEach(card => {
                card.classList.remove('flipped');
                card.addEventListener('click', flipCard);
            });

            shuffle();
            startTimer();
        }

        // Initialisation
        cards.forEach(card => card.addEventListener('click', flipCard));
        restartButton.addEventListener('click', resetGame);
        shuffle();
        startTimer();
    });
</script>
@endpush
@endsection
