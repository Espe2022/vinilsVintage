import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/views/components/**/*.blade.php', //Componentes Blade
        './resources/views/layouts/**/*.blade.php',    //Layouts
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'beige-tostado': '#d2b48c',
                'beige-tostado-hover': '#c9a77a',
                'marron-chocolate': '#4b2e05',
                'crema-suave': '#fdf5e6',
                'oro-antiguo': '#d4af37',
                'gris-suave': '#6b6b6b',
            },
        },
    },

    plugins: [forms],
};
