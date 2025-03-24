@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-gray-800 rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-yellow-500 mb-6">Politique de Confidentialité</h1>
        
        <div class="prose prose-yellow prose-invert max-w-none">
            <p class="mb-4">Dernière mise à jour : {{ date('d/m/Y') }}</p>

            <h2 class="text-2xl font-semibold text-yellow-500 mt-6 mb-4">1. Collecte des Informations</h2>
            <p class="mb-4">Nous collectons les informations suivantes lorsque vous utilisez El Pirata :</p>
            <ul class="list-disc pl-6 mb-4">
                <li>Informations de profil Google (nom, email)</li>
                <li>Données de progression dans le jeu</li>
                <li>Scores et réalisations</li>
            </ul>

            <h2 class="text-2xl font-semibold text-yellow-500 mt-6 mb-4">2. Utilisation des Informations</h2>
            <p class="mb-4">Nous utilisons ces informations pour :</p>
            <ul class="list-disc pl-6 mb-4">
                <li>Gérer votre compte et votre progression</li>
                <li>Améliorer votre expérience de jeu</li>
                <li>Vous contacter concernant votre compte si nécessaire</li>
            </ul>

            <h2 class="text-2xl font-semibold text-yellow-500 mt-6 mb-4">3. Protection des Données</h2>
            <p class="mb-4">Nous prenons la sécurité de vos données très au sérieux :</p>
            <ul class="list-disc pl-6 mb-4">
                <li>Toutes les données sont cryptées</li>
                <li>Accès limité aux informations personnelles</li>
                <li>Mises à jour régulières de sécurité</li>
            </ul>

            <h2 class="text-2xl font-semibold text-yellow-500 mt-6 mb-4">4. Vos Droits</h2>
            <p class="mb-4">Vous avez le droit de :</p>
            <ul class="list-disc pl-6 mb-4">
                <li>Accéder à vos données personnelles</li>
                <li>Corriger vos données personnelles</li>
                <li>Supprimer votre compte et vos données</li>
            </ul>

            <h2 class="text-2xl font-semibold text-yellow-500 mt-6 mb-4">5. Contact</h2>
            <p class="mb-4">Pour toute question concernant cette politique de confidentialité, contactez-nous à :</p>
            <p class="mb-4">contact@el-pirata.com</p>
        </div>
    </div>
</div>
@endsection
