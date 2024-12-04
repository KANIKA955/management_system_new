import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './node_modules/@inertiaui/modal-vue/src/**/*.{js,vue}',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Public Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'dark': '#25293c',
                'darkTrans': '#2f3349',
                'light': '#ffffff',
                'lightTrans': '#f8f7fa',

                'primary': '#7367f0',
                'info': '#00cfe8',
                'success': '#28c76f',
                'danger': '#ea5455',
                'warning': '#ff9f43',
            },
        },
    },

    plugins: [forms, typography],
    darkMode: 'class'
};
