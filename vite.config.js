import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

import livewire from '@defstudio/vite-livewire-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js", "resources/js/hero-swiper.js"],
        }),
        
        livewire({
            refresh: ['resources/css/app.css'],
        }),
    ],
});
