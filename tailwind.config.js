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
            // Custom Colors - Palet Warna Baru
            colors: {
                // Primary Green Palette (Brand Color)
                primary: {
                    DEFAULT: "#83CD20",
                    light: "#a5d85a",
                    lighter: "#c7e394",
                    dark: "#6ba41a",
                    darker: "#1A723D",
                    50: "#F1F5EB",
                    100: "#e8f0d8",
                    200: "#d1e1b1",
                    300: "#bad28a",
                    400: "#a3c363",
                    500: "#83CD20",
                    600: "#6ba41a",
                    700: "#1A723D",
                    800: "#14552e",
                    900: "#0e381f",
                },
                // Dark Navy (Text & Dark Backgrounds)
                navy: {
                    DEFAULT: "#0C1724",
                    light: "#1a2a3d",
                    lighter: "#283d56",
                    50: "#f0f2f5",
                    100: "#d9dee5",
                    200: "#b3bdcb",
                    300: "#8d9cb1",
                    400: "#677b97",
                    500: "#415a7d",
                    600: "#344763",
                    700: "#273549",
                    800: "#1a222f",
                    900: "#0C1724",
                },
                // Legacy support (mapping to new colors)
                emerald: {
                    green: "#83CD20",
                    dark: "#1A723D",
                    light: "#a5d85a",
                    50: "#F1F5EB",
                    100: "#e8f0d8",
                    200: "#d1e1b1",
                    300: "#bad28a",
                    400: "#a3c363",
                    500: "#83CD20",
                    600: "#6ba41a",
                    700: "#1A723D",
                    800: "#14552e",
                    900: "#0e381f",
                },
                // Custom Brand Colors
                "warm-ivory": "#F1F5EB",
                "charcoal-grey": "#0C1724",
            },
            // Custom Font Families
            fontFamily: {
                sans: ["Inter", "sans-serif"],
                manrope: ["Manrope", "sans-serif"],
                poppins: ["Poppins", "sans-serif"],
            },
            // Custom Gradients
            backgroundImage: {
                "gradient-accent": "linear-gradient(135deg, #1A723D, #83CD20)",
                "gradient-emerald": "linear-gradient(135deg, #1A723D, #83CD20)",
                "gradient-hero":
                    "linear-gradient(135deg, rgba(26, 114, 61, 0.9), rgba(131, 205, 32, 0.8))",
                "gradient-primary": "linear-gradient(135deg, #83CD20, #a5d85a)",
                "gradient-dark": "linear-gradient(135deg, #0C1724, #1A723D)",
                "gradient-light": "linear-gradient(135deg, #F1F5EB, #ffffff)",
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
                        boxShadow: "0 0 20px rgba(131, 205, 32, 0.3)",
                    },
                    "50%": { boxShadow: "0 0 40px rgba(131, 205, 32, 0.6)" },
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
                "glow-emerald": "0 10px 40px rgba(131, 205, 32, 0.3)",
                "glow-emerald-lg": "0 20px 60px rgba(131, 205, 32, 0.4)",
                "glow-primary": "0 10px 40px rgba(131, 205, 32, 0.3)",
                "glow-primary-lg": "0 20px 60px rgba(131, 205, 32, 0.4)",
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
