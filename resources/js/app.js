import './bootstrap';
import Alpine from 'alpinejs';
import { Howl, Howler } from 'howler';

window.Alpine = Alpine;
Alpine.start();

// Sons du jeu
const sounds = {
    success: new Howl({ src: ['/sounds/success.mp3'] }),
    error: new Howl({ src: ['/sounds/error.mp3'] }),
    hint: new Howl({ src: ['/sounds/hint.mp3'] }),
    waves: new Howl({
        src: ['/sounds/waves.mp3'],
        loop: true,
        volume: 0.1
    })
};

// Jouer les sons d'ambiance au premier clic
document.addEventListener('click', () => {
    if (!sounds.waves.playing()) {
        sounds.waves.play();
    }
}, { once: true });

// Gestionnaire d'événements pour les sons
window.playSound = (type) => {
    if (sounds[type]) {
        sounds[type].play();
    }
};

// Animation des vagues
document.addEventListener('DOMContentLoaded', () => {
    const waves = document.querySelectorAll('.wave');
    waves.forEach((wave, index) => {
        wave.style.animationDelay = `${index * -5}s`;
    });
});
