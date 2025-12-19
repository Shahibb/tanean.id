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
                'tanean-green': '#8AA57E',
                'tanean-pink': '#E8B7B7',
                'tanean-beige': '#CFC6B7',
                'tanean-dark': '#1F2D2D'
            },
        },
    },

    plugins: [forms],
};
