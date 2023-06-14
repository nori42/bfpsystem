import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/sass/main.scss',
                'resoruces/sass/bootstrap.scss',
                'resources/css/printfsic.css',
                'resources/css/bootstrap-icons.css',
                'resources/css/reports.css',
                'resoruces/js/xlsx.full.min.js',
                'resoruces/js/exportToXLSX.js'
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
