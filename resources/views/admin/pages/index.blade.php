{{-- resources/views/admin/pages/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <!-- Header avec titre et description -->
            <div class="p-6 border-b border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-pirate text-yellow-500 mb-2">Gestion des Pages</h1>
                        <p class="text-gray-400">Gérez les pages statiques du site</p>
                    </div>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-700 border border-gray-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-700 focus:outline-none focus:border-gray-600 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour
                    </a>
                </div>
            </div>

            <!-- Notification de succès -->
            @if (session('success'))
                <div class="mx-6 mt-4 flex items-center p-4 mb-4 text-sm rounded-lg bg-green-900/50 text-green-400 border border-green-800" role="alert">
                    <svg class="flex-shrink-0 inline w-5 h-5 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Tableau des pages -->
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-700 text-left">
                                <th class="px-4 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Titre</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Slug</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider text-center">Statut</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider text-center">Mise à jour</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @foreach ($pages as $page)
                            <tr class="text-gray-300 hover:bg-gray-700/50 transition-colors">
                                <td class="px-4 py-4 whitespace-nowrap font-medium">{{ $page->title }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs bg-gray-700 rounded-md">{{ $page->slug }}</span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    @if ($page->is_published)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-900/40 text-green-400 border border-green-800">
                                            <span class="flex-shrink-0 h-1.5 w-1.5 rounded-full bg-green-400 mr-1.5"></span>
                                            Publié
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-900/40 text-red-400 border border-red-800">
                                            <span class="flex-shrink-0 h-1.5 w-1.5 rounded-full bg-red-400 mr-1.5"></span>
                                            Non publié
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center text-sm">
                                    {{ $page->updated_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('admin.pages.edit', $page->id) }}" class="inline-flex items-center px-3 py-1.5 border border-yellow-600 text-xs font-medium rounded-md text-yellow-500 bg-transparent hover:bg-yellow-900/30 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Modifier
                                        </a>
                                        <a href="{{ url('/' . $page->slug) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 border border-gray-600 text-xs font-medium rounded-md text-gray-300 bg-transparent hover:bg-gray-700 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Voir
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Message si aucune page -->
                @if($pages->isEmpty())
                <div class="mt-4 text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-400">Aucune page disponible</h3>
                    <p class="mt-1 text-sm text-gray-500">Créez une nouvelle page pour commencer.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Script pour les animations -->
<script>
    // Ajouter des effets d'animation au tableau
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach((row, index) => {
            row.style.opacity = '0';
            row.style.transform = 'translateY(10px)';
            row.style.transition = 'opacity 0.3s ease, transform 0.3s ease';

            setTimeout(() => {
                row.style.opacity = '1';
                row.style.transform = 'translateY(0)';
            }, 100 + (index * 50));
        });

        // Animation pour le message de notification
        const notification = document.querySelector('[role="alert"]');
        if (notification) {
            notification.style.opacity = '0';
            notification.style.transform = 'translateY(-10px)';
            notification.style.transition = 'opacity 0.5s ease, transform 0.5s ease';

            setTimeout(() => {
                notification.style.opacity = '1';
                notification.style.transform = 'translateY(0)';
            }, 300);

            // Masquer la notification après 5 secondes
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateY(-10px)';

                setTimeout(() => {
                    notification.remove();
                }, 500);
            }, 5000);
        }
    });
</script>
@endsection
