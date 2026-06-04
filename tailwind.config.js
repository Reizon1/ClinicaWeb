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
        },
    },

    safelist: [
        // Grids usados en dashboards
        'grid-cols-2', 'grid-cols-3', 'grid-cols-4',
        // Fondos de íconos KPI
        'bg-blue-50', 'bg-green-50', 'bg-orange-50', 'bg-purple-50',
        'bg-red-50', 'bg-teal-50', 'bg-yellow-50', 'bg-gray-50',
        // Texto de íconos KPI
        'text-blue-600', 'text-green-600', 'text-orange-600', 'text-purple-600',
        'text-red-600', 'text-teal-600', 'text-orange-500',
        // Badges de estado
        'bg-green-100', 'text-green-700',
        'bg-yellow-100', 'text-yellow-700',
        'bg-blue-100', 'text-blue-700',
        'bg-red-100', 'text-red-500',
        'bg-gray-100', 'text-gray-600',
        // Módulos en tabla admin
        'bg-blue-100', 'bg-yellow-100',
    ],

    plugins: [forms],
};
