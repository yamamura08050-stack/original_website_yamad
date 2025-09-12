import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/black-css/common-dark.css',
                'resources/black-css/settings-dark.css',
                'resources/black-css/workout-create-dark.css',
                'resources/black-css/workout-index-dark.css',
                'resources/black-css/login-black.css',
                'resources/black-css/reset-black.css',
                'resources/light-css/common-light.css',
                'resources/light-css/settings-light.css',
                'resources/light-css/workout-create-light.css',
                'resources/light-css/workout-index-light.css',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
});
