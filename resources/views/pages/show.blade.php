{{-- resources/views/pages/show.blade.php --}}
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $page->title }} - El Pirata</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js pour le menu mobile -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Google Fonts: Pirata One (titres) et Roboto (corps) -->
    <link href="https://fonts.googleapis.com/css2?family=Pirata+One&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <!-- FontAwesome pour les icônes -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Merienda&family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
            /* Police de base pour le corps */
            body {
                font-family: 'Roboto', sans-serif;
                background-color: #2b1b17;
                color: white;
            }

            /* Police pour les titres */
            .header-title {
                font-family: 'Pirata One', cursive;
            }

            /* Définition de classes utilitaires pour nos polices */
            .font-merienda {
                font-family: 'merienda', cursive;
            }

            .font-poppins {
                font-family: 'Poppins', sans-serif;
            }

            /* Animation pour le contenu */
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .content-container {
                animation: fadeIn 0.8s ease-out forwards;
            }

            /* Styles pour le contenu de page */
            .page-content {
                line-height: 1.7;
            }

            .page-content h1,
            .page-content h2,
            .page-content h3 {
                font-family: 'Pirata One', cursive;
                color: #FFD700;
                margin-top: 1.5em;
                margin-bottom: 0.75em;
            }

            .page-content h1 {
                font-size: 2rem;
            }

            .page-content h2 {
                font-size: 1.75rem;
            }

            .page-content h3 {
                font-size: 1.5rem;
            }

            .page-content p {
                margin-bottom: 1em;
            }

            .page-content ul,
            .page-content ol {
                margin-left: 2em;
                margin-bottom: 1em;
            }

            .page-content a {
                color: #FFD700;
                text-decoration: underline;
            }

            .page-content blockquote {
                border-left: 4px solid #FFD700;
                padding-left: 1em;
                margin-left: 0;
                font-style: italic;
                margin-bottom: 1em;
            }

            /* Fix pour l'espace en haut de la page */
            .page-container {
                padding-top: 80px; /* Ajuster selon la hauteur de votre header */
            }

            .rich-text-content h1,
            .rich-text-content h2,
            .rich-text-content h3 {
                font-family: 'Pirata One', cursive;
                color: #FFD700;
                margin-top: 1.5em;
                margin-bottom: 0.75em;
            }

            .rich-text-content ul {
                list-style-type: disc;
                padding-left: 2rem;
            }

            .rich-text-content ol {
                list-style-type: decimal;
                padding-left: 2rem;
            }

            .rich-text-content a {
                color: #FFD700;
                text-decoration: underline;
            }

            .rich-text-content blockquote {
                border-left: 4px solid #FFD700;
                padding-left: 1rem;
                font-style: italic;
                margin: 1rem 0;
            }
    </style>
</head>

