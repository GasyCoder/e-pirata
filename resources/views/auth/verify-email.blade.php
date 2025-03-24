@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-[#111111] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-6 bg-[#111111] p-8 rounded-xl border border-[#2b2b2b]">
        <div>
            <div class="flex justify-center mb-4">
                <img src="{{ asset('images/logo1.jpeg') }}" alt="Pirate Logo" class="w-12 h-12 rounded-full object-cover">
            </div>
            <h2 class="text-center text-3xl font-bold text-white">
                Vérification du Compte
            </h2>
            <p class="mt-2 text-center text-sm text-gray-400">
                Ahoy Moussaillon ! Un lien de confirmation vous a été envoyé par e-mail. Cliquez dessus pour activer votre compte et embarquer dans l'aventure.
            </p>
        </div>

        @if (session('message'))
            <div class="bg-green-500 text-white p-4 rounded-md text-center">
                {{ session('message') }}
            </div>
        @endif

        <div class="text-center">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="text-yellow-500 hover:text-yellow-400 text-sm font-medium transition-colors duration-200 ease-in-out">
                    Renvoyer l'e-mail de confirmation
                </button>
            </form>
        </div>

        <div class="text-center mt-4">
            <!-- ✅ Formulaire de déconnexion pour rediriger vers login -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="mt-4 inline-block w-full text-center px-4 py-3
                               bg-[#2F3542] text-white rounded-lg font-medium
                               hover:bg-[#373E4D] transition-colors duration-300"
                        style="background: -webkit-linear-gradient(top, #383f4d, #2F3542);
                               background: linear-gradient(to bottom, #383f4d, #2F3542);
                               -webkit-appearance: none;">
                    Retour à la connexion
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
