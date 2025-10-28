import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // jouw palette
                background: "#111827",   // page bg
                navbar:     "#0B1120",   // top bar
                surface:    "#1F2937",   // cards/inputs
                accent: {
                gold:   "#FACC15",     // kleine details (badges, highlights)
                purple: "#4D338A",     // primaire knop/links
                },
                text: {
                primary: "#FFFFFF",    // hoofdtekst
                muted:   "#CBD5E1",    // subtiele tekst
                },
            },
        },
    },

    plugins: [forms],
};
