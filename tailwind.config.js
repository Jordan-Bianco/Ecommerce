const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
                'c-green-100': 'rgb(162, 209, 146)',
                'c-green-300': 'rgb(101, 147, 87)',
                'c-green-400': 'rgb(99, 145, 85)',
                'c-green-500': 'rgb(90, 132, 78)',
                'c-green-600': 'rgb(84, 122, 74)',
                'c-green-700': 'rgb(80, 112, 72)'
            },
            fontSize: {
                'xxs': '11px'
            },
            animation: {
                'spin-fast': 'spin 300ms linear infinite',
            }
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
