import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import viteInput from "./viteInput";
export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/js/app.js",
                ...viteInput().js,
                "resources/css/app.css",
                "resources/sass/bootstrap.scss",
                ...viteInput().css,
            ],
            refresh: true,
        }),
    ],
});
