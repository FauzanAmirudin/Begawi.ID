// PostCSS config khusus untuk app.css (Tailwind v3)
import tailwindcss from "tailwindcss";
import autoprefixer from "autoprefixer";

export default {
    plugins: [
        tailwindcss("./tailwind.config.js"), // Menggunakan Tailwind v3 dengan prefix tw-
        autoprefixer,
    ],
};
