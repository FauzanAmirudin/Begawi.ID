import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcssV4 from "@tailwindcss/vite";
import { resolve } from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css", // Diproses dengan PostCSS + Tailwind v3 (dengan prefix tw-)
                "resources/css/umkm.css", // Diproses dengan @tailwindcss/vite (Tailwind v4)
                "resources/js/app.js",
            ],
            refresh: true,
        }),
        // Plugin untuk memproses app.css dengan PostCSS + Tailwind v3
        {
            name: "tailwind-v3-postcss",
            enforce: "pre",
            transform(code, id) {
                if (id.includes("app.css") && !id.includes("node_modules")) {
                    // Biarkan PostCSS memproses app.css dengan tailwind v3
                    return null;
                }
            },
        },
        // @tailwindcss/vite hanya memproses file yang menggunakan @import "tailwindcss"
        // app.css menggunakan @tailwind base/components/utilities, jadi akan diproses oleh PostCSS
        tailwindcssV4(),
    ],
    css: {
        postcss: {
            // Gunakan postcss config khusus untuk app.css
            configFile: resolve(__dirname, "postcss.app.config.js"),
        },
    },
});
