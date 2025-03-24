import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            buildDirectory: '../public_html/build', // Chemin relatif vers le dossier build dans public_html
        }),
    ],
    build: {
        // Assurez-vous que le chemin de sortie pointe vers public_html
        outDir: '../public_html/build',
        // Empêche Vite de vider le dossier de sortie
        emptyOutDir: false,
    },
});
