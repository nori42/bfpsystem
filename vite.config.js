import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/main.js',
                'resources/sass/main.scss'
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
          'chart.js': '../node_modules/chart.js', // Add this alias for Chart.js
        },
      },
});
