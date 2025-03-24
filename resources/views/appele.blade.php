<!DOCTYPE html>
<html lang="en" class="text-[60%] sm:text-[60%] md:text-[70%] lg:text-[100%]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Pirata</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!--<link rel="stylesheet" href="{{ asset('./appele.css') }}" >-->
    
    <!-- IMPORTATION DIRECTE DES FOTS MERIENDA, MARCELLUS, MARCELUS SC  -->
    <link href="https://fonts.googleapis.com/css2?family=Merienda&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Marcellus&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Marcellus+SC&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Merienda';
        }

        footer * {
            font-family: 'Marcellus';
        }

        footer .remboursenment {
            font-family: "Marcellus SC";
        }

        .marcellus {
            font-family: "Marcellus";
        }
        .all-marcellus *{
            font-family: "Marcellus";
        }
    </style>
</head>

<body class="p-0 m-0">
    <header
        class="h-20 sm:h-22 w-full bg-gradient-to-b from-black via-black/80 to-black/95 flex justify-between items-center pl-12 pr-12">
        <div class="flex justify-center items-center gap-8">
            <!--<i class="fa-solid fa-bars text-[#FFFFFF] text-4xl font-bold"></i>-->
            
            <div x-data="{ open: false }" class="all-marcellus" >
                <img @click="open = !open" src="{{ asset('images/imagesAppele/bar.png') }}" alt="BAR" class="cursor-pointer w-9">
                
                        <!-- Menu Mobile & Desktop -->
                        <div x-show="open" @click.outside="open = false"
                            class="absolute top-16 left-0 w-screen bg-[#1f1512] shadow-lg py-4 px-6
                                lg:w-64 lg:left-2 lg:right-2 z-50 transition-all duration-300 ease-in-out text-white"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-90"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-90">
                            <!-- Liens du menu -->
                            <a href="#hero" class="block px-4 py-2 hover:bg-[#E3342F] transition">Accueil</a>
                            <a href="#about" class="block px-4 py-2 hover:bg-[#E3342F] transition">Profil</a>
                            <a href="#services" class="block px-4 py-2 hover:bg-[#E3342F] transition">Les chasses au trésor</a>
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
            
            
             <h1 class="flex gap-2 font-bold">
                <span class="text-[#FFFFFF] text-3xl leading-none">El</span>
                <span class="text-[#FF1818] text-3xl leading-none tracking-[2px]">Pirata</span>
            </h1>
        </div>
        <div class="flex justify-center items-center gap-5">
            <!-- <i class="far fa-user text-[#FFFFFF] text-2xl"></i> -->
             <img src="{{ asset('images/imagesAppele/user.png') }}"  alt="USER" class="w-5">
            <div class="flex justify-center items-center gap-2">
                <img src="{{ asset('images/imagesAppele/flag-fr.png') }}"  alt="flag-fr" class="w-5">
                <h1 class="text-[#FFFFFF] text-md text-bold">FR</h1>
            </div>
        </div>
    </header>

    <main>
        <section class=" w-full h-fit flex justify-center items-center relative">
            <div class="absolute w-full h-full ">
                <img src="{{ asset('images/imagesAppele/el-pirata.png') }}"  alt="el-pirata" class="w-full h-full">
            </div>
            <div
                class="flex justify-center items-center p-[2rem] flex-col z-1 bg-[#00000080] w-full h-full xl:h-[calc(100vh - 2rem)]">
                <img src="{{ asset('images/imagesAppele/pirate.png') }}"  alt="pirate" class="w-[18rem]">
                <h1 class="text-[#FFFFFF] text-4xl m-6 font-bold">L'appel du <span
                        class="text-[#FF1818]">trésor</span>
                    maudit</h1>
                <p class="text-[#FFFFFF] text-2xl text-center">
                    Partez à l’aventure dans l’univers numérique <br> pour gagner le trésor sans sortir de chez vous !
                </p>
                <div class="flex w-[18rem] justify-between items-center mt-8">
                    <i
                        class="fas fa-chevron-left text-3xl text-[#FF1818] border border-[#FF1818] rounded-full pr-[8px]  pl-[8px] pt-2 pb-2  sm:pl-[15px] sm:pr-[15px] md:pl-[10px] lg:pl-[14px] md:pr-[10px] lg:pr-[14px] cursor-pointer"></i>
                    <i
                        class="fas fa-chevron-right text-3xl text-[#FF1818] border border-[#FF1818] rounded-full pr-[8px]  pl-[8px] pt-2 pb-2  sm:pl-[15px] sm:pr-[15px] md:pl-[10px] lg:pl-[14px] md:pr-[10px] lg:pr-[14px] cursor-pointer"></i>
                </div>
            </div>
        </section>

        <section class="bg-[#1e130a] flex justify-center items-center flex-col sm:gap-4 gap-2 pt-6">
            
            <div class="flex justify-center items-center flex-col gap-4 sm:p-4 max-h-fit relative">
                <h1 class="text-[#FF1818] sm:text-3xl text-2xl m-2">Chasse au trésor numérique</h1>
                <video id="videoPlayer" src="{{ asset('vidéo/vidéo.mp4') }}" class="sm:w-[40rem] w-[70%] rounded-3xl object-cover sm:border-[5px] border-[3px] border-white" poster="{{ asset('images/vidéo.jpg') }}"></video>
                <div class="absolute sm:bottom-8 bottom-4 bg-[#292929ee] p-4 sm:w-[90%] w-[65%] rounded-3xl">
                    <div class="flex items-center gap-4 text-white">
                        <button id="muteBtn" class="hover:text-[#E3342F]">
                            <i class="fas fa-volume-up"></i>
                        </button>
                        <button id="rewindBtn" class="hover:text-[#E3342F]">
                            <i class="fas fa-backward"></i>
                        </button>
                        <button id="playPauseBtn" class="hover:text-[#E3342F]">
                            <i class="fas fa-play"></i>
                        </button>
                        <button id="forwardBtn" class="hover:text-[#E3342F]">
                            <i class="fas fa-forward"></i>
                        </button>
                        <button id="restartBtn" class="hover:text-[#E3342F]">
                            <i class="fas fa-redo"></i>
                        </button>
                        <div class="flex-1 mx-4">
                            <div class="h-1 bg-white/30 rounded-full relative">
                                <div id="progressBar" class="h-full w-0 bg-white rounded-full"></div>
                            </div>
                        </div>
                        <span id="timeDisplay" class="text-sm">0:00 / 0:00</span>
            
                    </div>
                </div>
            </div>
            
            <script>
                const video = document.getElementById("videoPlayer");
                const playPauseBtn = document.getElementById("playPauseBtn");
                const muteBtn = document.getElementById("muteBtn");
                const rewindBtn = document.getElementById("rewindBtn");
                const forwardBtn = document.getElementById("forwardBtn");
                const restartBtn = document.getElementById("restartBtn");
                const progressBar = document.getElementById("progressBar");
                const timeDisplay = document.getElementById("timeDisplay");
            
                playPauseBtn.addEventListener("click", () => {
                    if (video.paused) {
                        video.play();
                        playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
                    } else {
                        video.pause();
                        playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
                    }
                });
            
                muteBtn.addEventListener("click", () => {
                    video.muted = !video.muted;
                    muteBtn.innerHTML = video.muted ? '<i class="fas fa-volume-mute"></i>' : '<i class="fas fa-volume-up"></i>';
                });
            
                rewindBtn.addEventListener("click", () => {
                    video.currentTime = Math.max(0, video.currentTime - 10);
                });
                
                forwardBtn.addEventListener("click", () => {
                    video.currentTime = Math.min(video.duration, video.currentTime + 10);
                });
            
                restartBtn.addEventListener("click", () => {
                    video.currentTime = 0;
                    video.play();
                    playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
                });
            
                video.addEventListener("timeupdate", () => {
                    const progress = (video.currentTime / video.duration) * 100;
                    progressBar.style.width = progress + "%";
            
                    let currentMinutes = Math.floor(video.currentTime / 60);
                    let currentSeconds = Math.floor(video.currentTime % 60);
                    let totalMinutes = Math.floor(video.duration / 60);
                    let totalSeconds = Math.floor(video.duration % 60);
            
                    if (currentSeconds < 10) currentSeconds = "0" + currentSeconds;
                    if (totalSeconds < 10) totalSeconds = "0" + totalSeconds;
            
                    timeDisplay.textContent = `${currentMinutes}:${currentSeconds} / ${totalMinutes}:${totalSeconds}`;
                });
            </script>
            
            
            <div class="flex justify-center items-center flex-col sm:gap-4 p-4 sm:mt-4">
                <p class="text-[#FFFFFF] text-xl text-center pl-6 mr-6 p-8 sm:w-[80%]">
                    Laissez-vous transporter par des paysages mystérieux, des cartes énigmatiques et l’ombre d’un
                    trésor enfoui Chaque image vous rapproche un peu plus de l’aventure…
                </p>
                <h1 class="sm:text-3xl text-2xl text-[#FF1818] sm:mt-4 sm:mb-6">Montant du trésor à gagner</h1>
                <div class="relative flex justify-center items-center w-fit m-4">
                    <img src="{{ asset('images/imagesAppele/back-tresor.png') }}"  alt="back-tresor" class="w-[36rem] brightness-75">
                    <div class=" flex flex-col z-1 justify-center items-center absolute  w-full h-[90%] -top-5 ">
                        <img src="{{ asset('images/imagesAppele/gold.png') }}"  alt="gold" class="w-[15rem]">
                        <p class="text-4xl font-bold text-[#FF1818] text-center ">€ 1000 €</p>
                    </div>
                </div>
                <div
                    class="rounded-3xl bg-[#58575740] flex justify-center items-center flex-col w-fit h-fit sm:p-10 p-5 sm:gap-8 gap-6 ">
                    <div class="flex justify-between items-center gap-2">
                        <img src="{{ asset('images/imagesAppele/flag-bone.png') }}"  alt="flag-bone" class="w-[5rem]">
                        <h1 class="sm:text-3xl text-2xl text-[#FF1818] font-bold">Récompense spéciale !</h1>
                        <img src="{{ asset('images/imagesAppele/flag-bone.png') }}"  alt="flag-bone" class="w-[5rem]">
                    </div>
                    <p class="text-[#FFFFFF] sm:text-2xl text-xl text-center ">
                        Les 9 chasseurs suivant le vainqueur
                        <br>gagneront une place
                        <br>gratuite pour une chasse au trésor de la
                        <br>même valeur !
                    </p>
                </div>
            </div>
            
            <div class=" all-marcellus mt-4 grid sm:gap-4 gap-2 justify-center items-center sm:p-8 p-4 ">
                <div class="grid grid-cols-2 gap-8 justify-center items-center">
                    <div class="grid gap-10 justify-center items-center">
                        <div
                            class="bg-[#58575740] h-34 sm:h-38 w-[18rem] sm:w-[25rem] rounded-3xl flex justify-center items-center flex-col py-2">
                            <span class="text-[#FFFFFF] text-[1.3rem] text-center sm:text-[1.5rem]">Prix
                                d'Inscription</span>
                            <span class="text-[#FFFFFF] text-[1.3rem] text-center sm:text-[1.5rem]">25 £</span>
                        </div>
                        <div class="w-full flex justify-center items-center">
                            <span
                                class="text-[#FFFFFF] text-[1.2rem] sm:text-[1.5rem] bg-[#58575740] px-4 py-2 rounded-full text-center w-fit ">
                                Niveau: Moyen
                            </span>
                        </div>
                    </div>
                    <div class="grid gap-10 justify-center items-center">
                        <div
                            class="bg-[#58575740] h-34 sm:h-38 w-[18rem] sm:w-[25rem] rounded-3xl grid place-items-center py-2 gap-2">
                            <span class="text-[#FFFFFF] text-[1.3rem] text-center sm:text-[1.7rem]">Départ</span>
                            <span class="text-[#FFFFFF] text-[1.3rem] text-center sm:text-[1.5rem]">Samedi 22
                                mars</span>
                            <span class="text-[#FFFFFF] text-[1.3rem] text-center sm:text-[1.5rem]">14H30</span>
                        </div>
                        <div class="w-full flex justify-center items-center">
                            <span
                                class="text-[#FFFFFF] text-[1.2rem] sm:text-[1.5rem] bg-[#58575740] px-4 py-2 rounded-full  items-center text-center w-fit">
                                +0/100 inscrit
                            </span>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-[#58575740] rounded-xl grid grid-cols-5 justify-center items-center sm:w-full w-[100%] mt-12 py-2 text-center">
                    <div class=" flex justify-center items-center h-20 border-r border-[#c4c4c4be]">
                        <p class="text-[#FFFFFF] sm:text-xl text-lg">00 <span class="text-[#FF1818]">Mois</span></p>
                    </div>
                    <div class=" flex justify-center items-center h-20 border-r border-[#c4c4c4be]">
                        <p class="text-[#FFFFFF] sm:text-xl text-lg">00 <span class="text-[#FF1818]">Jours</span></p>
                    </div>
                    <div class=" flex justify-center items-center h-20 border-r border-[#c4c4c4be]">
                        <p class="text-[#FFFFFF] sm:text-xl text-lg">00 <span class="text-[#FF1818]">Heures</span></p>
                    </div>
                    <div class=" flex justify-center items-center h-20 border-r border-[#c4c4c4be]">
                        <p class="text-[#FFFFFF] sm:text-xl text-lg">00 <span class="text-[#FF1818]">Minutes</span></p>
                    </div>
                    <div class=" flex justify-center items-center h-20 ">
                        <p class="text-[#FFFFFF] sm:text-xl text-lg">00 <span class="text-[#FF1818]">Secs</span></p>
                    </div>
                </div>
                <div class="flex justify-center items-center w-full p-5 mt-4">
                    <button type="button"
                        class=" marcellus text-[#FFFFFF] bg-[#EB0000] w-[16rem] text-2xl p-3 rounded-xl sm:shadow-md shadow-sm shadow-gray-500/50 cursor-pointer">
                        S'inscrire
                    </button>
                </div>
            </div>
        </section>

        <section class="bg-[#000000] flex flex-col justify-center items-center pt-[5rem] ">
            <div class="justify-center items-center flex flex-col">
                <h1 class="text-[#FFFFFF] text-2xl ">L'Appel du Trésor Maudit</h1>
                <div class="bg-[#EB0000] w-[15rem] h-[1px] m-4"></div>
            </div>
            <div
                class="flex justify-center items-center flex-col gap-[5rem] p-4 sm:mt-16 sm:mb-16 mt-8 mb-8 sm:w-[80%] w-full">
                <div class="flex justify-evenly items-center gap-[4rem] w-full">
                    <p class="text-[#FFFFFF] sm:w-[45%] w-[50%]  text-[1rem]">
                        Écoute bien, flibustier, car une occasion comme celle-ci ne se présente qu’une fois dans une vie
                        ! Un message codé a été trouvé dans une bouteille échouée sur la plage de la Tortue. Il parle
                        d’un trésor fabuleux, caché par le légendaire Capitaine Barbe-Sanglante, un monstre des mers
                        dont le nom seul fait tremble les plus braves. Mais attention, ce magot n’a jamais été pillé…
                        car ceux qui ont essayé n’en sont jamais revenus Et c’est là que toi, vaillant corsaire, entres
                        en jeu.
                    </p>
                    <img src="{{ asset('images/imagesAppele/history-paper-rouller.png') }}"  alt="history-paper-rouller"
                        class="sm:w-[16rem] w-[14rem]">
                </div>
                <div class="flex justify-evenly items-center gap-[4rem] w-full">
                    <img src="{{ asset('images/imagesAppele/safe-gold.png') }}"  alt="safe-gold" class="sm:w-[16rem] w-[14rem]">
                    <p class="text-[#FFFFFF] sm:w-[45%] w-[50%]  text-[1rem]">
                        La carte, à moitié brûlée, indique une destination: l’île du Crâne-Oublié. Entre ses falaises
                        tranchantes comme des lames et ses jungles grouillant de bêtes affamées, seul un esprit rusé et
                        un cœur d’acier pourront espérer survivre. Mais tu ne seras pas seul : une bande de pirates tout
                        aussi avides de fortune est sur le coup. Et certains préféreraient voir ton corps nourrir les
                        poissons plutôt que de partager le butin.
                    </p>
                </div>
                <div class="flex justify-evenly items-center gap-[4rem] w-full">
                    <p class="text-[#FFFFFF] sm:w-[45%] w-[50%]  text-[1rem]">
                        Ton navire est prêt, ton équipage attend tes ordres… Mais es-tu sûr de vouloir tenter ta chance
                        ? Car la légende dit que le trésor de Barbe-Sanglante n’est pas seulement protégé par des pièges
                        mortels… mais aussi par une malédiction qui transforme les voleurs en ombres errantes,
                        condamnées à hanter l’île pour l’éternité.
                    </p>
                    <img src="{{ asset('images/imagesAppele/compas.png') }}"  alt="compas" class="sm:w-[16rem] w-[14rem]">
                </div>
            </div>
        </section>
        
        <section class="all-marcellus bg-[#1e130a] flex justify-evenly items-center sm:gap-20 gap-6 sm:p-10 p-4 ">
            <img src="{{ asset('images/imagesAppele/history-paper-rouller.png') }}"  alt="history-paper-rouller" class="sm:w-[20rem] w-[14rem]">
            <div class="sm:w-[30rem] w-fit flex flex-col justify-center items-center ">
                <h1 class="sm:text-3xl text-2xl text-[#FFFFFF] sm:p-6 p-2">Règle du jeu</h1>
                <div class="flex flex-col justify-center items-center sm:gap-4 gap-2">
                    <p class="text-center text-[#FFFFFF]  text-[1rem] sm:mt-5 mt-3">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley
                        of type and scrambled it to make a type specimen book. It has survived not only five centuries,
                    </p>
                    <p class="text-center text-[#FFFFFF]  text-[1rem]">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    </p>
                </div>
                <button type="button"
                    class=" marcellus text-[#FFFFFF] bg-[#EB0000] sm:w-[16rem] w-[14rem] sm:text-2xl text-lg p-3 rounded-xl sm:shadow-md shadow-sm shadow-gray-500/50 m-7 cursor-pointer ">Voir
                    plus de détails</button>
            </div>
        </section>
    </main>

    <footer class="bg-[#000000] all-marcellus">
        <div
            class="flex justify-between pb-6 pl-4 pr-4 pt-8 s:pb-8 sm:pl-16 sm:pr-16 sm:pt-14 border-b border-[#FFFFFF]">
            <div class="flex flex-col sm:gap-4 gap-2">
                <a href="#" class="text-[#FFFFFF] text-lg">CGV</a>
                <a href="#" class="text-[#FFFFFF] text-lg">CGU</a>
                <a href="#" class="text-[#FFFFFF] text-lg remboursenment">Remboursement</a>
                <div class="flex gap-4 text-white">
                    <!--<i class="fab  fa-facebook"></i>-->
                    <!--<i class="fab  fa-snapchat"></i>-->
                    <!--<i class="fab  fa-tiktok"></i>-->
                    <!--<i class="fab  fa-instagram"></i>-->
                    <a href="#">
                        <img src="{{ asset('images/imagesAppele/facebook.png') }}"   alt="facebook" class="w-6">
                    </a>
                    <a href="#">
                        <img src="{{ asset('images/imagesAppele/snapchat.png') }}"   alt="snapchat" class="w-6">
                    </a>
                    <a href="#">
                        <img src="{{ asset('images/imagesAppele/tiktok.png') }}"  alt="tiktok" class="w-6">
                    </a>
                    <a href="#">
                        <img src="{{ asset('images/imagesAppele/instagram.png') }}"   alt="instagram" class="w-6">
                    </a>
                </div>
            </div>
            <div class="flex flex-col sm:gap-4 gap-2">
                <a href="#" class="text-[#FFFFFF] text-lg">Règle du jeu</a>
                <a href="#" class="text-[#FFFFFF] text-lg">Qui sommes-nous?</a>
                <a href="#" class="text-[#FFFFFF] text-lg">FAQ</a>
            </div>
            <div class="flex flex-col sm:gap-5 gap-3">
                <span class="text-[#FFFFFF] text-lg">Mardi à vendredi 10h / 16h</span>
                <span class="text-[#FFFFFF] text-lg">0678615358</span>
                <button type="button"
                    class=" marcellus bg-[#FFFFFF] w-[12rem] text-xl p-3 rounded-xl sm:shadow-md shadow-sm shadow-gray-500/50 cursor-pointer tracking-widest ">Contact</button>
            </div>
        </div>
        <div class="pb-4">
            <p class="text-[#FFFFFF] text-center p-4">Copyright &copy; 2025 elpirata Tous droits réservés</p>
        </div>
    </footer>
</body>

</html>