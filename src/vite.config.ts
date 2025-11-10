import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js-fsd/app/app.ts'],
            ssr: 'resources/js-fsd/app/ssr.ts',
            refresh: true,
        }),
        tailwindcss(),
        wayfinder({
            formVariants: true,
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
            '~': path.resolve(__dirname, 'resources/js-fsd'),
            '@app': path.resolve(__dirname, 'resources/js-fsd/app'),
            '@pages': path.resolve(__dirname, 'resources/js-fsd/pages'),
            '@widgets': path.resolve(__dirname, 'resources/js-fsd/widgets'),
            '@features': path.resolve(__dirname, 'resources/js-fsd/features'),
            '@entities': path.resolve(__dirname, 'resources/js-fsd/entities'),
            '@shared': path.resolve(__dirname, 'resources/js-fsd/shared'),
        },
    },
});
