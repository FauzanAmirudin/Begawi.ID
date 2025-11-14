export default {
    plugins: {
        // Tidak menggunakan tailwindcss di sini karena:
        // - app.css akan diproses dengan tailwindcss v3 melalui PostCSS (dengan prefix tw-)
        // - umkm.css akan diproses dengan @tailwindcss/vite (v4)
        // Kita perlu memisahkan prosesnya di vite.config.js
        autoprefixer: {},
    },
};
