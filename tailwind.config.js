/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./app/**/*.php",
        "./routes/**/*.php",
    ],
    theme: {
        extend: {
            // Custom Colors - Sesuai dengan CSS Variables di app.css
            colors: {
                // Emerald Green Palette (Primary Brand Color)
                emerald: {
                    green: "#2ecc71",
                    dark: "#059669",
                    light: "#34d399",
                    50: "#ecfdf5",
                    100: "#d1fae5",
                    200: "#a7f3d0",
                    300: "#6ee7b7",
                    400: "#34d399",
                    500: "#10b981",
                    600: "#059669",
                    700: "#047857",
                    800: "#065f46",
                    900: "#064e3b",
                },
                // Custom Brand Colors
                "warm-ivory": "#fff9f3",
                "charcoal-grey": "#1c1c1e",
            },
            // Custom Font Families
            fontFamily: {
                sans: ["Inter", "sans-serif"],
                manrope: ["Manrope", "sans-serif"],
                poppins: ["Poppins", "sans-serif"],
            },
            // Custom Gradients
            backgroundImage: {
                "gradient-accent": "linear-gradient(135deg, #059669, #34d399)",
                "gradient-emerald": "linear-gradient(135deg, #059669, #34d399)",
                "gradient-hero":
                    "linear-gradient(135deg, rgba(5, 150, 105, 0.9), rgba(52, 211, 153, 0.8))",
            },
            // Custom Animations
            animation: {
                float: "float 3s ease-in-out infinite",
                "pulse-glow": "pulse-glow 2s ease-in-out infinite",
                fadeInUp: "fadeInUp 0.8s ease-out forwards",
                bounceIn: "bounceIn 0.6s ease-out forwards",
                "liquid-underline": "liquid-underline 0.3s ease forwards",
            },
            // Custom Keyframes
            keyframes: {
                float: {
                    "0%, 100%": { transform: "translateY(0px)" },
                    "50%": { transform: "translateY(-10px)" },
                },
                "pulse-glow": {
                    "0%, 100%": {
                        boxShadow: "0 0 20px rgba(46, 204, 113, 0.3)",
                    },
                    "50%": { boxShadow: "0 0 40px rgba(46, 204, 113, 0.6)" },
                },
                fadeInUp: {
                    from: {
                        opacity: "0",
                        transform: "translateY(30px)",
                    },
                    to: {
                        opacity: "1",
                        transform: "translateY(0)",
                    },
                },
                bounceIn: {
                    "0%": {
                        opacity: "0",
                        transform: "scale(0.3)",
                    },
                    "50%": {
                        opacity: "1",
                        transform: "scale(1.05)",
                    },
                    "70%": {
                        transform: "scale(0.9)",
                    },
                    "100%": {
                        opacity: "1",
                        transform: "scale(1)",
                    },
                },
                "liquid-underline": {
                    "0%": { width: "0" },
                    "100%": { width: "100%" },
                },
            },
            // Custom Box Shadows
            boxShadow: {
                "glow-emerald": "0 10px 40px rgba(46, 204, 113, 0.3)",
                "glow-emerald-lg": "0 20px 60px rgba(46, 204, 113, 0.4)",
            },
            // Custom Spacing (jika diperlukan)
            spacing: {
                18: "4.5rem",
                88: "22rem",
                128: "32rem",
            },
            // Custom Border Radius
            borderRadius: {
                "4xl": "2rem",
            },
            // Custom Backdrop Blur
            backdropBlur: {
                xs: "2px",
            },
            // Custom Z-Index
            zIndex: {
                60: "60",
                70: "70",
                80: "80",
                90: "90",
                100: "100",
            },
        },
    },
    plugins: [
        // Plugin Tailwind untuk form styling dan typography
        // Catatan: Untuk Tailwind v4, beberapa plugin mungkin perlu konfigurasi tambahan
        // Uncomment jika diperlukan setelah install dependencies
        // require('@tailwindcss/forms'),
        // require('@tailwindcss/typography'),
    ],
    // Dark mode configuration (menggunakan data-theme attribute)
    // Untuk Tailwind v4, dark mode dikonfigurasi melalui CSS dengan @media (prefers-color-scheme: dark)
    // atau melalui selector seperti [data-theme="dark"]
    // Konfigurasi ini akan bekerja dengan JavaScript theme toggle yang ada di app.js
};
