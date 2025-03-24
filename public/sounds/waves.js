// Création d'un son d'ambiance de vagues
const audioContext = new (window.AudioContext || window.webkitAudioContext)();

function createWaveSound() {
    const oscillator = audioContext.createOscillator();
    const gainNode = audioContext.createGain();
    
    oscillator.type = 'sine';
    oscillator.frequency.setValueAtTime(0.3, audioContext.currentTime);
    
    gainNode.gain.setValueAtTime(0.1, audioContext.currentTime);
    
    oscillator.connect(gainNode);
    gainNode.connect(audioContext.destination);
    
    return {
        start: () => {
            oscillator.start();
        },
        stop: () => {
            oscillator.stop();
        }
    };
}

export const waves = createWaveSound();
