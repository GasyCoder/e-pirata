@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-gray-800 rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-yellow-500 mb-6">Conditions d'Utilisation</h1>
        
        <div class="prose prose-yellow prose-invert max-w-none">
            <p class="mb-4">Dernière mise à jour : {{ date('d/m/Y') }}</p>

            <h2 class="text-2xl font-semibold text-yellow-500 mt-6 mb-4">1. Acceptation des Conditions</h2>
            <p class="mb-4">En utilisant El Pirata, vous acceptez ces conditions d'utilisation. Si vous n'acceptez pas ces conditions, veuillez ne pas utiliser notre service.</p>

            <h2 class="text-2xl font-semibold text-yellow-500 mt-6 mb-4">2. Description du Service</h2>
            <p class="mb-4">El Pirata est un jeu d'énigmes en ligne qui permet aux utilisateurs de :</p>
            <ul class="list-disc pl-6 mb-4">
                <li>Participer à des défis et énigmes</li>
                <li>Gagner des points et des récompenses</li>
                <li>Interagir avec d'autres joueurs</li>
            </ul>

            <h2 class="text-2xl font-semibold text-yellow-500 mt-6 mb-4">3. Comptes Utilisateurs</h2>
            <p class="mb-4">Pour utiliser El Pirata, vous devez :</p>
            <ul class="list-disc pl-6 mb-4">
                <li>Avoir un compte Google valide</li>
                <li>Fournir des informations exactes</li>
                <li>Protéger vos informations de connexion</li>
            </ul>

            <h2 class="text-2xl font-semibold text-yellow-500 mt-6 mb-4">4. Règles de Conduite</h2>
            <p class="mb-4">Les utilisateurs doivent :</p>
            <ul class="list-disc pl-6 mb-4">
                <li>Respecter les autres utilisateurs</li>
                <li>Ne pas tricher ou exploiter des bugs</li>
                <li>Ne pas partager de contenu inapproprié</li>
            </ul>

            <h2 class="text-2xl font-semibold text-yellow-500 mt-6 mb-4">5. Propriété Intellectuelle</h2>
            <p class="mb-4">Tout le contenu d'El Pirata est protégé par des droits d'auteur. Les utilisateurs ne peuvent pas :</p>
            <ul class="list-disc pl-6 mb-4">
                <li>Copier ou redistribuer le contenu</li>
                <li>Modifier ou créer des œuvres dérivées</li>
                <li>Utiliser le contenu à des fins commerciales</li>
            </ul>

            <h2 class="text-2xl font-semibold text-yellow-500 mt-6 mb-4">6. Résiliation</h2>
            <p class="mb-4">Nous nous réservons le droit de suspendre ou supprimer des comptes qui violent ces conditions.</p>

            <h2 class="text-2xl font-semibold text-yellow-500 mt-6 mb-4">7. Contact</h2>
            <p class="mb-4">Pour toute question concernant ces conditions, contactez-nous à :</p>
            <p class="mb-4">contact@el-pirata.com</p>
        </div>
    </div>
</div>
@endsection
