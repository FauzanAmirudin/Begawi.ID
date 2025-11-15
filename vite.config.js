import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcssV4 from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css", // Diproses dengan @tailwindcss/vite (Tailwind v4)
                "resources/css/umkm.css", // Diproses dengan @tailwindcss/vite (Tailwind v4)
                "resources/js/app.js",
            ],
            refresh: true,
        }),
        // @tailwindcss/vite memproses semua file yang menggunakan @import "tailwindcss"
        tailwindcssV4(),
    ],
});
