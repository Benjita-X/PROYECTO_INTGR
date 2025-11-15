import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path'; // <-- Asegúrate de importar 'path'

export default defineConfig({
    plugins: [
        laravel({
            // --- INICIO MODIFICACIÓN ---
            input: [
                'resources/sass/app.scss', // <-- Cambia css/app.css por sass/app.scss
                'resources/js/app.js'
            ],
            // --- FIN MODIFICACIÓN ---
            refresh: true,
        }),
    ],
    // --- INICIO SECCIÓN NUEVA ---
    // Añade esta sección para resolver las rutas de Bootstrap
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        }
    },
    // --- FIN SECCIÓN NUEVA ---
});