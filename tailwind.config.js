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
                'beige-crema': '#F5F5DC', 
                'bg-amber-50': '#fffbeb',
                'bg-amber-100': '#fef3c7',
                'bg-amber-200': '#fde68a',
                'bg-zinc-50': '#fafafa',
                'bg-zinc-100': '#f4f4f5',
                'bg-zinc-200': '#e4e4e7',
                'bg-stone-400': '#a8a29e',
            },
        },
    },

    plugins: [forms],
};
