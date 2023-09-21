import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/sass/main.scss',
                'resources/css/printfsic.css',
                'resources/css/bootstrap-icons.css',
                'resources/css/pages/login.css', 
                'resources/css/utilities.css', 
                'resources/css/global.css', 
                'resources/css/reports.css',
            ],
            refresh: true,
        }),
    ],
});
