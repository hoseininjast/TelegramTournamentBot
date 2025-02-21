import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/Front/Games.js',
                'resources/js/Front/Tournaments.js',
            ],
            refresh: true,
        }),
    ],
    /*
    build: {
        outDir: '../public_html/kryptoarena.fun/build',
    },*/
});
