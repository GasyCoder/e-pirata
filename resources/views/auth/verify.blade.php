<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification - El Pirata</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-900 flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-sm space-y-8">
        <div class="text-center">
            <img src="/images/logo.svg" alt="El Pirata Logo" class="mx-auto w-24 h-24">
            <h2 class="mt-6 text-2xl md:text-3xl font-bold text-yellow-500">
                Vérification de votre compte
            </h2>
        </div>

        <div class="bg-gray-800 p-6 md:p-8 rounded-lg shadow-lg border-2 border-yellow-500 w-full max-w-sm overflow-hidden">
            @if (session('resent'))
                <div class="bg-green-600 text-white px-4 py-2 rounded mb-4">
                    Un nouveau code de vérification a été envoyé à votre adresse email.
                </div>
            @endif

            <p class="text-gray-300 mb-4 text-sm md:text-base break-words">
                Un code de vérification a été envoyé à votre adresse email. Veuillez entrer ce code ci-dessous pour activer votre compte.
            </p>

            <form method="POST" action="{{ route('verification.verify') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="verification_code" class="block text-sm font-medium text-gray-300">
                        Code de vérification
                    </label>
                    <input id="verification_code" name="verification_code" type="text" required
                           class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 text-center tracking-widest text-lg"
                           placeholder="12345678" maxlength="8" autocomplete="off">
                    @error('verification_code')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-black bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-200">
                        Vérifier le compte
                    </button>
                </div>
            </form>

            <div class="mt-4 text-center">
                <form method="POST" action="{{ route('verification.send') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-yellow-500 hover:text-yellow-400 text-sm transition duration-200">
                        Renvoyer le code de vérification
                    </button>
                </form>
            </div>

            <div class="mt-4 text-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-gray-300 text-sm transition duration-200">
                        Se déconnecter
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
