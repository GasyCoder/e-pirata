@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-[#111111] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-6 bg-[#111111] p-8 rounded-xl border border-[#2b2b2b]">
        <div>
            <div class="flex justify-center mb-4">
                <img src="{{ asset('images/logo1.jpeg') }}" alt="Pirate Logo" class="w-12 h-12 rounded-full object-cover">
            </div>
            <h2 class="text-center text-3xl font-bold text-white" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
                Embarquez sur El Pirata
            </h2>
            <p class="mt-2 text-center text-sm text-gray-400">
                Prêt pour l'aventure?
            </p>
        </div>

        <div class="flex gap-4">
            <a href="{{ route('auth.google') }}"
               class="flex-1 bg-[#2A2A2A] hover:bg-[#333333] text-white rounded-lg py-3 px-4 flex items-center justify-center border border-gray-700">
                <svg class="w-6 h-6" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
            </a>
            <a href="#"
               class="flex-1 bg-[#2A2A2A] hover:bg-[#333333] text-white rounded-lg py-3 px-4 flex items-center justify-center border border-gray-700">
                <svg class="w-6 h-6" viewBox="0 0 384 512">
                    <path fill="currentColor" d="M318.7 268.7c-.2-36.7 16.4-64.4 50-84.8-18.8-26.9-47.2-41.7-84.7-44.6-35.5-2.8-74.3 20.7-88.5 20.7-15 0-49.4-19.7-76.4-19.7C63.3 141.2 4 184.8 4 273.5q0 39.3 14.4 81.2c12.8 36.7 59 126.7 107.2 125.2 25.2-.6 43-17.9 75.8-17.9 31.8 0 48.3 17.9 76.4 17.9 48.6-.7 90.4-82.5 102.6-119.3-65.2-30.7-61.7-90-61.7-91.9zm-56.6-164.2c27.3-32.4 24.8-61.9 24-72.5-24.1 1.4-52 16.4-67.9 34.9-17.5 19.8-27.8 44.3-25.6 71.9 26.1 2 49.9-11.4 69.5-34.3z"/>
                </svg>
            </a>
        </div>

        <div class="text-center">
            <span class="text-gray-400">Ou</span>
        </div>

        <form class="space-y-4" action="{{ route('login') }}" method="POST">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-white mb-1">Email</label>
                <input type="email" id="email" name="email" required
                       class="appearance-none rounded-lg relative block w-full px-3 py-2
                              bg-[#171e26] !bg-[#171e26]
                              border border-gray-700
                              text-gray-300
                              focus:outline-none focus:ring-0
                              placeholder-gray-500"
                       style="background-color: #171e26 !important; -webkit-appearance: none;"
                       placeholder=" Email ">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-white mb-1">Mot de passe</label>
                <div class="relative">
                    <input type="password" id="password" name="password" required
                           class="appearance-none rounded-lg relative block w-full px-3 py-2 mb-8
                                  bg-[#171e26] !bg-[#171e26]
                                  border border-gray-700
                                  text-gray-300
                                  focus:outline-none focus:ring-0
                                  placeholder-gray-500"
                           style="background-color: #171e26 !important; -webkit-appearance: none;"
                           placeholder="Mot de passe ">
                    <button type="button" onclick="togglePassword('password', this)" class="absolute inset-y-0 right-2 flex items-center pr-1 text-gray-400">
                        <!-- Icône d'œil (ouvert) par défaut -->
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            @if ($errors->any())
                <div class="bg-red-500/10 border border-red-500 rounded-md p-4">
                    @foreach ($errors->all() as $error)
                        <p class="text-red-500 text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="mt-6">
                <button type="submit"
                        class="w-full flex items-center justify-center px-4 py-3
                               bg-[#2F3542] text-white
                               rounded-lg font-medium
                               hover:bg-[#373E4D]
                               transition-colors duration-300"
                        style="background: linear-gradient(to bottom, #383f4d, #2F3542);">
                    Se connecter
                </button>
            </div>
        </form>

        <div class="text-center text-sm">
            <span class="text-gray-400">Pas encore de compte? </span>
            <a href="{{ route('register') }}"
               class="font-medium text-white hover:text-gray-300 transition-colors duration-200 ease-in-out">
                Rejoignez l'équipage!
            </a>
        </div>
    </div>
</div>

<!-- Script JavaScript pour basculer l'affichage du mot de passe -->
<script>
    function togglePassword(fieldId, toggleButton) {
        var input = document.getElementById(fieldId);
        if (input.type === 'password') {
            input.type = 'text';
            // Icône "œil fermé" pour indiquer que le mot de passe est visible
            toggleButton.innerHTML = '<svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 012.24-3.478M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"/></svg>';
        } else {
            input.type = 'password';
            // Icône "œil" pour indiquer que le mot de passe est masqué
            toggleButton.innerHTML = '<svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>';
        }
    }
</script>
@endsection
