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
    <link rel="stylesheet" href="{{ asset('./appele.css') }}" >
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
                            <a href="#hero" class="block px-4 py-2 hover:bg-[#E3342F] transition">Accueil</a>
                            <a href="#about" class="block px-4 py-2 hover:bg-[#E3342F] transition">Profil</a>
                            <a href="/chasse" class="block px-4 py-2 hover:bg-[#E3342F] transition">Les chasses au trésor</a>
                            <!-- <a href="#services" class="block px-4 py-2 hover:bg-[#E3342F] transition">Les chasses au trésor</a> -->
                            <a href="#gallery" class="block px-4 py-2 hover:bg-[#E3342F] transition">Commencer mon aventure</a>
                            <a href="#contact" class="block px-4 py-2 hover:bg-[#E3342F] transition">Avis</a>
                            <a href="/CGV" class="block px-4 py-2 hover:bg-[#E3342F] transition">CGV</a>
                            <a href="/CGU" class="block px-4 py-2 hover:bg-[#E3342F] transition">CGU</a>
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
                <a href="/connexion" class="w-5 h-5 flex items-center">
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
    <section class="relative bg-cover bg-center h-[70vh] font-merienda bg-[#ff1818]"
        style="background-image: url('{{ asset('images/banner.jpg') }}'); background-size: cover; background-position: center;">
        <!-- Overlay noir semi-transparent -->
        <div class="absolute inset-0 bg-black opacity-[0.1]"></div>
        <!-- Contenu centré (titre, sous-titre, CTA) -->
        <div class="container mx-auto relative z-10 flex flex-col items-start justify-end h-full text-center px-4 pb-12">
            <img src="{{ asset('images/pirate.png') }}" alt="pirate" class="w-[18rem] h-[18rem] mb-6 object-contain mx-auto">
            <!-- Ajuste la taille avec w-32 h-32 -->

            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="#" class="inline-flex items-center text-[20px] sm:text-[20px] md:text-[36px] font-medium text-[#FF1818]">
                            Accueil
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-[#FF1818] mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="#" class="ms-1 text-[20px] sm:text-[20px] md:text-[36px] font-medium text-[#FF1818] md:ms-2">Enigmes</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-[#FF1818] mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-[20px] sm:text-[20px] md:text-[36px] font-medium text-[#FF1818] md:ms-2">1/10</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <h1 class="sm:text-[30px] md:text-[30px] lg:text-[50px] xl:text-[74px] text-left font-black text-[30px] text-[#FFFFFF] mb-1 sm:mb-4 md:mb-4 mt-4 sm:mt-0 md:mt-0 font-[Merienda]">
                L'APPEL DU TRÉSOR MAUDIT
            </h1>

        </div>
    </section>


    <!-- ============================== -->
    <!-- SECTION ENIGME  -->
    <!-- ============================== -->



    <section class="py-16 bg-[#170f09]">
        <div class="mx-auto px-4 relative">
            <!-- Texte centré en haut -->
            <div class="text-center mx-auto mb-12 font-merienda font-[300] relative">
                <h2 class="text-white text-[25px] sm:text-[30px] md:text-[48px] font-semibold font-[Merienda]">
                    ENIGMES NUMERO 1
                </h2>


                <div class="w-full flex justify-center mt-6">
                    <div class="bg-no-repeat w-[300px] h-80 sm:w-[500px] sm:h-[500px] md:w-[700px] md:h-[700px] lg:w-[1000px] lg:h-[1000px] xl:w-[1920px] xl:h-[1920px] flex items-center justify-center bg-cover sm:bg-contain" style="background-image: url('http://127.0.0.1:8000/images/chasses/livre.png');background-position: center;padding-left: 20px;">
                        <div class="-translate-y-1/2 rotate-[-11deg] pl-0 pr-0 sm:pr-[0px] md:pr-[20px] lg:pr-[10px] xl:pr-[86px]  ml-[15%] sm:ml-[5%] xl:ml-[0%] mt-[90px] sm:mt-[0px] md:mt-[0px] lg:mt-[183px] rounded-md sm:w-[30%] md:w-[30%]">
                            <span class="text-black font-bold block text-[8px] md:text-[10px] lg:text-[20px] xl:text-[36px] sm:text-[8px] font-[Merienda] ml-[0] sm:ml-[3%] pr-[5%] text-left">
                                L'ÉNIGME DES RUNES CACHÉES
                            </span>
                            <p class=" text-[6px] md:text-[10px] lg:text-[20px] xl:text-[32px] sm:text-[8px] font-[Merienda] text-black text-justify mt-2 ml-[3%] pr-[5%] leading-relaxed">
                                Sur une île oubliée, le vieux pirate Erik a gravé des runes pour protéger son trésor. Voici sa phrase énigmatique :
                                <strong class="font-bold">"Chaque rune porte un secret, mais seules celles au nombre premier révèlent le chemin."</strong>
                            </p>
                        </div>

                        <div class="w-[52rem] h-[5rem] sm:w-[150px] sm:h-[250px] md:w-[200px] md:h-[180px] lg:w-[330px] lg:h-[250px] xl:w-[500px] xl:h-[400px] rotate-[-11deg] mr-[50px] -mt-[127px] sm:mt-[-180px] md:mt-[-220px] lg:mt-[-400px] xl:mt-[-800px] flex justify-center pl-0 sm:pl-[35px] md:pl-[0px]">
                            <img src="http://127.0.0.1:8000/images/chasses/img.jpeg" alt="img" class="w-full h-full object-contain sm:object-contain md:object-contain lg:object-contain xl:object-cover mr-0 sm:mr-0 md:mr-[-40px] lg:mr-[-20px] xl:mr-[-60px]">
                        </div>
                    </div>
                </div>

                <div class="text-white text-[25px] sm:text-[30pxpx] md:text-[48px] font-bold mt-8 flex justify-center font-[Marcellus]">
                    <span class="w-full sm:w-[80%] md:w-[80%] lg:w-1/2 text-center">Inscrit ta réponse dans le parchemin moussaillon !</span>
                </div>

                <div class="flex justify-center items-center h-10 my-5">
                    <div class="borer border-[1px] border-[#eb0000] w-80"></div>
                </div>

                <div class="w-full flex justify-center mt-6">
                    <div class="relative w-[1017px] h-[300px] md:h-[522px] sm:h-[522px]">
                        <img src="http://127.0.0.1:8000/images/chasses/fond-response.png" alt="response" class="w-full max-w-full h-full object-contain">

                        <div class="absolute top-[4rem] sm:top-[9rem] md:top-[7rem] left-12 sm:left-20 md:left-[15rem]">
                            <textarea type="text" class="border-none bg-transparent text-black placeholder-black w-full text-[25px] md:text-[36px] sm:text-[36px] font-[Pirata One]" placeholder="Votre réponse ..." rows="3"></textarea>
                        </div>

                        <div class="absolute bottom-[4rem] sm:bottom-[8rem] md:bottom-[5rem] right-6 sm:right-20 md:right-18 lg:right-[14rem]">
                            <button class="bg-[#ff1818] border-none text-white text-sm sm:text-[20px] md:text-[30px] p-1 rounded-xs font-[Marcellus]">Valider la réponse de l’énigme</button>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-6 gap-4 my-28 px-4 md:px-0">
                    <div class="col-span-6 sm:col-span-6 md:col-span-6 lg:col-span-8 md:col-start-1">
                        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-4">
                            <!-- Bloc Progression -->
                            <div class="h-auto w-full max-w-[800px] mx-auto">
                                <h2 class="uppercase text-[32px] sm:text-[40px] md:text-[48px] font-[Marcellus] text-center">Progression</h2>
                                <div class="flex justify-center items-center">
                                    <img src="{{ asset('images/chasses/pirate.png') }}" alt="img"
                                        class="w-[90%] max-w-[600px] h-auto object-cover">
                                </div>
                                <div class="-mt-6 sm:-mt-10">
                                    <p class="text-center text-[#FF1818] text-[50px] sm:text-[70px] md:text-[80px] font-[Marcellus]">30%</p>
                                </div>
                            </div>

                            <!-- Bloc Codes gagnés -->
                            <div class="h-auto w-full max-w-[800px] mx-auto">
                                <h2 class="uppercase text-[24px] sm:text-[32px] md:text-[48px] font-[Marcellus] mb-6 sm:mb-10 text-center md:text-left">
                                    Mes codes gagnés
                                </h2>
                                <div class="flex flex-col rounded-md border-[1px] border-[#FF1818] py-1 px-3 h-auto">
                                    <div class="text-left text-[18px] sm:text-[24px] md:text-[30px] py-2 px-4 my-1 border-b-[0.5px] border-zinc-400 font-[Marcellus]">
                                        <span>Code Enigme 1 : 67869393512</span>
                                    </div>
                                    <div class="text-left text-[18px] sm:text-[24px] md:text-[30px] py-2 px-4 my-1 border-b-[0.5px] border-zinc-400">
                                        <span class="font-[Marcellus]">Code Enigme 2</span>
                                    </div>
                                    <div class="text-left text-[18px] sm:text-[24px] md:text-[30px] py-2 px-4 my-1 border-b-[0.5px] border-zinc-400">
                                        <span class="font-[Marcellus]">Code Enigme 3</span>
                                    </div>
                                    <div class="text-left text-[18px] sm:text-[24px] md:text-[30px] py-2 px-4 my-1 border-b-[0.5px] border-zinc-400">
                                        <span class="font-[Marcellus]">Code Enigme 4</span>
                                    </div>
                                    <div class="text-left text-[18px] sm:text-[24px] md:text-[30px] py-2 px-4 my-1 border-b-[0.5px] border-zinc-400">
                                        <span class="font-[Marcellus]">Code Enigme 5</span>
                                    </div>
                                    <div class="text-left text-[18px] sm:text-[24px] md:text-[30px] py-2 px-4 my-1 border-b-[0.5px] border-zinc-400">
                                        <span class="font-[Marcellus]">Code Enigme 6</span>
                                    </div>
                                    <div class="mt-10 sm:mt-6 md:mt-10">
                                        <div class="flex justify-center">
                                            <img src="{{ asset('images/chasses/img-code.png') }}" alt="img" class="w-[100px] sm:w-[120px] md:w-[130px] h-auto object-cover">
                                        </div>
                                        <div>
                                            <p class="text-center text-[18px] sm:text-[24px] md:text-[30px] font-[Marcellus]">
                                                Code pour ouvrir le coffre au trésor <br>
                                                <span class="text-[#ff1818]">972664848499</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons Pagination -->
                    <div class="col-span-6 md:col-span-4 md:col-start-2 my-10">
                        <div class="inline-flex gap-1 sm:gap-2 md:gap-4 flex-wrap justify-center md:justify-start">
                            <button class="rounded-md bg-[#ff1818] text-white px-3 py-2 sm:px-4 font-[Marcellus]">Précédent</button>
                            <button class="rounded-full w-8 h-8 sm:w-10 sm:h-10 bg-[#ff1818] text-white flex justify-center items-center font-[Marcellus]">1</button>
                            <button class="rounded-full w-8 h-8 sm:w-10 sm:h-10 bg-[#d9d9d9] text-black flex justify-center items-center font-[Marcellus]">2</button>
                            <button class="rounded-full w-8 h-8 sm:w-10 sm:h-10 bg-[#d9d9d9] text-black flex justify-center items-center font-[Marcellus]">3</button>
                            <button class="rounded-full w-8 h-8 sm:w-10 sm:h-10 bg-[#d9d9d9] text-black flex justify-center items-center font-[Marcellus]">4</button>
                            <button class="rounded-full w-8 h-8 sm:w-10 sm:h-10 bg-[#d9d9d9] text-black flex justify-center items-center font-[Marcellus]">5</button>
                            <button class="rounded-full w-8 h-8 sm:w-10 sm:h-10 bg-[#d9d9d9] text-black flex justify-center items-center font-[Marcellus]">6</button>
                            <button class="rounded-md bg-[#ff1818] text-white px-3 py-2 sm:px-4 font-[Marcellus]">Suivant</button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>




    <!-- ============================== -->
    <!-- SECTION BOUTTON FIXED  -->
    <!-- ============================== -->

    <section>
        <div class="fixed right-[0.15rem] sm:right-5 md:right-5 top-[43%]">
            <button class="" onclick="toggleModal()">
                <img src="{{ asset('images/chasses/btn-image.png') }}" alt="pirate" class="w-16 h-16 sm:w-[100px] sm:h-[177px] md:w-[198px] md:h-[177px] mb-6 object-contain mx-auto -rotate-[22deg]">
            </button>
        </div>


        <style>
            #book {
                position: relative;
                width: 90%;
                height: 70vh;
                perspective: 1500px;
            }

            .page-pair {
                position: absolute;
                width: 100%;
                height: 100%;
                display: flex;
                justify-content: space-between;
                transition: transform 0.8s ease-in-out;
                transform-origin: center;
                backface-visibility: hidden;
            }

            .page {
                width: 50%;
                height: 100%;
                background: transparent;
                padding: 20px;
                box-sizing: border-box;
            }

            .page-pair.flipped {
                transform: rotateY(-180deg);
            }

            .controls {
                margin-top: 20px;
                display: flex;
                justify-content: center;
                gap: 10px;
            }

            button {
                padding: 10px 20px;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: 0.3s;
            }

            button:hover {
                transform: scale(1.05);
            }

            #book-container {
                width: 100%;
                height: 83vh;
                display: flex;
                justify-content: center;
                align-items: center;
                background-size: cover;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }

            .page:nth-child(odd) {
                padding: 0px 2px 0px 30px;
            }

            .page:nth-child(even) {
                padding: 0px 24px 0px 2px;
            }

            textarea {
                background-color: transparent;
                border: 0px;
            }

            textarea:focus-visible {
                outline: none;
            }

            .page-number {
                top: 10px;
                font-size: 18px;
                font-weight: bold;
                text-align: center;
                color: black;
            }

            .notepad-container {
                width: 100%;
                height: 90%;
                z-index: -1;
                border-radius: 5px;
                backdrop-filter: blur(3px);
            }

            .prevBtn,
            .nextBtn {
                width: 60px;
                height: auto;
                cursor: pointer;
                position: absolute;
                bottom: 0px;
            }

            .prevBtn {
                left: 35px;
                transform: scaleX(-1);
            }

            .nextBtn {
                right: 30px;
            }
        </style>


        <!-- ============================== -->
        <!-- MODAL BLOC NOTE  -->
        <!-- ============================== -->
        <div id="modal" class="fixed inset-0 hidden bg-black bg-opacity-70 items-center justify-center z-50 font-bold" style="font-family: 'Merienda', cursive;">
            <div class="relative w-full max-w-4xl h-[75vh] bg-cover bg-center p-8 flex items-center justify-center">
                <button class="absolute z-20 top-[0.5rem] right-[5.5rem] text-black text-3xl" onclick="closeModal()">&times;</button>
                <div id="book-container" style="background-image: url('{{ asset('images/chasses/block-note.png') }}'); background-size: contain; background-position: center; background-repeat: no-repeat;">
                    <div id="book">
                        <!-- Paires de pages -->
                        <div class="page-pair" id="page-1">
                            <div class="page">
                                <div class="page-number">1</div>
                                <div class="notepad-container">
                                    <textarea class="w-full h-full p-2 border rounded-md" placeholder="Ecrire ici ..."></textarea>
                                </div>
                                <img src="{{ asset('images/chasses/arrow.png') }}" class="prevBtn" alt="Précédent" />
                            </div>
                            <div class="page">
                                <div class="page-number">2</div>
                                <div class="notepad-container">
                                    <textarea class="w-full h-full p-2 border rounded-md" placeholder="Ecrire ici ..."></textarea>
                                </div>
                                <img src="{{ asset('images/chasses/arrow.png') }}" class="nextBtn" alt="Suivant" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        
        <!-- ============================== -->
        <!-- MODAL SUCCESS RESPONSE  -->
        <!-- ============================== -->
        <div id="modalBravo" class="fixed inset-0 hidden bg-black bg-opacity-70 items-center justify-center z-50 font-bold" style="font-family: 'Merienda', cursive;">
            <div class="relative w-full max-w-4xl h-[75vh] bg-cover bg-center p-8 flex items-center justify-center bg-black">
                <button class="absolute z-20 top-0 right-[2rem] text-white text-3xl" onclick="closeModal()">&times;</button>
                <div class="border rounded-lg border-slate-400">
                    <div>
                        <img src="{{ asset('images/pirate.png') }}" alt="pirate" class="w-[18rem] h-[18rem] mb-6 object-contain mx-auto">
                    </div>
                    <div class="flex justify-center">
                        <div class="w-[56%]">
                            <h2 class="uppercase text-center text-2xl mb-4">BIEN JOUÉ, <span class="text-[#FF1818]">Bravo !</span></h2>
                            <p class="text-center font-normal">Tu as trouvé l’énigme numéro 1. <br>
                                Le code t’aidera à ouvrir le coffre après avoir réussi à résoudre toutes les énigmes.</p>
                        </div>
                    </div>
                    <div class="flex justify-center items-center my-2">
                        <div class="flex items-center">
                            <img src="{{ asset('images/chasses/pirate-crane.png') }}" alt="pirate" class="w-10 px-2 h-10 object-contain">
                            <p class="text-[#FF1818] text-2xl">
                                9386365672
                            </p>
                            <img src="{{ asset('images/chasses/pirate-crane.png') }}" alt="pirate" class="w-10 px-2 h-10 object-contain">
                        </div>
                    </div>
                    <div class="mb-2 flex justify-center">
                        <img src="{{ asset('images/chasses/icons-ok.png') }}" alt="pirate" class="w-40 px-2 h-40 object-contain">
                    </div>
                    <div class="flex justify-center mb-4">
                        <div class="w-[80%]">
                            <p class="text-center font-normal">Les codes sont conservés dans l’espace « Mes codes gagnés »</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- ============================== -->
        <!-- MODAL BAD RESPONSE  -->
        <!-- ============================== -->
        <div id="modalLost" class="fixed inset-0 hidden bg-black bg-opacity-70 items-center justify-center z-50 font-bold" style="font-family: 'Merienda', cursive;">
            <div class="relative w-full max-w-4xl h-[75vh] bg-cover bg-center p-8 flex items-center justify-center bg-black">
                <button class="absolute z-20 top-0 right-[2rem] text-white text-3xl" onclick="closeModal()">&times;</button>
                <div class="border rounded-lg border-slate-400">
                    <div>
                        <img src="{{ asset('images/pirate.png') }}" alt="pirate" class="w-[18rem] h-[18rem] mb-6 object-contain mx-auto">
                    </div>
                    <div class="flex justify-center">
                        <div class="w-[56%]">
                            <h2 class="uppercase text-center text-2xl mb-4 text-[#FF1818]">Perdu !</h2>
                            <p class="text-center font-normal">Ton navire va couler, ce n’est pas la bonne solution.
                                Soit persévérant comme un pirate et lis bien l’énigme.</p>
                        </div>
                    </div>
                    <div class="mb-2 flex justify-center">
                        <img src="{{ asset('images/chasses/icons-perdu.png') }}" alt="pirate" class="w-60 px-2 h-60 object-contain">
                    </div>
                    <div class="flex justify-center mb-4">
                        <div class="w-[80%]">
                            <p class="text-center font-normal">Les codes sont conservés dans l’espace « Mes codes gagnés »</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <style>
        .animated {
            -webkit-animation-duration: 1s;
            animation-duration: 1s;
            -webkit-animation-fill-mode: both;
            animation-fill-mode: both;
        }

        .animated.faster {
            -webkit-animation-duration: 500ms;
            animation-duration: 500ms;
        }

        .fadeIn {
            -webkit-animation-name: fadeIn;
            animation-name: fadeIn;
        }

        .fadeOut {
            -webkit-animation-name: fadeOut;
            animation-name: fadeOut;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        .page-pair.flipped {
            transform: rotateY(-180deg);
        }
    </style>


    <style>
        /* Styles supplémentaires si nécessaire */
        .aspect-square {
            aspect-ratio: 1 / 1;
        }
    </style>



    <style>
        /* Assurez-vous que ces styles sont bien présents dans votre fichier */
        .header-title {
            font-family: 'Pirata One', cursive;
        }
    </style>



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
                        <a href="/CGV" class="block text-lg hover:text-gray-300 transition">CGV</a>
                        <a href="/CGU" class="block text-lg hover:text-gray-300 transition">CGU</a>
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

        function toggleModal() {
            document.getElementById('modal').classList.toggle('hidden')
            document.getElementById('modal').classList.toggle('flex')
        }

        function closeModal() {
            document.getElementById('modal').classList.toggle('hidden')
            document.getElementById('modal').classList.toggle('flex')
        }

        let currentPage = 0;
        let pagePairs = document.querySelectorAll('.page-pair');
        let countPages = pagePairs.length;
        const book = document.getElementById('book');

        function showPage(index) {
            pagePairs.forEach((pair, i) => {
                if (i === index) {
                    pair.style.display = 'flex';
                } else {
                    pair.style.display = 'none';
                }
            });
        }

        function addPage(numberpage) {
            countPages++;
            const pagePair = document.createElement('div');
            pagePair.classList.add('page-pair');
            pagePair.id = 'page-' + numberpage;
            const page1 = document.createElement('div');
            page1.classList.add('page');
            const pageNumber1 = document.createElement('div');
            pageNumber1.classList.add('page-number');
            pageNumber1.textContent = numberpage + 1;
            page1.appendChild(pageNumber1);
            const notepad1 = document.createElement('div');
            notepad1.classList.add('notepad-container');
            const textarea1 = document.createElement('textarea');
            textarea1.classList.add('w-full', 'h-full', 'p-2', 'border', 'rounded-md');
            textarea1.placeholder = "Ecrire ici ...";
            notepad1.appendChild(textarea1);
            const imgPrev = document.createElement('img');
            imgPrev.classList.add('prevBtn');
            imgPrev.src = "{{ asset('images/chasses/arrow.png') }}";
            imgPrev.alt = 'Précédent';
            page1.appendChild(notepad1);
            page1.appendChild(imgPrev);
            const page2 = document.createElement('div');
            page2.classList.add('page');
            const pageNumber2 = document.createElement('div');
            pageNumber2.classList.add('page-number');
            pageNumber2.textContent = numberpage + 2;
            page2.appendChild(pageNumber2);
            const notepad2 = document.createElement('div');
            notepad2.classList.add('notepad-container');
            const textarea2 = document.createElement('textarea');
            textarea2.classList.add('w-full', 'h-full', 'p-2', 'border', 'rounded-md');
            textarea2.placeholder = "Ecrire ici ...";
            notepad2.appendChild(textarea2);
            const imgNext = document.createElement('img');
            imgNext.classList.add('nextBtn');
            imgNext.src = "{{ asset('images/chasses/arrow.png') }}";
            imgNext.alt = 'Suivant';
            page2.appendChild(notepad2);
            page2.appendChild(imgNext);

            pagePair.appendChild(page1);
            pagePair.appendChild(page2);
            book.appendChild(pagePair);

            showPage(numberpage - 1);
            pagePairs = document.querySelectorAll('.page-pair');
            countPages = pagePairs.length;
            imgNext.addEventListener('click', () => {
                if (currentPage < countPages - 1) {
                    currentPage++;
                    showPage(currentPage);
                } else if (currentPage >= countPages - 1) {
                    countPages += 1;
                    addPage(currentPage + 2);
                    currentPage = currentPage + 1
                }

            });

            imgPrev.addEventListener('click', () => {
                if (currentPage > 0) {
                    currentPage--;
                    showPage(currentPage);
                }
            });
        }

        document.querySelectorAll('.nextBtn').forEach(button => {
            button.addEventListener('click', () => {
                if (currentPage < countPages - 1) {
                    currentPage++;
                    showPage(currentPage);
                } else if (currentPage >= countPages - 1) {
                    addPage(currentPage + 2);
                    currentPage = currentPage + 1
                }
            });
        });

        document.querySelectorAll('.prevBtn').forEach(button => {
            button.addEventListener('click', () => {
                if (currentPage > 0) {
                    currentPage--;
                    showPage(currentPage);
                }
            });
        });
        showPage(currentPage);
    </script>


</body>

</html>