import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                premium: {
                    bg: '#151521',
                    card: '#1E1E2D',
                    border: '#2B2B40',
                    accent: '#6366F1',
                },
                ofppt: {
                    blue: '#1E3A8A',   // Official Blue
                    orange: '#F58220', // Official Orange
                }
            }
        },
    },

    plugins: [forms],
};
