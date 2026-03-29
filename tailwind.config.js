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
            colors: {
                primary: '#0a4d40',
                primaryLight: '#0d6555',
                primaryDark: '#063830',
                accent: '#c9a227',
                accentLight: '#d4b84a',
                cream: '#faf8f4',
                creamDark: '#f0ebe0',
                charcoal: '#1a1a1a',
                border: '#e5e1d8',
            },
            fontFamily: {
                sans: ['Cairo', ...defaultTheme.fontFamily.sans],
                display: ['Amiri', ...defaultTheme.fontFamily.serif],
                body: ['Cairo', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
