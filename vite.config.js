import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'


export default defineConfig({
    plugins: [
        vue({
            template: {
                compilerOptions: {
                    isCustomElement: (tag) => ['Navigation'].includes(tag),
                }
            }
        }),
        laravel([
            'resources/sass/app.scss',
            'resources/css/app.css',
            'resources/js/app.js',
        ]),
    ],
    optimizeDeps: {
        exclude: ['vue3-carousel']
    }
});
