@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-gray-800/50 backdrop-blur-xl rounded-2xl overflow-hidden shadow-xl border border-yellow-600/30">
            <div class="px-8 py-6">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-yellow-500">Modifier le profil</h1>
                    <a href="{{ route('profile.show') }}" class="text-gray-400 hover:text-yellow-500">
                        <i class="fas fa-times"></i>
                    </a>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Avatar -->
                    <div class="mb-6">
                        <label class="block text-yellow-500 mb-2">Photo de profil</label>
                        <div class="flex items-center space-x-6">
                            <div class="relative">
                                @if($user->avatar)
                                    <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" 
                                         class="w-24 h-24 rounded-full object-cover">
                                @else
                                    <div class="w-24 h-24 rounded-full bg-yellow-600/20 flex items-center justify-center">
                                        <i class="fas fa-user text-3xl text-yellow-500"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <input type="file" name="avatar" id="avatar" class="hidden" accept="image/*">
                                <label for="avatar" class="cursor-pointer px-4 py-2 bg-yellow-500 bg-opacity-20 hover:bg-opacity-30 text-yellow-300 rounded-lg transition-all duration-300 flex items-center space-x-2 border border-yellow-500/30">
                                    <i class="fas fa-camera"></i>
                                    <span>Changer la photo</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Informations de base -->
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-yellow-500 mb-2">Nom</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                                   class="w-full bg-gray-700/50 border border-yellow-600/30 rounded-lg px-4 py-2 text-gray-300 focus:outline-none focus:border-yellow-500">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-yellow-500 mb-2">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                                   class="w-full bg-gray-700/50 border border-yellow-600/30 rounded-lg px-4 py-2 text-gray-300 focus:outline-none focus:border-yellow-500">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="bio" class="block text-yellow-500 mb-2">Bio</label>
                            <textarea name="bio" id="bio" rows="4" 
                                      class="w-full bg-gray-700/50 border border-yellow-600/30 rounded-lg px-4 py-2 text-gray-300 focus:outline-none focus:border-yellow-500">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Changement de mot de passe -->
                    <div class="mt-8 pt-8 border-t border-gray-700">
                        <h2 class="text-xl font-semibold text-yellow-500 mb-6">Changer le mot de passe</h2>
                        <div class="space-y-6">
                            <div>
                                <label for="current_password" class="block text-yellow-500 mb-2">Mot de passe actuel</label>
                                <input type="password" name="current_password" id="current_password" 
                                       class="w-full bg-gray-700/50 border border-yellow-600/30 rounded-lg px-4 py-2 text-gray-300 focus:outline-none focus:border-yellow-500">
                                @error('current_password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="new_password" class="block text-yellow-500 mb-2">Nouveau mot de passe</label>
                                <input type="password" name="new_password" id="new_password" 
                                       class="w-full bg-gray-700/50 border border-yellow-600/30 rounded-lg px-4 py-2 text-gray-300 focus:outline-none focus:border-yellow-500">
                                @error('new_password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="new_password_confirmation" class="block text-yellow-500 mb-2">Confirmer le nouveau mot de passe</label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" 
                                       class="w-full bg-gray-700/50 border border-yellow-600/30 rounded-lg px-4 py-2 text-gray-300 focus:outline-none focus:border-yellow-500">
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-yellow-500 text-gray-900 rounded-lg hover:bg-yellow-400 transition-colors font-semibold">
                            Sauvegarder les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
