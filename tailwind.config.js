/** @type {import('tailwindcss').Config} */
module.exports = {
    purge: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {},
    },
    variants: {
        extend: {},
    },
    plugins: [
        require('daisyui'),
    ],
    // config (optional)
    daisyui: {
        styled: true,
        // themes: false,
        base: true,
        utils: true,
        logs: true,
        rtl: false,
        themes: [
            {
                'mytheme': {
                    'primary': '#2068ee',
                    'primary-focus': '#1952be',
                    'primary-content': '#ffffff',
                    'secondary': '#811fd1',
                    'secondary-focus': '#701fb2',
                    'secondary-content': '#ffffff',
                    'accent': '#0e6f90',
                    'accent-focus': '#0e5c77',
                    'accent-content': '#ffffff',
                    'neutral': '#8892a5',
                    'neutral-focus': '#757e95',
                    'neutral-content': '#ffffff',
                    'base-100': '#ffffff',
                    'base-200': '#f9fafb',
                    'base-300': '#d1d5db',
                    'base-content': '#1f2937',
                    'info': '#148df0',
                    'success': '#0b7f43',
                    'warning': '#ff9900',
                    'error': '#ff5724',
                },
            },
        ],
    },
}
