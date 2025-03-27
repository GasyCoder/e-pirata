<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>El Pirata - Chasse au trésor</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js pour le menu mobile -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Google Fonts: Pirata One (titres) et Roboto (corps) -->
    <link href="https://fonts.googleapis.com/css2?family=Pirata+One&family=Roboto:wght@400;700&display=swap"
        rel="stylesheet">
    <!-- FontAwesome pour les icônes -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Merienda&family=Poppins:wght@400;700&display=swap"
        rel="stylesheet">
    <!-- Font Awesome pour les icônes sociales -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Police de base pour le corps */
        body {
            font-family: 'Roboto', sans-serif;
        }

        /* Police pour les titres */
        .header-title {
            font-family: 'Pirata One', cursive;
        }

        /* Bouton principal personnalisé */
        .btn-primary {
            background-color: #EB0000;
            color: #ffffff;
        }

        .btn-primary:hover {
            background-color: #CC1F1A;
        }

        .footer {
            background-color: #000000;
            color: #ffffff;
            padding: 2rem 0;
            font-family: 'Kalam', cursive;
            /* Pour le style d'écriture manuscrite */
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            padding: 0 2rem;
        }

        .footer-column {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .footer-column a {
            color: #ffffff;
            text-decoration: none;
            font-size: 1.1rem;
        }

        .social-icons {
            display: flex;
            gap: 1rem;
            font-size: 1.5rem;
        }

        .social-icons a {
            color: #ffffff;
        }

        .copyright {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .copyright p {
            font-size: 0.9rem;
        }

        /* Pour assurer la réactivité */
        @media (max-width: 768px) {
            .footer-content {
                flex-direction: column;
                gap: 2rem;
                text-align: center;
            }

            .social-icons {
                justify-content: center;
            }
        }






        /* Définition de classes utilitaires pour nos polices */
        .font-merienda {
            font-family: 'merienda', cursive;
        }

        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }
    </style>

</head>

<body class="bg-[#2b1b17] text-white">

    <!-- ============================== -->
    <!-- HEADER -->
    <!-- ============================== -->



    <header class="bg-[#000000] shadow fixed w-full z-50 font-merienda">
        <!-- px-3 = padding horizontal de 0.75rem -->
        <div class="container mx-auto px-3 py-4 flex items-center justify-between">

            <!-- Conteneur flex pour : (1) bouton burger, (2) "El", (3) "Pirata" -->
            <!-- space-x-3 = espacement de 0.75rem entre les éléments -->
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
                <span class="text-[36px] font-merienda text-white font-bold"> <!-- Ajouté font-bold pour correspondre au style -->
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

    <style>
        /* Ajustement pour assurer que les éléments sont nets et bien définis */
        .font-merienda {
            font-family: 'Merienda', cursive;
            /* Assure l'utilisation de la police Merienda */
        }

        /* Supprimer les marges ou espacements inutiles pour un alignement précis */
        header span {
            line-height: 1;
            /* Pour éviter des écarts verticaux inutiles */
        }
    </style>






    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    // Ferme le menu mobile si ouvert
                    if (window.innerWidth < 1024) {
                        document.querySelector('[x-data="{ open: false }"]').__x.$data.open = false;
                    }
                }
            });
        });
    </script>

    <style>
        header {
            transition: background-color 0.3s ease;
        }

        .fa-times {
            transform: rotate(180deg);
            transition: transform 0.3s ease;
        }

        .absolute {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        @media (max-width: 1023px) {
            .absolute {
                transform-origin: top;
            }
        }
    </style>

    <!-- ============================== -->
    <!-- SECTION HERO -->
    <!-- ============================== -->
    <section class="relative bg-cover bg-center h-[90vh] font-merienda bg-red-500"
        style="background-image: url('{{ asset('images/banner.jpg') }}'); background-size: cover; background-position: center;">
        <!-- Overlay noir semi-transparent -->
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <!-- Contenu centré (titre, sous-titre, CTA) -->
        <div class="container mx-auto relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
            <img src="{{ asset('images/pirate.png') }}" alt="pirate" class="w-32 h-32 mb-6 object-contain mx-auto">
            <!-- Ajuste la taille avec w-32 h-32 -->

            <h1 class="text-5xl lg:text-6xl header-title text-[#FFFFFF] mb-4">
                Les <span class="text-[#FF1818]">chasses</span> au <span class="text-[#FF1818] ">trésor</span> du
                capitaine et de son équipage !
            </h1>

            <p class="text-xl lg:text-2xl mb-6 font-merienda">
                Démarrez votre périple : des chasses au trésor à vivre entre le virtuel et le tangible
            </p>

            <div class="absolute bottom-16 left-1/2 transform -translate-x-1/2">
                <a href="/enigme"
                    class="inline-flex items-center bg-[#E3342F] text-white
                            px-2 py-2
                            rounded-lg sm:rounded-xl
                            hover:bg-[#CC1F1A] transition-all duration-300">
                    <span class="text-base sm:text-lg font-merienda">Essayez de résoudre les énigmes</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 transform rotate-[45deg] ml-1"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                </a>
            </div>
        </div>
    </section>
    <!-- ============================== -->
    <!-- SECTION VIDÉO & DESCRIPTION -->
    <!-- ============================== -->



    <section class="py-16 bg-[#FEA250]/12">
        <div class="container mx-auto px-4">
            <!-- Texte centré en haut -->
            <div class="text-center max-w-3xl mx-auto mb-12 font-merienda font-[300]">
                <h2 class="text-white text-xl lg:text-2xl md:text-2xl font-semibold mb-4">
                    Hey ! les pirates ?
                </h2>
                <p class="text-white text-xl md:text-2xl mb-2">
                    Regarde la vidéo, elle va t'expliquer comment nos<br>
                    chasses au trésor se passent !
                </p>
                <p class="text-[#E3342F] text-2xl md:text-3xl font-bold">
                    Bonne lecture, pirate!
                </p>
            </div>

            <!-- Conteneur vidéo avec coins arrondis et bordure blanche -->
            <div class="max-w-4xl mx-auto">
                <div class="relative rounded-[2rem] bg-white p-3">
                    <!-- Ratio 16:9 pour la vidéo -->
                    <div class="relative w-full rounded-[1.5rem] overflow-hidden" style="padding-top: 56.25%;">
                        <!-- Contrôles vidéo personnalisés -->
                        <div class="absolute inset-0 bg-black">
                            <video class="w-full h-full object-cover" poster="{{ asset('images/vidéo.jpg') }}"
                                controls>
                                <source src="{{ asset('vidéo/vidéo.mp4') }}" type="video/mp4">
                            </video>

                            <!-- Barre de contrôle personnalisée -->
                            {{-- <div
                                class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-4">
                                <div class="flex items-center gap-4 text-white">
                                    <!-- Boutons de contrôle -->
                                    <button class="hover:text-[#E3342F]">
                                        <i class="fas fa-volume-up"></i>
                                    </button>
                                    <button class="hover:text-[#E3342F]">
                                        <i class="fas fa-backward"></i>
                                    </button>
                                    <button class="hover:text-[#E3342F]">
                                        <i class="fas fa-play"></i>
                                    </button>
                                    <button class="hover:text-[#E3342F]">
                                        <i class="fas fa-forward"></i>
                                    </button>
                                    <button class="hover:text-[#E3342F]">
                                        <i class="fas fa-redo"></i>
                                    </button>

                                    <!-- Barre de progression -->
                                    <div class="flex-1 mx-4">
                                        <div class="h-1 bg-white/30 rounded-full">
                                            <div class="h-full w-1/3 bg-white rounded-full"></div>
                                        </div>
                                    </div>

                                    <!-- Durée -->
                                    <span class="text-sm">0:51 / 3:25</span>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ============================== -->
    <!-- SECTION GALERIE / CAROUSEL -->
    <!-- ============================== -->




    <section class="py-8 md:py-16 bg-[#000000] font-merienda">
        <div class="container mx-auto px-4">
            <h2 class="text-white text-center text-xl lg:text-2xl md:text-2xl font-merienda mb-10">
                Inscris-toi vite à la prochaine <br> <span class="text-red-500">chasse au trésor !</span>
            </h2>

            <div class="relative overflow-hidden font-rubik">
                <div id="carousel" class="flex transition-transform duration-500 ease-in-out"></div>

                <button id="prev" class="absolute left-[-3px] top-1/2 transform -translate-y-1/2 border-2 border-[#EB0000] rounded-full w-10 h-10 flex items-center justify-center transition-all duration-300 ">
                    <i class="fas fa-chevron-left text-[#EB0000] "></i>
                </button>

                <button id="next" class="absolute right-[-1px] top-1/2 transform -translate-y-1/2 border-2 border-[#EB0000] rounded-full w-10 h-10 flex items-center justify-center transition-all duration-300  ">
                    <i class="fas fa-chevron-right text-[#EB0000]"></i>
                </button>

                <div class="flex justify-center space-x-2 mt-6 sm:mt-8" id="indicators">
                    @for ($i = 0; $i < 6; $i++)
                        <button class="w-2 h-2 sm:w-3 sm:h-3 rounded-full bg-gray-300  transition-colors" data-slide="{{ $i }}"></button>
                        @endfor
                </div>
            </div>
        </div>

        <style>
            .participer-button {
                font-family: 'Rubik', sans-serif;
                font-size: 15px;
            }

            #carousel {
                display: flex;
                transition: transform 0.5s ease-in-out;
            }

            .active-slide {
                transform: scale(1.1);
                z-index: 10;
                transition: transform 0.5s ease;
            }

            .inactive-slide {
                transform: scale(0.95);
                transition: transform 0.5s ease;
            }

            #prev i,
            #next i {
                transition: color 0.3s ease;
            }

            #prev:hover i,
            #next:hover i {
                color: white;
            }

            @media (max-width: 639px) {
                #carousel>div {
                    width: 100%;
                }

                .inactive-slide {
                    transform: scale(1);
                }
            }

            @media (min-width: 640px) {
                #carousel>div {
                    width: 33.333%;
                }
            }
        </style>

        <script>
            const imageBaseUrl = "{{ asset('images') }}";
            const slideData = [{
                    icon: 'fa-user',
                    title: 'Chasse Physique',
                    extra: ''
                },
                {
                    icon: 'fa-calendar-alt',
                    title: 'Chasse au trésor',
                    extra: '<div class="text-lg">15 Février 2025</div><div class="text-red-500 text-3xl font-extrabold">5.000.000€</div>'
                },
                {
                    icon: 'fa-laptop',
                    title: 'Chasse Numérique',
                    extra: ''
                },
                {
                    icon: 'fa-map',
                    title: 'Chasse Aventure',
                    extra: ''
                },
                {
                    icon: 'fa-trophy',
                    title: 'Chasse Compétition',
                    extra: ''
                },
                {
                    icon: 'fa-gem',
                    title: 'Chasse Précieuse',
                    extra: ''
                }
            ];

            const carousel = document.getElementById('carousel');
            const indicators = document.querySelectorAll('#indicators button');
            let currentIndex = 0;
            let isAnimating = false;
            const totalSlides = 6;
            let visibleSlides = window.innerWidth < 640 ? 1 : 3;

            function generateSlides() {
                carousel.innerHTML = '';
                const slidesToShow = totalSlides + visibleSlides * 2;
                for (let i = -visibleSlides; i < totalSlides + visibleSlides; i++) {
                    const idx = (i + totalSlides) % totalSlides;
                    const slide = slideData[idx];
                    const slideElement = document.createElement('div');
                    slideElement.className = 'flex-shrink-0 w-full md:w-1/3 p-4';
                    const imageUrl = `${imageBaseUrl}/carte${(idx % 3) + 1}.jpg`;
                    slideElement.innerHTML = `
                        <a href="/appele">
                            <div class="relative bg-cover bg-center rounded-2xl shadow-lg border border-gray-500 overflow-hidden h-96 flex flex-col items-center justify-center text-white"
                                style="background-image: url('${imageUrl}');">
                                <div class="absolute inset-0 bg-black opacity-50"></div>
                                <div class="relative text-center">
                                    <i class="fas ${slide.icon} text-4xl mb-2"></i>
                                    <div class="text-2xl font-bold">${slide.title}</div>
                                    ${slide.extra}
                                    <button class="participer-button mt-4 bg-red-500 text-white py-2 px-6 rounded-full text-lg font-semibold shadow-md hover:bg-red-700 transition font-rubik">PARTICIPER</button>
                                </div>
                            </div>
                        </a>
                    `;
                    carousel.appendChild(slideElement);
                }
            }

            window.addEventListener('resize', () => {
                const newVisibleSlides = window.innerWidth < 640 ? 1 : 3;
                if (newVisibleSlides !== visibleSlides) {
                    visibleSlides = newVisibleSlides;
                    generateSlides();
                    updateCarousel(true);
                }
            });

            function updateCarousel(instant = false) {
                const slideWidthPercentage = 100 / visibleSlides;
                const offset = (currentIndex + visibleSlides) * slideWidthPercentage * -1;

                if (instant) {
                    carousel.style.transition = 'none';
                    carousel.style.transform = `translateX(${offset}%)`;
                    setTimeout(() => {
                        carousel.style.transition = 'transform 0.5s ease-in-out';
                    }, 0);
                } else {
                    carousel.style.transform = `translateX(${offset}%)`;
                }

                indicators.forEach((indicator, index) => {
                    indicator.classList.toggle('bg-[#E3342F]', index === (currentIndex % totalSlides));
                    indicator.classList.toggle('bg-gray-300', index !== (currentIndex % totalSlides));
                });

                const slides = carousel.children;
                Array.from(slides).forEach((slide, index) => {
                    slide.classList.remove('active-slide', 'inactive-slide');
                    const slidePosition = index - (currentIndex + visibleSlides);

                    if (visibleSlides === 3) {
                        if (slidePosition === 1) {
                            slide.classList.add('active-slide');
                        } else {
                            slide.classList.add('inactive-slide');
                        }
                    } else {
                        if (slidePosition === 0) {
                            slide.classList.add('active-slide');
                        }
                    }
                });

                if (!instant && (currentIndex >= totalSlides || currentIndex < 0)) {
                    setTimeout(() => {
                        currentIndex = currentIndex >= totalSlides ? 0 : totalSlides - 1;
                        updateCarousel(true);
                    }, 500);
                }
            }

            function handleNavigation(direction) {
                if (isAnimating) return;
                isAnimating = true;

                currentIndex += direction;
                updateCarousel();

                setTimeout(() => {
                    isAnimating = false;
                }, 500);
            }

            function goToSlide(index) {
                if (isAnimating) return;
                isAnimating = true;

                currentIndex = index;
                updateCarousel();

                setTimeout(() => {
                    isAnimating = false;
                }, 500);
            }

            // Fonction pour l'auto-défilement basé sur les points
            function autoSlide() {
                if (isAnimating) return;
                currentIndex = (currentIndex + 1) % totalSlides; // Passe au slide suivant (0 à 5)
                goToSlide(currentIndex);
            }

            document.getElementById('next').addEventListener('click', () => handleNavigation(1));
            document.getElementById('prev').addEventListener('click', () => handleNavigation(-1));

            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => goToSlide(index));
            });

            generateSlides();
            updateCarousel();

            // Auto-slide toutes les 4 secondes
            let autoSlideInterval = setInterval(autoSlide, 4000);

            const carouselContainer = carousel.parentElement;
            carouselContainer.addEventListener('mouseover', () => clearInterval(autoSlideInterval));
            carouselContainer.addEventListener('mouseout', () => {
                autoSlideInterval = setInterval(autoSlide, 4000);
            });
        </script>
    </section>


    <!-- SECTION CARTE BLANCHE (IMAGE & TEXTE) -->
    <section class="py-8 md:py-16 bg-[#FEA250]/12">
        <div class="container mx-auto px-4">
            <!-- Changement de flex-row à flex-col sur mobile -->
            <div class="flex flex-col lg:flex-row items-center justify-center gap-8 lg:gap-20">

                <!-- Cadre carré responsive -->
                <div class="w-full sm:w-[400px] lg:w-[450px] h-[300px] sm:h-[400px] lg:h-[450px] bg-white rounded-3xl">
                    <img src="assets/carte-blanche.jpg" alt="Carte Blanche"
                        class="w-full h-full object-cover rounded-3xl">
                </div>

                <!-- Bloc de texte responsive -->
                <div class="w-full sm:w-[500px] lg:w-[600px] mt-8 lg:mt-0 text-center lg:text-left font-merienda">
                    <h2 class="text-2xl sm:text-3xl lg:text-[30px] leading-tight font-semibold mb-2">
                        Lorem Ipsum is simply dummy<br class="hidden sm:block">
                        text dummy text
                    </h2>

                    <div class="mt-6 lg:mt-8 space-y-4 lg:space-y-6">
                        <p class="text-base sm:text-lg leading-relaxed px-4 lg:px-0">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            has
                            been the industry's standard dummy text ever since the 1500s, when an unknown printer
                            took a
                            galley of type and scrambled it to make a type specimen book.
                        </p>

                        <p class="text-base sm:text-lg leading-relaxed px-4 lg:px-0">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        </p>
                    </div>

                    <!-- Bouton Inscrivez-vous -->
                    <!-- Bouton Inscrivez-vous avec responsivité améliorée -->
                    <div class="flex justify-center lg:justify-start mt-6 sm:mt-8 mx-0">
                        <a href="/inscriptions"
                            class="inline-flex items-center bg-[#E3342F] text-white
                                            px-1 sm:px-6 lg:px-8
                                            py-1 sm:py-3 lg:py-4
                                            rounded-lg sm:rounded-xl
                                            hover:bg-[#CC1F1A] transition-all duration-300">
                            <span class="text-base sm:text-lg font-merienda">Inscrivez-Vous</span>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 sm:h-5 sm:w-5 transform rotate-[45deg] ml-2 sm:ml-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                        </a>
                    </div>


                </div>
            </div>
        </div>
    </section>




    <style>
        /* Styles supplémentaires si nécessaire */
        .aspect-square {
            aspect-ratio: 1 / 1;
        }
    </style>


    <!-- ============================== -->
    <!-- SECTION OPTIONS DE CHASSE AU TRÉSOR -->
    <!-- ============================== -->

    <!-- ============================== -->
    <!-- SECTION CARTE BLANCHE (IMAGE & TEXTE) -->
    <!-- ============================== -->

    <!-- SECTION FUTURES CHASSES -->



    <section class="py-8 md:py-16 bg-black">
        <div class="container mx-auto px-4">
            <!-- Titres -->
            <div class="text-center mb-8 md:mb-12">
                <h2 class="text-3xl md:text-4xl lg:text-5xl header-title text-white mb-3 md:mb-4">
                    Les futures chasses au trésor à venir
                </h2>
                <h3 class="text-3xl md:text-4xl lg:text-5xl header-title text-[#FF1818]">
                    Je me pré-inscris !
                </h3>
            </div>

            <!-- Carrousel pour ÉCRANS PETITS -->
            <div class="lg:hidden">
                <div class="relative overflow-hidden" x-data="{ activeSlide: 1, totalSlides: 6 }" x-init="setInterval(() => { activeSlide = activeSlide === totalSlides ? 1 : activeSlide + 1 }, 3000)">
                    <div class="flex transition-transform duration-500 ease-in-out"
                        :style="{ transform: `translateX(-${(activeSlide - 1) * 100}%)` }">
                        <!-- Image 1 -->
                        <a href="/appele">
                            <div class="flex-shrink-0 w-full">
                                <img src="{{ asset('images/livre.png') }}" alt="Livre du trésor"
                                    class="w-full h-48 object-cover hover:scale-105 transition-transform duration-300">
                            </div>
                        </a>
                        <!-- Image 2 -->
                        <a href="/appele">
                            <div class="flex-shrink-0 w-full">
                                <img src="{{ asset('images/voiture.png') }}" alt="Voiture dans la montagne"
                                    class="w-full h-48 object-cover hover:scale-105 transition-transform duration-300">
                            </div>
                        </a>
                        <!-- Image 3 -->
                        <a href="/appele">
                            <div class="flex-shrink-0 w-full">
                                <img src="{{ asset('images/lingo.png') }}" alt="Lingots d'or"
                                    class="w-full h-48 object-cover hover:scale-105 transition-transform duration-300">
                            </div>
                        </a>
                        <!-- Image 4 -->
                        <a href="/appele">
                            <div class="flex-shrink-0 w-full">
                                <img src="{{ asset('images/lingo.png') }}" alt="Lingots d'or"
                                    class="w-full h-48 object-cover hover:scale-105 transition-transform duration-300">
                            </div>
                        </a>
                        <!-- Image 5 -->
                        <a href="/appele">
                            <div class="flex-shrink-0 w-full">
                                <img src="{{ asset('images/livre.png') }}" alt="Livre du trésor"
                                    class="w-full h-48 object-cover hover:scale-105 transition-transform duration-300">
                            </div>
                        </a>
                        <!-- Image 6 -->
                        <a href="/appele">
                            <div class="flex-shrink-0 w-full">
                                <img src="{{ asset('images/voiture.png') }}" alt="Voiture dans la montagne"
                                    class="w-full h-48 object-cover hover:scale-105 transition-transform duration-300">
                            </div>
                        </a>
                    </div>

                    <!-- Boutons de navigation -->
                    <button
                        class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/40 rounded-full p-2 transition-all duration-300"
                        @click="activeSlide = activeSlide === 1 ? totalSlides : activeSlide - 1">
                        <i class="fas fa-chevron-left text-black"></i>
                    </button>
                    <button
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/40 rounded-full p-2 transition-all duration-300"
                        @click="activeSlide = activeSlide === totalSlides ? 1 : activeSlide + 1">
                        <i class="fas fa-chevron-right text-black"></i>
                    </button>
                </div>
            </div>

            <!-- Grille d'images pour ÉCRANS GRANDS -->
            <div class="hidden lg:grid grid-cols-1 xs:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                <!-- Image 1 -->
                <a href="/appele">
                    <div class="rounded-2xl overflow-hidden h-full">
                        <img src="{{ asset('images/livre.png') }}" alt="Livre du trésor"
                            class="w-full h-48 xs:h-52 sm:h-56 md:h-64 object-cover hover:scale-105 transition-transform duration-300">
                    </div>
                </a>

                <!-- Image 2 -->
                <a href="/appele">
                    <div class="rounded-2xl overflow-hidden h-full">
                        <img src="{{ asset('images/voiture.png') }}" alt="Voiture dans la montagne"
                            class="w-full h-48 xs:h-52 sm:h-56 md:h-64 object-cover hover:scale-105 transition-transform duration-300">
                    </div>
                </a>

                <!-- Image 3 -->
                <a href="/appele">
                    <div class="rounded-2xl overflow-hidden h-full">
                        <img src="{{ asset('images/lingo.png') }}" alt="Lingots d'or"
                            class="w-full h-48 xs:h-52 sm:h-56 md:h-64 object-cover hover:scale-105 transition-transform duration-300">
                    </div>
                </a>

                <!-- Image 4 -->
                <a href="/appele">
                    <div class="rounded-2xl overflow-hidden h-full">
                        <img src="{{ asset('images/lingo.png') }}" alt="Lingots d'or"
                            class="w-full h-48 xs:h-52 sm:h-56 md:h-64 object-cover hover:scale-105 transition-transform duration-300">
                    </div>
                </a>

                <!-- Image 5 -->
                <a href="/appele">
                    <div class="rounded-2xl overflow-hidden h-full">
                        <img src="{{ asset('images/livre.png') }}" alt="Livre du trésor"
                            class="w-full h-48 xs:h-52 sm:h-56 md:h-64 object-cover hover:scale-105 transition-transform duration-300">
                    </div>
                </a>

                <!-- Image 6 -->
                <a href="/appele">
                    <div class="rounded-2xl overflow-hidden h-full">
                        <img src="{{ asset('images/voiture.png') }}" alt="Voiture dans la montagne"
                            class="w-full h-48 xs:h-52 sm:h-56 md:h-64 object-cover hover:scale-105 transition-transform duration-300">
                    </div>
                </a>
            </div>
        </div>
    </section>




    <style>
        /* Assurez-vous que ces styles sont bien présents dans votre fichier */
        .header-title {
            font-family: 'Pirata One', cursive;
        }
    </style>











    <!-- SECTION TÉMOIGNAGES -->




    <section class="py-8 md:py-16 bg-[#FEA2501F]" x-data="{
        activeSlide: 1,
        isVisible: false,
        totalSlides: 12,
        interval: null,
        getVisibleSlides() {
            return window.innerWidth < 640 ? 1 : window.innerWidth < 1024 ? 2 : 3;
        },
        getMaxSlides() {
            return Math.ceil(this.totalSlides / this.getVisibleSlides());
        },
        startAutoSlide() {
            this.interval = setInterval(() => {
                this.activeSlide = this.activeSlide >= this.getMaxSlides() ? 1 : this.activeSlide + 1;
            }, 5000);
        },
        stopAutoSlide() {
            if (this.interval) clearInterval(this.interval);
        },
        init() {
            this.startAutoSlide();
            window.addEventListener('resize', () => {
                this.stopAutoSlide();
                this.activeSlide = 1;
                this.startAutoSlide();
            });
            }
            }" x-init="init()"
        @mouseenter="stopAutoSlide()" @mouseleave="startAutoSlide()" x-intersect="isVisible = true">

        <div class="container mx-auto px-4">
            <!-- Titre principal avec animations -->
            <div class="text-center mb-8 md:mb-16 overflow-hidden">
                <h2 class="text-2xl sm:text-3xl md:text-4xl header-title text-[#FFFFFF] mb-3 md:mb-4 transform transition-all duration-1000 animate-slide-down"
                    :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 -translate-y-10'">
                    Partage ton aventure et remporte une réduction de
                </h2>
                <div class="text-[#FF1818] text-center">
                    <span
                        class="text-4xl sm:text-5xl md:text-6xl header-title inline-block transform transition-all duration-1000 delay-300 animate-scale-in"
                        :class="isVisible ? 'opacity-100 scale-100' : 'opacity-0 scale-50'">
                        10%
                    </span>
                    <span
                        class="text-2xl sm:text-3xl md:text-4xl header-title text-[#FFFFFF] block sm:inline transform transition-all duration-1000 delay-500 animate-slide-right"
                        :class="isVisible ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-10'">
                        sur tes prochaines participations à nos
                    </span>
                </div>
                <h3 class="text-2xl sm:text-3xl md:text-4xl header-title text-[#FF1818] mt-2 transform transition-all duration-1000 delay-700 animate-slide-up"
                    :class="isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'">
                    chasses au trésor !
                </h3>
            </div>



            <div class="relative overflow-hidden">
                <div class="flex transition-transform duration-500 ease-in-out" x-ref="slider"
                    :style="{ transform: `translateX(-${(activeSlide - 1) * (100 / getVisibleSlides())}%)` }">
                    <!-- Les témoignages -->
                    <template x-for="i in 12" :key="i">
                        <div class="carte flex-shrink-0 px-2 sm:px-4 w-full sm:w-1/2 lg:w-1/3">
                            <div class="bg-white rounded-3xl p-4 sm:p-6 md:p-8 shadow-lg border border-[#E3342F]/10 transform transition-all duration-300 hover:scale-105 hover:shadow-xl animate-fade-in"
                                :style="{ animationDelay: `${i * 100}ms` }">
                                <!-- En-tête du témoignage -->
                                <div class="flex flex-col sm:flex-row items-start sm:items-center mb-2 sm:mb-4">
                                    <!-- Photo de profil avec animation -->
                                    <div class="relative overflow-hidden mb-2 sm:mb-0 sm:mr-4">
                                        <img :src="`{{ asset('images/p') }}` + (((i - 1) % 3) + 1) + '.png'"
                                            class="w-12 h-12 sm:w-16 sm:h-16 rounded-full object-cover transform transition-all duration-300 hover:scale-110"
                                            :alt="`Témoin ${i}`">
                                    </div>
                                    <div class="flex-1 flex flex-col"> <!-- Ajout de flex-col ici -->
                                        <!-- Nom et localisation -->
                                        <h4 class="font-bold text-lg sm:text-xl mb-1 animate-fade-in"
                                            x-text="[ 'Viezh Robert', 'Yessica Christy', 'Kim Young Jou', 'Jean Dupont', 'Marie Martin', 'Luc Bernard', 'Sophie Chen', 'Marco Silva', 'Anna Kowalski', 'Thomas Mueller', 'Linda Johnson', 'Carlos Garcia' ][i-1]">
                                        </h4>

                                        <div class="textep mb-1">
                                            <p class="text-gray-600 text-sm sm:text-base animate-fade-in font-[800]"
                                                x-text="[ 'Warsaw, Poland', 'Shanxi, China', 'Seoul, Korea', 'Paris, France', 'Lyon, France', 'Marseille, France', 'Beijing, China', 'Lisbon, Portugal', 'Krakow, Poland', 'Berlin, Germany', 'London, UK', 'Madrid, Spain' ][i-1]">
                                            </p>
                                        </div>
                                        <p class="text-gray-600 text-sm sm:text-base animate-fade-in"
                                            x-text="[ 'Warsaw, Poland', 'Shanxi, China', 'Seoul, Korea', 'Paris, France', 'Lyon, France', 'Marseille, France', 'Beijing, China', 'Lisbon, Portugal', 'Krakow, Poland', 'Berlin, Germany', 'London, UK', 'Madrid, Spain' ][i-1]">
                                        </p>


                                    </div>
                                    <!-- Étoiles -->
                                    <div class="etoile mt-2 sm:mt-0 sm:ml-auto"> <!-- Ajustement de la marge -->
                                        <div class="flex">
                                            <template x-for="star in 5" :key="star">
                                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-yellow-400 fill-current transform transition-all duration-300 hover:scale-125 hover:rotate-180 animate-pulse-slow"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                </svg>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                <!-- Texte du témoignage -->
                                <p class="text-gray-700 text-sm sm:text-base leading-relaxed animate-fade-in">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                </p>
                            </div>
                        </div>
                    </template>
                </div>




                <button
                    class="absolute left-3 top-1/3 transform -translate-y-1/2 border-2 border-red-500 bg-transparent rounded-full w-10 h-10 flex items-center justify-center transition-all duration-300"
                    @click="activeSlide = activeSlide === 1 ? totalSlides : activeSlide - 1">
                    <i class="fas fa-chevron-left text-red-500"></i> <!-- Flèche rouge -->
                </button>
                <button
                    class="absolute right-2 top-1/3 transform -translate-y-1/2 border-2 border-red-500 bg-transparent rounded-full w-10 h-10 flex items-center justify-center transition-all duration-300"
                    @click="activeSlide = activeSlide === totalSlides ? 1 : activeSlide + 1">
                    <i class="fas fa-chevron-right text-red-500"></i> <!-- Flèche rouge -->
                </button>


                <!-- Points de navigation -->
                <div class="flex justify-center space-x-2 mt-6 sm:mt-8">
                    <template x-for="i in getMaxSlides()" :key="i">
                        <button @click="activeSlide = i; stopAutoSlide(); startAutoSlide();"
                            class="transform transition-all duration-300 hover:scale-150"
                            :class="{
                                'w-2 h-2 sm:w-3 sm:h-3 rounded-full': true,
                                'bg-[#E3342F] scale-125': activeSlide === i,
                                'bg-gray-300': activeSlide !== i
                            }">
                        </button>
                    </template>
                </div>
                <br>
            </div>






        </div>
    </section>




    <style>
        /* Animations de base */
        @keyframes slideDown {
            from {
                transform: translateY(-100px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(100px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideRight {
            from {
                transform: translateX(-100px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes scaleIn {
            from {
                transform: scale(0.5);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

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

        @keyframes bounceSlow {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes pulseSlow {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        /* Classes d'animation */
        .animate-slide-down {
            animation: slideDown 1s ease-out forwards;
        }

        .animate-slide-up {
            animation: slideUp 1s ease-out forwards;
        }

        .animate-slide-right {
            animation: slideRight 1s ease-out forwards;
        }

        .animate-scale-in {
            animation: scaleIn 1s ease-out forwards;
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        .animate-bounce-slow {
            animation: bounceSlow 3s ease-in-out infinite;
        }

        .animate-pulse-slow {
            animation: pulseSlow 2s ease-in-out infinite;
        }
    </style>






    <!-- ============================== -->
    <!-- FOOTER COMPLET -->
    <!-- ============================== -->
    <!-- FOOTER COMPLET -->

    <footer class="w-full bg-black text-white py-10 ">
        <div class="container mx-auto px-4">
            <!-- Section principale du footer -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 font-merienda">
                <!-- Colonne de gauche -->
                <div class="text-center md:text-left">
                    <div class="space-y-3 mb-6">
                        <a href="{{ route('pages.cgv')}}" class="block text-lg hover:text-gray-300 transition">CGV</a>
                        <a href="{{ route('pages.cgu')}}" class="block text-lg hover:text-gray-300 transition">CGU</a>
                        <a href="/Remboursement"
                            class="block text-lg hover:text-gray-300 transition">Remboursement</a>
                    </div>
                    <!-- Réseaux sociaux -->
                    <div class="flex justify-center md:justify-start space-x-6">
                        <a href="https://web.facebook.com/profile.php?id=100092185284129&_rdc=1&_rdr#"
                            class="text-2xl hover:text-gray-300 transition">
                            <i class="fab fa-facebook-square"></i>
                        </a>

                        <a href="https://www.youtube.com/@Elpirata_officiel"
                            class="text-2xl hover:text-gray-300 transition">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="https://www.snapchat.com/add/elpirata_off?invite_id=ElrPx61w&locale=fr_FR&share_id=CK3Fh2MXQCKcjGRLtXSC0Q&sid=622c513c3cb14e7dbe7dd45dc849cf6e&fbclid=IwAR2YqefBEnW9gDcGqYLd4ybcPGgcuLbTT_fWTA9tiN6jdLYWblX0QpuhUgE"
                            class="text-2xl hover:text-gray-300 transition">
                            <i class="fab fa-snapchat"></i>
                        </a>
                        <a href="https://www.tiktok.com/@elpirata_officiel?_t=8gyk7xbnf1v&_r=1&fbclid=iwar1hztoduwunlhuuncrgplmretnfh3rdirua1bwofg4w_zqio9zawkyjws4"
                            class="text-2xl hover:text-gray-300 transition">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        <a href="https://www.instagram.com/elpirata_officiel/?igshid=MzMyNGUyNmU2YQ%3D%3D&utm_source=qr&fbclid=IwAR2nqKxtebhj4L3P93WUhH-EJuUyyuYWzeBTyn9njtOlbQaclx7YsZN0m4M"
                            class="text-2xl hover:text-gray-300 transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>

                <!-- Colonne du centre -->
                <div class="text-center border-t md:border-t-0 pt-6 md:pt-0">
                    <div class="space-y-3">
                        <a href="/regles" class="block text-lg hover:text-gray-300 transition">Règles du jeu</a>
                        <a href="/nous" class="block text-lg hover:text-gray-300 transition">Qui
                            sommes-nous?</a>
                        <a href="/FAQ" class="block text-lg hover:text-gray-300 transition">FAQ</a>
                    </div>
                </div>

                <!-- Colonne de droite -->
                <div class="text-center md:text-right border-t md:border-t-0 pt-6 md:pt-0">
                    <div class="space-y-3 mb-6">
                        <p class="text-lg">Mardi à vendredi 10h / 16h</p>
                        <p class="text-lg">0678615358</p>
                    </div>
                    <a href="/contacte"
                        class="inline-block bg-white text-black font-semibold py-2 px-6 rounded hover:bg-gray-200 transition duration-200">
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



    <!-- Ajoutez ce script dans votre section head ou à la fin du body -->
    <script>
        document.addEventListener('alpine:init', () => {
            // Auto-rotation du carrousel
            setInterval(() => {
                const slider = document.querySelector('[x-data]').__x.$data;
                slider.activeSlide = slider.activeSlide === slider.slides ? 1 : slider.activeSlide + 1;
            }, 5000); // Change de slide toutes les 5 secondes
        });
    </script>

</body>

</html>
