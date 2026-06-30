import tailwindcss from '@tailwindcss/vite';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/shared/app.css', 'resources/js/shared/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
