import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';


export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/Front/Search.js',
                'resources/js/Front/Profile.js',
                'resources/js/Front/MyProfile.js',
                'resources/js/Front/TaskAndInvite.js',
                'resources/js/Front/Champions.js',
                'resources/js/Front/Wallet.js',
                'resources/js/Front/Games.js',
                'resources/js/Front/Tournaments.js',
                'resources/js/Front/Tournament.js',
                'resources/js/Front/MyTournaments.js',
            ],
            refresh: false,
        }),
    ],
    /*
    build: {
        outDir: '../public_html/kryptoarena.fun/build',
    },*/
});
