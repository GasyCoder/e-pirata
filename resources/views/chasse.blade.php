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

    <link href="https://fonts.googleapis.com/css2?family=Marcellus&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Marcellus+SC&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Merienda&family=Poppins:wght@400;700&display=swap"
        rel="stylesheet">
    <!-- Font Awesome pour les icônes sociales -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('./appele.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Pirata+One&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
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

<body class="bg-[#2b1b17] text-white relative">

    <!-- ============================== -->
    <!-- HEADER -->
    <!-- ============================== -->


    <header class="fixed top-0 left-0 w-full z-50 h-20 bg-black">
        <nav class="relative px-2 py-4">

            <div class="mx-auto flex justify-between items-center">
                <div class="mt-2">
                    <a href="/" class="bg-transparent px-5 py-1  text-white hidden md:flex" role="button">
                        <span class="text-[24px] font-[Merienda] text-white font-[900] mr-3">
                            El
                        </span>

                        <span class="text-[24px] font-[Merienda] text-[#FF1818] font-[900]">
                            Pirata
                        </span>
                        <!-- <img src="{{ asset('images/chasses/el-pirata.png') }}" alt="pirate" class="w-[8rem] h-auto object-contain"> -->
                    </a>

                </div>

                <ul class="hidden md:flex space-x-6">
                    <li><a href="/" class="hover:text-[#FF1818] font-[Merienda] text-lg">Accueil</a></li>
                    <li><a href="#" class="hover:text-[#FF1818] font-[Merienda] text-lg">Profil</a></li>
                    <li class="flex relative group">
                        <a href="#" class="mr-1 hover:text-[#FF1818] font-[Merienda] text-lg">Chasses au Trésor</a>
                        <!-- Submenu starts -->
                        <ul class="absolute z-10 p-3 w-60 top-6 transform scale-0 group-hover:scale-100 transition duration-150 ease-in-out origin-top shadow-lg bg-black rounded-b-md">
                            <li class="hover:bg-slate-100 leading-8 px-2 rounded-sm hover:text-[#FF1818] font-[Merienda] text-lg"><a href="#">Les chasses</a></li>
                            <li class="hover:bg-slate-100 leading-8 px-2 rounded-sm hover:text-[#FF1818] font-[Merienda] text-lg"><a href="/chasse">Commencer l'aventure</a></li>
                        </ul>
                        <!-- Submenu ends -->
                    </li>
                    <li class="flex relative group">
                        <a href="#" class="mr-1 font-[Merienda] text-lg">Légal</a>
                        <!-- Submenu starts -->
                        <ul class="absolute bg-black rounded-b-md z-10 p-3 w-52 top-6 transform scale-0 group-hover:scale-100 transition duration-150 ease-in-out origin-top shadow-lg">
                            <li class="hover:bg-slate-100 leading-8 px-2 font-[Merienda] text-lg rounded-sm hover:text-[#FF1818]"><a href="/CGV">CGV</a></li>
                            <li class="hover:bg-slate-100 leading-8 px-2 font-[Merienda] text-lg rounded-sm hover:text-[#FF1818]"><a href="/CGU">CGU</a></li>
                            <li class="hover:bg-slate-100 leading-8 px-2 font-[Merienda] text-lg rounded-sm hover:text-[#FF1818]"><a href="/Remboursement">Remboursement</a></li>
                            <li class="hover:bg-slate-100 leading-8 px-2 font-[Merienda] text-lg rounded-sm hover:text-[#FF1818]"><a href="#">Règles du jeu</a></li>
                        </ul>
                        <!-- Submenu ends -->
                    </li>
                    <li class="flex relative group">
                        <a href="#" class="mr-1 hover:text-[#FF1818] font-[Merienda] text-lg">A propos</a>
                        <!-- Submenu starts -->
                        <ul class="absolute bg-black rounded-b-md z-10 p-3 w-52 top-6 transform scale-0 group-hover:scale-100 transition duration-150 ease-in-out origin-top shadow-lg">
                            <li class="hover:bg-slate-100 leading-8 font-[Merienda] text-lg px-2 rounded-sm hover:text-[#FF1818]"><a href="#">Qui sommes-nous</a></li>
                            <li class="hover:bg-slate-100 leading-8 font-[Merienda] text-lg px-2 rounded-sm hover:text-[#FF1818]"><a href="#">FAQ</a></li>
                            <li class="hover:bg-slate-100 leading-8 font-[Merienda] text-lg px-2 rounded-sm hover:text-[#FF1818]"><a href="#">Contact</a></li>
                            <li class="hover:bg-slate-100 leading-8 font-[Merienda] text-lg px-2 rounded-sm hover:text-[#FF1818]"><a href="#">Se désinscrire</a></li>
                        </ul>
                        <!-- Submenu ends -->
                    </li>
                    <!-- <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li> -->
                </ul>
                <div class="hidden md:flex gap-3 items-center">

                    <a href="/profile" class="w-[25px] h-[25px] flex items-center">
                        <img src="{{ asset('images/chasses/user.png') }}" alt="disconnect" class="w-full h-full object-contain">
                        <!-- <a href="#" class="bg-[#FF1818] px-5 py-1 rounded-3xl hover:bg-red-500 text-white hidden md:flex font-[Merienda] text-lg" role="button">Sign In</a> -->
                    </a>

                    <a href="/connexion" class="w-[25px] h-[25px] flex items-center">
                        <img src="{{ asset('images/chasses/sign-out-option.png') }}" alt="disconnect" class="w-full h-full object-contain">
                    </a>
                    <div class="flex items-center space-x-2">
                        <img src="https://upload.wikimedia.org/wikipedia/en/c/c3/Flag_of_France.svg" class="w-[20px] h-[20px]" alt="FR">
                        <span class="text-white font-normal text-lg font-[Merienda]">FR</span>
                    </div>
                </div>


                <!-- Mobile menu icon -->
                <button id="mobile-icon" class="md:hidden">
                    <i onclick="changeIcon(this)" class="fa-solid fa-bars"></i>
                </button>

            </div>

            <!-- Mobile menu -->
            <div class="md:hidden flex justify-center mt-3 w-full">
                <div id="mobile-menu" class="mobile-menu absolute top-23 w-full"> <!-- add hidden here later -->
                    <ul class="bg-black shadow-lg leading-9 font-bold h-screen">

                        <li><a href="/" class="hover:text-[#FF1818] font-[Merienda] text-lg">Accueil</a></li>
                        <li><a href="#" class="hover:text-[#FF1818] font-[Merienda] text-lg">Profil</a></li>
                        <li class="flex relative group">
                            <a href="#" class="mr-1 hover:text-[#FF1818] font-[Merienda] text-lg">Chasses au Trésor</a>
                            <!-- Submenu starts -->
                            <ul class="absolute bg-transparent z-10 p-3 w-60 top-6 transform scale-0 group-hover:scale-100 transition duration-150 ease-in-out origin-top shadow-lg">
                                <li class="hover:bg-slate-100 leading-8 px-2 rounded-sm hover:text-[#FF1818] font-[Merienda] text-lg"><a href="#">Les chasses</a></li>
                                <li class="hover:bg-slate-100 leading-8 px-2 rounded-sm hover:text-[#FF1818] font-[Merienda] text-lg"><a href="/chasse">Commencer l'aventure</a></li>
                            </ul>
                            <!-- Submenu ends -->
                        </li>
                        <li class="flex relative group">
                            <a href="#" class="mr-1 font-[Merienda] text-lg">Légal</a>
                            <!-- Submenu starts -->
                            <ul class="absolute bg-transparent z-10 p-3 w-52 top-6 transform scale-0 group-hover:scale-100 transition duration-150 ease-in-out origin-top shadow-lg">
                                <li class="hover:bg-slate-100 leading-8 px-2 font-[Merienda] text-lg rounded-sm hover:text-[#FF1818]"><a href="/CGV">CGV</a></li>
                                <li class="hover:bg-slate-100 leading-8 px-2 font-[Merienda] text-lg rounded-sm hover:text-[#FF1818]"><a href="/CGU">CGU</a></li>
                                <li class="hover:bg-slate-100 leading-8 px-2 font-[Merienda] text-lg rounded-sm hover:text-[#FF1818]"><a href="/Remboursement">Remboursement</a></li>
                                <li class="hover:bg-slate-100 leading-8 px-2 font-[Merienda] text-lg rounded-sm hover:text-[#FF1818]"><a href="#">Règles du jeu</a></li>
                            </ul>
                            <!-- Submenu ends -->
                        </li>
                        <li class="flex relative group">
                            <a href="#" class="mr-1 hover:text-[#FF1818] font-[Merienda] text-lg">A propos</a>
                            <!-- Submenu starts -->
                            <ul class="absolute bg-transparent z-10 p-3 w-52 top-6 transform scale-0 group-hover:scale-100 transition duration-150 ease-in-out origin-top shadow-lg">
                                <li class="hover:bg-slate-100 leading-8 font-[Merienda] text-lg px-2 rounded-sm hover:text-[#FF1818]"><a href="#">Qui sommes-nous</a></li>
                                <li class="hover:bg-slate-100 leading-8 font-[Merienda] text-lg px-2 rounded-sm hover:text-[#FF1818]"><a href="#">FAQ</a></li>
                                <li class="hover:bg-slate-100 leading-8 font-[Merienda] text-lg px-2 rounded-sm hover:text-[#FF1818]"><a href="#">Contact</a></li>
                                <li class="hover:bg-slate-100 leading-8 font-[Merienda] text-lg px-2 rounded-sm hover:text-[#FF1818]"><a href="#">Se désinscrire</a></li>
                            </ul>
                            <!-- Submenu ends -->
                        </li>
                    </ul>

                </div>
            </div>

        </nav>
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

        .mobile-menu {
            left: -200%;
            transition: 0.5s;
        }

        .mobile-menu.active {
            left: 0;
        }

        .mobile-menu ul li ul {
            display: none;
        }

        .mobile-menu ul li:hover ul {
            display: block;
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
    <section class="relative bg-cover bg-center h-[700px] font-merienda bg-[#ff1818]"
        style="background-image: url('{{ asset('images/banner.jpg') }}'); background-size: cover; background-position: center;">
        <!-- Overlay noir semi-transparent -->
        <div class="absolute inset-0 bg-black opacity-[0.1]"></div>
        <!-- Contenu centré (titre, sous-titre, CTA) -->
        <div class="container mx-auto relative z-1 flex flex-col items-start justify-end h-full text-center px-4 pb-2">
            <img src="{{ asset('images/pirate.png') }}" alt="pirate" class="w-[18rem] h-[18rem] mb-6 object-contain mx-auto">
            <!-- Ajuste la taille avec w-32 h-32 -->

            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="#" class="inline-flex items-center text-[20px] sm:text-[20px] md:text-[24px] medium text-[#FF1818] font-[Merienda] font-[900]">
                            Accueil
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-[#FF1818] mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="#" class="ms-1 text-[20px] sm:text-[20px] md:text-[24px] text-[#FF1818] md:ms-2 font-[Merienda] font-[900]">Enigmes</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-[#FF1818] mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-[20px] sm:text-[20px] md:text-[24px] text-[#FF1818] md:ms-2 font-[Merienda] font-[900]">1/10</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <h1 class="sm:text-[30px] md:text-[30px] lg:text-[34px] text-left text-[30px] text-[#FFFFFF] font-[900] font-[Merienda]">
                L'APPEL DU TRÉSOR MAUDIT
            </h1>

        </div>
    </section>


    <!-- ============================== -->
    <!-- SECTION ENIGME  -->
    <!-- ============================== -->

    <section class="lg:contain pt-16 bg-[#170f09] h-[550px] sm:h-[800px] md:h-[1000px] lg:h-[1100px] sm:mb-0 mb-44">
        <div class="mx-auto px-4 relative">
            <div class="text-center mx-auto font-merienda font-[300] relative">
                <h2 class="text-white text-[25px] sm:text-[24px] md:text-[28px] font-semibold font-[Merienda]">
                    ENIGMES NUMERO 1
                </h2>
                <div class="w-full flex justify-center mt-[150px] sm:mt-[150px] md:mt-[100px] xl:mt-[350px]">

                    <div class="bg-no-repeat -mt-[145px] xl:mt-[-350px] w-[370px] h-[380px] sm:w-[500px] sm:h-[500px] md:w-[700px] md:h-[700px] lg:w-[800px] lg:h-[800px] flex items-center justify-center bg-cover sm:bg-contain" style="background-image: url('{{ asset('images/chasses/livre.png') }}');background-position: center;padding-left: 44px;">
                        <div class="-translate-y-1/2 rotate-[-11deg] pl-[1%] pr-[4%] sm:pr-[0px] md:pr-[20px] lg:pr-[70px] ml-[10%] sm:ml-[5%] xl:ml-[14%] mt-[33%] sm:mt-[0px] md:mt-[0px] lg:mt-[70px] rounded-md sm:w-[40%] md:w-[50%] ">
                            <span class="text-black font-black block text-[7px] md:text-[10px] lg:text-[18px] sm:text-[8px] font-[Merienda] ml-[0] sm:ml-[3%] text-left">
                                L'ÉNIGME DES RUNES CACHÉES
                            </span>
                            <p class=" font-[500] text-[7px] md:text-[10px] lg:text-[14px] sm:text-[8px] font-[Merienda] text-black text-justify mt-2 ml-[3%] leading-relaxed">
                                Sur une île oubliée, le vieux pirate Erik a gravé des runes pour protéger son trésor. Voici sa phrase énigmatique :
                                <strong class="font-black">"Chaque rune porte un secret, mais seules celles au nombre premier révèlent le chemin."</strong>
                            </p>
                        </div>

                        <div class="w-[52rem] h-[auto] sm:w-[150px] sm:h-[250px] md:w-[200px] md:h-[180px] lg:w-[330px] lg:h-[200px] rotate-[-11deg] mr-[110px] -mt-[127px] sm:mt-[-180px] md:mt-[-220px] lg:mt-[-300px] flex justify-center pl-0 sm:pl-[35px] md:pl-[0px] lg:mr-[150px]">
                            <img src="{{ asset('images/chasses/img.jpeg') }}" alt="img" class="ml-[65px] sm:ml-0 w-full h-full sm:w-full sm:h-full x:w-full xl:h-full object-contain sm:object-contain md:object-cover lg:object-cover mr-0 sm:mr-0 md:mr-[-40px] lg:mr-[-20px] xl:mr-[10px] rounded-[5px]">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ============================== -->
    <!-- SECTION RESPONSE  -->
    <!-- ============================== -->

    <section class="py-16 -mt-[210px] bg-[#000000]">
        <div class="mx-auto px-4 relative">
            <!-- Texte centré en haut -->
            <div class="text-center mx-auto mb-12 font-merienda font-[300] relative">

                <div class="text-white text-[25px] sm:text-[24px] md:text-[28px] font-bold mt-8 flex justify-center font-[Marcellus]">
                    <span class="w-full sm:w-[80%] md:w-[80%] lg:w-1/2 text-center font-[800] font-[Merienda]">Inscrit ta réponse dans le parchemin moussaillon !</span>
                </div>

                <div class="flex justify-center items-center h-10 my-5">
                    <div class="borer border-[1px] border-[#eb0000] w-80"></div>
                </div>

                <div class="w-full flex justify-center mt-6">
                    <div class="relative w-[600px] h-[300px] md:h-[522px] sm:h-[522px]">
                        <img src="{{ asset('images/chasses/fond-response.png') }}" alt="response" class="w-full max-w-full h-full object-contain">

                        <div class="absolute top-[4rem] sm:top-[9rem] md:top-[8rem] left-12 sm:left-20 md:left-[8rem] w-[300px]" style="font-family: 'Pirata One' ">
                            <textarea type="text" class="border-none bg-transparent text-black placeholder-black w-full text-[18px]" style="font-family: 'Pirata One' " placeholder="Votre réponse ..." rows="3"></textarea>
                        </div>

                        <div class="absolute bottom-[4rem] sm:bottom-[8rem] md:bottom-[9rem] right-[5rem] sm:right-20 md:right-18 lg:right-20">
                            <button class="bg-[#ff1818] border-none font-[400] text-white text-sm sm:text-[16px] md:text-[18px] p-2 rounded-xs font-[Marcellus]">Valider la réponse de l’énigme</button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>


    <section class="pt-20 pb-4 bg-[#170f09]">
        <div class="lg:container mx-auto px-4 relative">
            <!-- Texte centré en haut -->
            <div class="text-center mx-auto mb-12 font-merienda font-[300] relative">

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-6 lg:grid-cols-2 xl:grid-cols-6 gap-4 px-4 md:px-0">
                    <div class="col-span-6 sm:col-span-6 md:col-span-6 lg:col-span-8 md:col-start-1">
                        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-2 2xl:grid-cols-2 gap-4">
                            <div class="h-auto w-fullmx-auto">
                                <h2 class="uppercase text-[16px] sm:text-[16px] md:text-[28px] font-[Merienda] text-center font-[400]">Progression</h2>
                                <div class="flex justify-center items-center">
                                    <img src="{{ asset('images/chasses/pirate.png') }}" alt="img"
                                        class="w-full h-[400px] object-contain">
                                </div>
                                <div class="my-4">
                                    <span class="text-[34px] font-merienda text-white font-[900] mr-3">
                                        El
                                    </span>

                                    <span class="text-[34px] font-merienda text-[#FF1818] font-[900]">
                                        Pirata
                                    </span>
                                </div>
                                <div class="mt-6">
                                    <p class="text-center text-[#FF1818] font-[400] text-[14px sm:text-[16px] md:text-[34px] font-[Merienda]">30%</p>
                                </div>
                            </div>

                            <div class="h-auto w-full mx-auto">
                                <h2 class="uppercase text-[25px] sm:text-[24px] md:text-[28px] font-[Merienda] mb-6 sm:mb-10 text-center font-[400]">
                                    Mes codes gagnés
                                </h2>
                                <div class="flex flex-col rounded-md border-[1px] border-[#FF1818] py-1 w-full h-full md:h-[550px]">
                                    <div class="bg-[#000000] px-3 py-1 h-[290px] overflow-y-auto" id="scrolCode">
                                        <div class="text-left text-[14px] sm:text-[14px] md:text-[18px] py-2 px-4 my-1 border-b-[0.5px] border-zinc-400 font-[Merienda]">
                                            <span>Code Enigme 1 : 67869393512</span>
                                        </div>
                                        <div class="text-left py-2 px-4 my-1 border-b-[0.5px] border-zinc-400">
                                            <span class="font-[Merienda] text-[14px] sm:text-[14px] md:text-[16px]">Code Enigme 2</span>
                                        </div>
                                        <div class="text-left py-2 px-4 my-1 border-b-[0.5px] border-zinc-400">
                                            <span class="font-[Merienda] text-[14px] sm:text-[14px] md:text-[16px]">Code Enigme 3</span>
                                        </div>
                                        <div class="text-left py-2 px-4 my-1 border-b-[0.5px] border-zinc-400">
                                            <span class="font-[Merienda] text-[14px] sm:text-[14px] md:text-[16px]">Code Enigme 4</span>
                                        </div>
                                        <div class="text-left py-2 px-4 my-1 border-b-[0.5px] border-zinc-400">
                                            <span class="font-[Merienda] text-[14px] sm:text-[14px] md:text-[16px]">Code Enigme 5</span>
                                        </div>
                                        <div class="text-left py-2 px-4 my-1 border-b-[0.5px] border-zinc-400">
                                            <span class="font-[Merienda] text-[14px] sm:text-[14px] md:text-[16px]">Code Enigme 6</span>
                                        </div>
                                        <div class="text-left py-2 px-4 my-1 border-b-[0.5px] border-zinc-400">
                                            <span class="font-[Merienda] text-[14px] sm:text-[14px] md:text-[16px]">Code Enigme 7</span>
                                        </div>
                                        <div class="text-left py-2 px-4 my-1 border-b-[0.5px] border-zinc-400">
                                            <span class="font-[Merienda] text-[14px] sm:text-[14px] md:text-[16px]">Code Enigme 8</span>
                                        </div>
                                        <div class="text-left py-2 px-4 my-1 border-b-[0.5px] border-zinc-400">
                                            <span class="font-[Merienda] text-[14px] sm:text-[14px] md:text-[16px]">Code Enigme 9</span>
                                        </div>
                                        <div class="text-left py-2 px-4 my-1 border-b-[0.5px] border-zinc-400">
                                            <span class="font-[Merienda] text-[14px] sm:text-[14px] md:text-[16px]">Code Enigme 10</span>
                                        </div>
                                    </div>
                                    <div class="mt-10 sm:mt-6 md:mt-4">
                                        <div class="flex justify-center">
                                            <img src="{{ asset('images/chasses/img-code.png') }}" alt="img" class="w-[100px] sm:w-[120px] md:w-[130px] h-auto object-cover">
                                        </div>
                                        <div class="">
                                            <p class="text-center text-[18px] sm:text-[20x] md:text-[24px] font-[Merienda] font-[400]">
                                                Code pour ouvrir le coffre au trésor <br>
                                                <span class="text-[#ff1818] font-[Merienda] font-[800]">972664848499</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-6 md:col-span-4 md:col-start-2 mt-20 md:mt-10">
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


    <style>
        #scrolCode::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.9);
            background-color: #000;
        }

        #scrolCode::-webkit-scrollbar {
            width: 6px;
            background-color: #444;
        }

        #scrolCode::-webkit-scrollbar-thumb {
            background-color: #fff;
        }
    </style>

    <!-- ============================== -->
    <!-- SECTION BOUTTON FIXED  -->
    <!-- ============================== -->

    <section>
        <div class="sticky right-0 " id="scrollButton">
            <button class="" onclick="toggleModal()">
                <img src="{{ asset('images/chasses/btn-image.png') }}" alt="pirate" class="w-16 h-16 sm:w-[50px] sm:h-[50px] md:w-[80px] md:h-[80px] mb-6 object-contain mx-auto -rotate-[22deg]">
            </button>
        </div>


        <style>
            #scrollButton {
                position: fixed;
                right: 20px;
                bottom: 20px;
                transition: bottom 0.3s ease-in-out;
            }

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

            @media (max-width:767px) {

                #book-container,
                #book {
                    height: 100% !important;
                }

                .page:nth-child(odd) {
                    padding: 0px 2px 0px 2px !important;
                }

                .page:nth-child(even) {
                    padding: 0px 2px 0px 2px !important;
                }
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
            <div class="relative w-full max-w-4xl h-[40vh] md:h-[75vh] bg-cover bg-center p-8 flex items-center justify-center">
                <button class="absolute z-20 top-[2rem] md:top-[0.5rem] right-[3.5rem] md:right-[6rem] text-black text-3xl" onclick="closeModal()">&times;</button>
                <div id="book-container" style="background-image: url('{{ asset('images/chasses/block-note.png') }}'); background-size: contain; background-position: center; background-repeat: no-repeat;">
                    <div id="book">
                        <!-- Paires de pages -->
                        <div class="page-pair" id="page-1">
                            <div class="page">
                                <div class="page-number">1</div>
                                <div class="notepad-container">
                                    <span class="header-title text-[12px] md:text-[20px] font-[400] text-black px-2">Aide toi de ton carnet pour résoudre les &nbsp;&nbsp;énigmes.</span>
                                    <textarea class="w-full header-title h-full p-2 border rounded-md placeholder-black text-black text-[12px] md:text-[20px] font-thin" placeholder="Écrire ici ..."></textarea>
                                </div>
                                <img src="{{ asset('images/chasses/arrow.png') }}" class="prevBtn" alt="Précédent" />
                            </div>
                            <div class="page">
                                <div class="page-number">2</div>
                                <div class="notepad-container">
                                    <textarea class="w-full h-full p-2 border text-black rounded-md placeholder-black "></textarea>
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
        <div class="mx-auto px-4">
            <!-- Section principale du footer -->
            <!-- <div class="grid grid-cols-1 md:grid-cols-3 gap-8 font-merienda"> -->

            <div class="grid grid-cols-1 md:grid-cols-5 gap-8 font-merienda">
                <!-- Colonne de gauche -->
                <div class="text-center md:text-left">
                    <div class="space-y-3 mb-6">
                        <a href="/CGV" class="block text-[18px] hover:text-gray-300 transition">CGV</a>
                        <a href="/CGU" class="block text-[18px] hover:text-gray-300 transition">CGU</a>
                        <a href="/Remboursement"
                            class="block text-[18px] hover:text-gray-300 transition">Remboursement</a>
                    </div>
                    <!-- Réseaux sociaux -->
                </div>
                <div class="hidden md:block"></div>
                <div class="text-left border-t md:border-t-0 pt-6 md:pt-0">
                    <div class="space-y-3">
                        <a href="/regles" class="block text-[18px] hover:text-gray-300 transition">Règles du jeu</a>
                        <a href="/nous" class="block text-[18px] hover:text-gray-300 transition">Qui
                            sommes-nous?</a>
                        <a href="/FAQ" class="block text-[18px] hover:text-gray-300 transition">FAQ</a>
                    </div>
                </div>
                <div class="hidden md:block"></div>

                <!-- Colonne du centre -->

                <!-- Colonne de droite -->
                <div class="text-left md:text-right border-t md:border-t-0 pt-6 md:pt-0">
                    <p class="text-[18px] text-left">Mardi à vendredi 10h / 16h</p>
                    <p class="text-[18px] text-left mt-3">0678615358</p>
                </div>
            </div>
            <div class="flex justify-between">

                <div class="flex justify-center md:justify-start space-x-6">
                    <a href="https://web.facebook.com/profile.php?id=100092185284129&_rdc=1&_rdr#"
                        class="text-2xl hover:text-gray-300 transition">
                        <i class="fab fa-facebook-square"></i>
                    </a>

                    <!-- <a href="https://www.youtube.com/@Elpirata_officiel"
                            class="text-2xl hover:text-gray-300 transition">
                            <i class="fab fa-youtube"></i>
                        </a> -->
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
                <div>

                    <a href="/contacte"
                        class="inline-block bg-white text-black font-semibold py-2 px-6 rounded-lg hover:bg-gray-200 transition duration-200">
                        Contact
                    </a>
                </div>
            </div>

            <!-- Séparation et copyright -->
            <div class="mt-8 pt-6 border-t border-white/20">
                <p class="text-[18px] text-center">
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
            textarea1.classList.add('w-full', 'h-full', 'p-2', 'border', 'rounded-md', 'text-black', 'font-thin');
            // textarea1.placeholder = "Ecrire ici ...";
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
            textarea2.classList.add('w-full', 'h-full', 'p-2', 'border', 'rounded-md', 'text-black', 'font-thin');
            // textarea2.placeholder = "Ecrire ici ...";
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

        // document.addEventListener("DOMContentLoaded", function() {
        //     let lastScrollTop = 0;
        //     let scrollButton = document.getElementById("scrollButton");
        //     let isDragging = false;
        //     let offsetX, offsetY;

        //     window.addEventListener("scroll", function() {
        //         if (!isDragging) {
        //             let scrollTop = window.scrollY || document.documentElement.scrollTop;
        //             if (scrollTop > lastScrollTop) {
        //                 scrollButton.style.bottom = "10px";
        //             } else {
        //                 scrollButton.style.bottom = "450px";
        //             }
        //             lastScrollTop = scrollTop;
        //         }
        //     });

        //     scrollButton.addEventListener("mousedown", function(e) {
        //         isDragging = true;
        //         offsetX = e.clientX - scrollButton.getBoundingClientRect().left;
        //         offsetY = e.clientY - scrollButton.getBoundingClientRect().top;
        //         scrollButton.style.transition = "none";
        //     });

        //     document.addEventListener("mousemove", function(e) {
        //         if (isDragging) {
        //             let newX = e.clientX - offsetX;
        //             let newY = e.clientY - offsetY;

        //             let maxX = window.innerWidth - scrollButton.offsetWidth;
        //             let maxY = window.innerHeight - scrollButton.offsetHeight;

        //             newX = Math.max(0, Math.min(newX, maxX));
        //             newY = Math.max(0, Math.min(newY, maxY));

        //             scrollButton.style.left = newX + "px";
        //             scrollButton.style.top = newY + "px";
        //             scrollButton.style.bottom = "auto";
        //             scrollButton.style.right = "auto";
        //         }
        //     });

        //     document.addEventListener("mouseup", function() {
        //         if (isDragging) {
        //             isDragging = false;
        //             scrollButton.style.transition = "bottom 0.3s ease-in-out";
        //         }
        //     });
        // });

        const mobile_icon = document.getElementById('mobile-icon');
        const mobile_menu = document.getElementById('mobile-menu');
        const hamburger_icon = document.querySelector("#mobile-icon i");

        function openCloseMenu() {
            mobile_menu.classList.toggle('block');
            mobile_menu.classList.toggle('active');
        }

        function changeIcon(icon) {
            icon.classList.toggle("fa-xmark");
        }

        mobile_icon.addEventListener('click', openCloseMenu);
    </script>


</body>

</html>