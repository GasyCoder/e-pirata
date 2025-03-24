@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="font-pirate text-5xl text-yellow-500 mb-4 drop-shadow-lg">Tableau de Bord</h1>
            <p class="text-xl text-gray-300">Suivez votre progression dans l'aventure d'El Pirata</p>
        </div>

        <!-- Statistiques principales -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Carte de Progression -->
            <div class="card p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-pirate text-yellow-500">Progression</h2>
                    <i class="fas fa-chart-line text-3xl text-yellow-500"></i>
                </div>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm text-gray-300 mb-2">
                            <span>Énigmes complétées</span>
                            <span>{{ number_format($enigmaProgress, 0) }}%</span>
                        </div>
                        <div class="h-2 bg-gray-700/50 rounded-full">
                            <div class="h-2 bg-yellow-500 rounded-full" style="width: {{ $enigmaProgress }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm text-gray-300 mb-2">
                            <span>Chapitres terminés</span>
                            <span>{{ number_format($chapterProgress, 0) }}%</span>
                        </div>
                        <div class="h-2 bg-gray-700/50 rounded-full">
                            <div class="h-2 bg-yellow-500 rounded-full" style="width: {{ $chapterProgress }}%"></div>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="grid grid-cols-2 gap-4 text-center">
                            <div class="bg-gray-700/50 rounded-lg p-2">
                                <div class="text-yellow-500 text-lg">{{ $totalEnigmasCompleted }}</div>
                                <div class="text-gray-400 text-sm">Énigmes résolues</div>
                            </div>
                            <div class="bg-gray-700/50 rounded-lg p-2">
                                <div class="text-yellow-500 text-lg">{{ $totalHintsUsed }}</div>
                                <div class="text-gray-400 text-sm">Indices utilisés</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carte de Classement -->
            <div class="card p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-pirate text-yellow-500">Classement</h2>
                    <i class="fas fa-trophy text-3xl text-yellow-500"></i>
                </div>
                <div class="text-center mb-6">
                    <div class="text-5xl font-pirate text-yellow-500 mb-2">
                        #{{ $userRank }}
                    </div>
                    <div class="text-xl text-gray-300">
                        {{ number_format($totalPoints) }} points
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="bg-gray-700/50 rounded-lg p-3">
                        <div class="flex justify-between items-center text-gray-300">
                            <span>Meilleure série</span>
                            <span class="text-yellow-500">{{ $bestStreak }} énigmes</span>
                        </div>
                    </div>
                    <div class="bg-gray-700/50 rounded-lg p-3">
                        <div class="flex justify-between items-center text-gray-300">
                            <span>Temps de jeu</span>
                            <span class="text-yellow-500">{{ $playTime }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carte des Récompenses -->
            <div class="card p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-pirate text-yellow-500">Récompenses</h2>
                    <i class="fas fa-medal text-3xl text-yellow-500"></i>
                </div>
                <div class="space-y-3">
                    @foreach($recentAchievements as $achievement)
                    <div class="bg-gray-700/50 p-3 rounded-lg border border-yellow-600/30 group hover:bg-gray-600/50 transition-all duration-300">
                        <div class="flex items-center">
                            <i class="fas {{ $achievement->icon }} text-yellow-500 mr-3 group-hover:scale-110 transition-all duration-300"></i>
                            <div>
                                <div class="text-gray-300 font-semibold">{{ $achievement->title }}</div>
                                <div class="text-sm text-gray-400">{{ $achievement->description }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4 text-center">
                    <a href="#" class="text-yellow-500 hover:text-yellow-400 text-sm">
                        Voir toutes les récompenses
                        <i class="fas fa-chevron-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Section Chapitre en cours -->
        @if($currentChapter)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
            <div class="card p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-pirate text-yellow-500">Chapitre en cours</h2>
                    <i class="fas fa-book-open text-3xl text-yellow-500"></i>
                </div>
                <div class="space-y-4">
                    <div class="text-xl text-gray-300 font-semibold">{{ $currentChapter->title }}</div>
                    <p class="text-gray-400">{{ $currentChapter->description }}</p>
                    <div class="bg-gray-700/50 rounded-lg p-4 mt-4">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-300">
                                <i class="fas fa-map-marker-alt text-yellow-500 mr-2"></i>
                                {{ $currentChapter->location }}
                            </span>
                            <span class="text-gray-300">
                                <i class="fas fa-cloud text-yellow-500 mr-2"></i>
                                {{ $currentChapter->weather_condition }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            @if($nextEnigma)
            <div class="card p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-pirate text-yellow-500">Prochaine énigme</h2>
                    <i class="fas fa-puzzle-piece text-3xl text-yellow-500"></i>
                </div>
                <div class="bg-gray-700/50 rounded-lg p-4 border border-yellow-600/30">
                    <div class="text-gray-300 font-semibold mb-2">{{ $nextEnigma->title }}</div>
                    <p class="text-gray-400 mb-4">{{ $nextEnigma->description }}</p>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-1">
                            @for($i = 0; $i < $nextEnigma->difficulty; $i++)
                                <i class="fas fa-skull text-yellow-500 text-sm"></i>
                            @endfor
                        </div>
                        <a href="{{ route('enigmas.show', $nextEnigma) }}" 
                           class="px-4 py-2 bg-yellow-500 bg-opacity-20 hover:bg-opacity-30 text-yellow-300 rounded-lg transition-all duration-300 flex items-center space-x-2 border border-yellow-500/30">
                            <span>Commencer</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @endif

        <!-- Classement Global -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-pirate text-yellow-500">Classement Global</h2>
                <i class="fas fa-crown text-3xl text-yellow-500"></i>
            </div>
            <div class="grid grid-cols-1 gap-3">
                @foreach($topUsers as $index => $rankedUser)
                    <div class="bg-gray-700/50 rounded-lg p-4 border border-yellow-600/30 flex items-center group hover:bg-gray-600/50 transition-all duration-300">
                        @if($index < 3)
                            <div class="text-2xl font-pirate {{ $index === 0 ? 'text-yellow-400' : ($index === 1 ? 'text-gray-400' : 'text-yellow-700') }} mr-4 group-hover:scale-110 transition-all duration-300">
                                <i class="fas fa-crown"></i>
                            </div>
                        @else
                            <div class="text-xl font-pirate text-yellow-500/70 mr-4">#{{ $index + 1 }}</div>
                        @endif
                        <div class="flex-grow">
                            <div class="text-gray-300 font-semibold">{{ $rankedUser['name'] }}</div>
                            <div class="text-sm text-gray-400">{{ number_format($rankedUser['points']) }} points</div>
                        </div>
                        @if($rankedUser['name'] === Auth::user()->name)
                            <div class="ml-2 text-yellow-500">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
