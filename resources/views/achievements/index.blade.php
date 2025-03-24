@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h2 class="text-2xl font-bold text-white mb-6">Succès et Récompenses</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($achievements as $achievement)
                    <div class="bg-gray-700 rounded-lg shadow-lg overflow-hidden 
                              {{ $achievement->users->count() > 0 ? 'border-2 border-yellow-500' : 'opacity-75' }}">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 flex items-center justify-center rounded-full 
                                          {{ $achievement->users->count() > 0 ? 'bg-yellow-500' : 'bg-gray-600' }}">
                                    <i class="fas {{ $achievement->icon }} text-2xl 
                                             {{ $achievement->users->count() > 0 ? 'text-gray-900' : 'text-gray-400' }}">
                                    </i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-xl font-bold text-white">{{ $achievement->name }}</h3>
                                    <p class="text-gray-400">{{ $achievement->description }}</p>
                                </div>
                            </div>
                            
                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-yellow-500">
                                    <i class="fas fa-coins"></i>
                                    {{ $achievement->points_reward }} points
                                </span>
                                
                                @if($achievement->users->count() > 0)
                                    <div class="flex items-center text-green-500">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        <span>Débloqué le {{ $achievement->users->first()->pivot->unlocked_at->format('d/m/Y') }}</span>
                                    </div>
                                @else
                                    <span class="text-gray-500">
                                        <i class="fas fa-lock"></i>
                                        Non débloqué
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
