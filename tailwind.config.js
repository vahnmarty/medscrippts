const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php', 
    ],
    safelist:[
        'line-through',
        'blur-sm',
        'bg-red',
        'bg-green',
        'bg-primary'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            black: colors.black,
            blue: colors.blue,
            red: colors.red,
            green: colors.green,
            white: colors.white,
            gray: colors.gray,
            orange: colors.orange,
            emerald: colors.emerald,
            indigo: colors.indigo,
            yellow: colors.yellow,
            danger: colors.rose,
            primary: {
                50: '#2F5662',
            100: '#2F5662',
            200: '#2F5662',
            300: '#2F5662',
            400: '#2F5662',
            500: '#2F5662',
            600: '#2F5662',
            700: '#2F5662',
            800: '#2F5662',
            900: '#2F5662',
            },
            success: colors.green,
            warning: colors.yellow,
            pink: colors.pink,
            darkgreen: '#2F5662'
        }
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
