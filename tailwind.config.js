import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './app/Modules/**/Presentation/**/Views/*.blade.php',
        './app/Modules/**/Presentation/**/Views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                geist: ['Geist Mono', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'primary': '#008994',
                'accent': '#7e4600',
                'dark': '#3a3a3a'
            }
        },
    },

    plugins: [forms],
};