<body>
    <!-- HEADER -->
    <header class="bg-[#000000] shadow fixed w-full z-50 font-merienda">
        <!-- px-3 = padding horizontal de 0.75rem -->
        <div class="container mx-auto px-3 py-4 flex items-center justify-between">
            <!-- Conteneur flex pour : (1) bouton burger, (2) "El", (3) "Pirata" -->
            <div class="flex items-center space-x-3">
                <!-- Conteneur avec ml-3 pour ajouter un espacement supplémentaire avant le bouton burger -->
                <div class="ml-3">
                    <!-- Bouton Burger -->
                    <div x-data="{ open: false }">
                        <button @click="open = !open" class="text-[36px] focus:outline-none text-white">
                            <i class="fas fa-bars"></i>
                        </button>

                        <!-- Menu Mobile & Desktop -->
                        <div x-show="open" @click.outside="open = false"
                            class="absolute top-16 left-0 w-screen bg-[#1f1512] shadow-lg py-4 px-6
                                lg:w-64 lg:left-2 lg:right-2 z-50 transition-all duration-300 ease-in-out"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-90"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-90">
                            <!-- Liens du menu -->
                            <a href="/" class="block px-4 py-2 hover:bg-[#E3342F] transition">Accueil</a>
                            <a href="#about" class="block px-4 py-2 hover:bg-[#E3342F] transition">Profil</a>
                            <a href="#services" class="block px-4 py-2 hover:bg-[#E3342F] transition">Les chasses au trésor</a>
                            <a href="#gallery" class="block px-4 py-2 hover:bg-[#E3342F] transition">Commencer mon aventure</a>
                            <a href="#contact" class="block px-4 py-2 hover:bg-[#E3342F] transition">Avis</a>
                            <a href="{{ route('pages.cgv')}}" class="block px-4 py-2 hover:bg-[#E3342F] transition">CGV</a>
                            <a href="{{ route('pages.cgu')}}" class="block px-4 py-2 hover:bg-[#E3342F] transition">CGU</a>
                            <a href="/Remboursement" class="block px-4 py-2 hover:bg-[#E3342F] transition">Remboursement</a>
                            <a href="/regles" class="block px-4 py-2 hover:bg-[#E3342F] transition">Règle du jeu</a>
                            <a href="/nous" class="block px-4 py-2 hover:bg-[#E3342F] transition">Qui sommes-nous</a>
                            <a href="/FAQ" class="block px-4 py-2 hover:bg-[#E3342F] transition">FAQ</a>
                            <a href="/contacte" class="block px-4 py-2 hover:bg-[#E3342F] transition">Contact</a>
                            <a href="#contact" class="block px-4 py-2 hover:bg-[#E3342F] transition">Se désinscrire</a>
                        </div>
                    </div>
                </div>

                <!-- "El" en blanc -->
                <span class="text-[36px] font-merienda text-white font-bold">
                    El
                </span>

                <!-- "Pirata" en rouge -->
                <span class="text-[36px] font-merienda-black text-[#FF1818] font-bold">
                    Pirata
                </span>
            </div>

            <!-- Partie droite : icône utilisateur & drapeau -->
            <div class="flex items-center space-x-6">
                <!-- Icône utilisateur -->
                <a href="/login" class="w-5 h-5 flex items-center">
                    <i class="far fa-user text-white text-lg"></i>
                </a>
                <!-- Drapeau + Texte FR -->
                <div class="flex items-center space-x-2">
                    <img src="https://upload.wikimedia.org/wikipedia/en/c/c3/Flag_of_France.svg" class="w-5 h-5" alt="FR">
                    <span class="text-white font-bold">FR</span>
                </div>
            </div>
        </div>
        <!-- Ligne fine en bas -->
        <div class="border-t border-white"></div>
    </header>

    <!-- CONTENU PRINCIPAL -->
    <div class="page-container bg-[#2b1b17] text-white">
        <div class="max-w-4xl mx-auto px-4 pt-4">
            <div class="bg-[#1a1311] rounded-lg shadow-lg overflow-hidden">
                <!-- En-tête de la page -->
                <div class="flex justify-between items-center p-5 border-b border-gray-800">
                    <h1 class="text-4xl header-title font-merienda text-[#FFD700]">{{ $page->title }}</h1>
                </div>

                <!-- Contenu de la page -->
                <div class="px-8 pb-8 content-container">
                   <!-- Dans la section contenu de la page -->
                    <div class="page-content text-white font-merienda rich-text-content" style="text-align:justify">
                        {!! $page->content !!}
                    </div>
                </div>

                <!-- Pied de page avec date de mise à jour -->
                <div class="p-5 border-t border-gray-800 text-gray-400 flex justify-between items-center font-merienda">
                    <span>Dernière mise à jour : {{ $page->updated_at->format('d/m/Y') }}</span>

                    @if(auth()->check() && auth()->user()->email === 'admin@pirata.fr')
                    <a href="{{ route('admin.pages.edit', $page->id) }}" class="text-[#FFD700] hover:underline flex items-center">
                        <i class="fas fa-edit mr-1"></i> Modifier
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="w-full bg-black text-white py-10 mt-8">
        <div class="container mx-auto px-4">
            <!-- Section principale du footer -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 font-merienda">
                <!-- Colonne de gauche -->
                <div class="text-center md:text-left">
                    <div class="space-y-3 mb-6">
                        <a href="{{ route('pages.cgv')}}" class="block text-lg hover:text-gray-300 transition">CGV</a>
                        <a href="{{ route('pages.cgu')}}" class="block text-lg hover:text-gray-300 transition">CGU</a>
                        <a href="/Remboursement" class="block text-lg hover:text-gray-300 transition">Remboursement</a>
                    </div>
                    <!-- Réseaux sociaux -->
                    <div class="flex justify-center md:justify-start space-x-6">
                        <a href="https://web.facebook.com/profile.php?id=100092185284129&_rdc=1&_rdr#" class="text-2xl hover:text-gray-300 transition">
                            <i class="fab fa-facebook-square"></i>
                        </a>
                        <a href="https://www.youtube.com/@Elpirata_officiel" class="text-2xl hover:text-gray-300 transition">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="https://www.snapchat.com/add/elpirata_off?invite_id=ElrPx61w&locale=fr_FR&share_id=CK3Fh2MXQCKcjGRLtXSC0Q&sid=622c513c3cb14e7dbe7dd45dc849cf6e&fbclid=IwAR2YqefBEnW9gDcGqYLd4ybcPGgcuLbTT_fWTA9tiN6jdLYWblX0QpuhUgE" class="text-2xl hover:text-gray-300 transition">
                            <i class="fab fa-snapchat"></i>
                        </a>
                        <a href="https://www.tiktok.com/@elpirata_officiel?_t=8gyk7xbnf1v&_r=1&fbclid=iwar1hztoduwunlhuuncrgplmretnfh3rdirua1bwofg4w_zqio9zawkyjws4" class="text-2xl hover:text-gray-300 transition">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        <a href="https://www.instagram.com/elpirata_officiel/?igshid=MzMyNGUyNmU2YQ%3D%3D&utm_source=qr&fbclid=IwAR2nqKxtebhj4L3P93WUhH-EJuUyyuYWzeBTyn9njtOlbQaclx7YsZN0m4M" class="text-2xl hover:text-gray-300 transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>

                <!-- Colonne du centre -->
                <div class="text-center border-t md:border-t-0 pt-6 md:pt-0">
                    <div class="space-y-3">
                        <a href="/regles" class="block text-lg hover:text-gray-300 transition">Règles du jeu</a>
                        <a href="/nous" class="block text-lg hover:text-gray-300 transition">Qui sommes-nous?</a>
                        <a href="/FAQ" class="block text-lg hover:text-gray-300 transition">FAQ</a>
                    </div>
                </div>

                <!-- Colonne de droite -->
                <div class="text-center md:text-right border-t md:border-t-0 pt-6 md:pt-0">
                    <div class="space-y-3 mb-6">
                        <p class="text-lg">Mardi à vendredi 10h / 16h</p>
                        <p class="text-lg">0678615358</p>
                    </div>
                    <a href="/contacte" class="inline-block bg-white text-black font-semibold py-2 px-6 rounded hover:bg-gray-200 transition duration-200">
                        Contact
                    </a>
                </div>
            </div>

            <!-- Séparation et copyright -->
            <div class="mt-8 pt-6 border-t border-white/20">
                <p class="text-sm text-center">
                    Copyright © 2025 alpirata Tous droits réservés
                </p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation pour le contenu de la page
            const content = document.querySelector('.content-container');
            if (content) {
                content.style.opacity = '0';
                setTimeout(() => {
                    content.style.opacity = '1';
                }, 100);
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
