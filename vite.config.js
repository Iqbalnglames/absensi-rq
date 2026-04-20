import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import fs from 'fs';

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    // server: {
    //     https: {
    //         key: fs.readFileSync('localhost-key.pem'),
    //         cert: fs.readFileSync('localhost.pem'),
    //     },
    //     host: 'localhost',
    // },
});
