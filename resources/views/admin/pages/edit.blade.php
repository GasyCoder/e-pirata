{{-- resources/views/admin/pages/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="bg-gray-900 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="p-6 border-b border-gray-700">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-pirate text-yellow-500 mb-2">Modifier la page</h1>
                        <p class="text-gray-400">{{ $page->title }}</p>
                    </div>
                    <a href="{{ route('admin.pages.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-700 border border-gray-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-700 focus:outline-none focus:border-gray-600 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour
                    </a>
                </div>
            </div>

            <!-- Messages d'erreur -->
            @if ($errors->any())
                <div class="mx-6 mt-4 p-4 rounded-lg bg-red-900/50 text-red-400 border border-red-800" role="alert">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Erreurs à corriger :</span>
                    </div>
                    <ul class="list-disc pl-5 space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulaire -->
            <div class="p-6">
                <form action="{{ route('admin.pages.update', $page->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="title" class="block text-gray-300 font-medium mb-2">Titre</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $page->title) }}"
                            class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-md text-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition"
                            required autofocus>
                    </div>

                    <div class="mb-6">
                        <label for="slug" class="block text-gray-300 font-medium mb-2">Slug</label>
                        <div class="flex items-center bg-gray-700 border border-gray-600 rounded-md text-gray-400 px-4 py-2">
                            <span>{{ url('/') }}/</span>
                            <input type="text" id="slug" value="{{ $page->slug }}" disabled
                                class="bg-transparent border-0 outline-none flex-1 ml-1 text-gray-300">
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Le slug ne peut pas être modifié.</p>
                    </div>

                    <div class="mb-6">
                        <label for="content" class="block text-gray-300 font-medium mb-2">Contenu</label>

                        <!-- Utiliser le composant Trix personnalisé -->
                        @php
                        // Décodage du HTML échappé
                        $decodedContent = html_entity_decode($page->content);
                        @endphp

                        <!-- Puis dans l'éditeur Trix -->
                        <x-trix-input
                            id="page_content"
                            name="content"
                            value="{!! $decodedContent !!}"
                            class="w-full min-h-[300px] bg-gray-700 text-gray-300 border-gray-600"
                        />

                        <p class="mt-1 text-sm text-gray-500">Utilisez l'éditeur ci-dessus pour formater votre contenu.</p>
                    </div>
                    <div class="mb-6">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="is_published" value="1"
                                {{ $page->is_published ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-gray-600 bg-gray-700 text-yellow-500 focus:ring-yellow-500">
                            <span class="ml-3 text-gray-300 font-medium">Publier cette page</span>
                        </label>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ url('/' . $page->slug) }}" target="_blank"
                           class="px-4 py-2 border border-gray-600 rounded-md text-gray-300 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 transition">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Prévisualiser
                            </div>
                        </a>
                        <button type="submit"
                                class="px-6 py-2 bg-yellow-600 border border-yellow-700 rounded-md text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Enregistrer
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
<style>
    /* Solution pour rendre les icônes réellement visibles */

    /* Fond de la barre d'outils */
    trix-toolbar {
        background-color: #334155 !important; /* Bleu-gris plus clair */
        padding: 10px !important;
        border-radius: 6px 6px 0 0 !important;
        border: 1px solid #64748b !important;
        border-bottom: none !important;
    }

    /* Conteneurs de boutons */
    trix-toolbar .trix-button-group {
        border: 1px solid #64748b !important;
        border-radius: 4px !important;
        margin: 0 5px !important;
        background-color: #475569 !important;
    }

    /* Boutons individuels - FOND CLAIR pour contraste */
    trix-toolbar .trix-button {
        background-color: #f8fafc !important; /* Fond BLANC */
        border: 1px solid #94a3b8 !important;
        margin: 2px !important;
        width: 2.5rem !important;
        height: 2.5rem !important;
        border-radius: 4px !important;
        padding: 4px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    /* Hover des boutons */
    trix-toolbar .trix-button:hover {
        background-color: #fbbf24 !important; /* Jaune plus visible */
    }

    /* Boutons actifs */
    trix-toolbar .trix-button.trix-active {
        background-color: #fbbf24 !important; /* Jaune */
        color: #1e293b !important;
    }

    /* CRUCIAL: Icônes visibles - utiliser des couleurs sombres sur fond clair */
    trix-toolbar .trix-button--icon {
        filter: none !important; /* Retirer tout filtre qui pourrait interférer */
        opacity: 0.8 !important;
    }

    /* Ajout de bordure noire autour des icônes pour améliorer visibilité */
    trix-toolbar .trix-button--icon::before {
        -webkit-filter: drop-shadow(0px 0px 1px rgba(0,0,0,0.8)) !important;
        filter: drop-shadow(0px 0px 1px rgba(0,0,0,0.8)) !important;
    }

    /* Styles pour certains boutons spécifiques */
    trix-toolbar .trix-button--icon-bold::before,
    trix-toolbar .trix-button--icon-italic::before,
    trix-toolbar .trix-button--icon-link::before,
    trix-toolbar .trix-button--icon-heading-1::before,
    trix-toolbar .trix-button--icon-bullet-list::before,
    trix-toolbar .trix-button--icon-number-list::before,
    trix-toolbar .trix-button--icon-quote::before,
    trix-toolbar .trix-button--icon-code::before,
    trix-toolbar .trix-button--icon-strike::before,
    trix-toolbar .trix-button--icon-decrease-nesting-level::before,
    trix-toolbar .trix-button--icon-increase-nesting-level::before {
        opacity: 1 !important;
    }

    /* Conteneur d'édition */
    trix-editor {
        background-color: #1e293b !important;
        color: #f8fafc !important;
        border: 1px solid #64748b !important;
        border-radius: 0 0 6px 6px !important;
        min-height: 300px !important;
        padding: 16px !important;
        font-size: 16px !important;
        line-height: 1.6 !important;
    }

    /* Amélioration des éléments dans l'éditeur */
    trix-editor h1 {
        font-family: 'Pirata One', cursive !important;
        color: #fbbf24 !important;
        font-size: 1.8rem !important;
        margin-top: 1.5rem !important;
        margin-bottom: 0.75rem !important;
    }

    trix-editor a {
        color: #60a5fa !important;
        text-decoration: underline !important;
    }

    /* Améliorer les dialogues */
    .trix-dialog {
        background-color: #334155 !important;
        border: 1px solid #64748b !important;
        border-radius: 6px !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3) !important;
        padding: 10px !important;
    }

    .trix-dialog__link-fields input {
        background-color: #1e293b !important;
        color: #f8fafc !important;
        border: 1px solid #64748b !important;
        padding: 8px !important;
        border-radius: 4px !important;
        width: 100% !important;
        margin-bottom: 8px !important;
    }

    .trix-button--dialog {
        background-color: #fbbf24 !important;
        color: #1e293b !important;
        font-weight: bold !important;
        padding: 6px 12px !important;
        border-radius: 4px !important;
        border: none !important;
        cursor: pointer !important;
    }
</style>
@endpush
@push('scripts')
<script src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animer l'apparition du formulaire
        const form = document.querySelector('form');
        form.style.opacity = '0';
        form.style.transform = 'translateY(10px)';
        form.style.transition = 'opacity 0.5s ease, transform 0.5s ease';

        setTimeout(() => {
            form.style.opacity = '1';
            form.style.transform = 'translateY(0)';
        }, 200);

        // Faire apparaître le message d'erreur s'il existe
        const errorAlert = document.querySelector('[role="alert"]');
        if (errorAlert) {
            errorAlert.style.opacity = '0';
            errorAlert.style.transform = 'translateY(-10px)';
            errorAlert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';

            setTimeout(() => {
                errorAlert.style.opacity = '1';
                errorAlert.style.transform = 'translateY(0)';
            }, 300);
        }

        // Ajouter les styles spécifiques aux titres Trix pour utiliser la police Pirata
        document.addEventListener('trix-initialize', function() {
            console.log('Trix initialized');
        });
    });
</script>
@endpush
@endsection
