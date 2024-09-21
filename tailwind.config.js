const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    darkMode: ["class", '[data-theme="dark"]'],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Inter var", ...defaultTheme.fontFamily.sans],
            },
            backgroundImage: {
                "app-card": "linear-gradient(to right top, #2cb0f1, #20a4e9, #1597e0, #0c8bd7, #097fce)",
            }
        },
    },
    content: [
        "./app/**/*.php",
        "./resources/**/*.html",
        "./resources/**/*.js",
        "./resources/**/*.jsx",
        "./resources/**/*.ts",
        "./resources/**/*.tsx",
        "./resources/**/*.php",
        "./resources/**/*.vue",
        "./resources/**/*.twig",
    ],
    plugins: [
        require("daisyui"),
        require('flowbite/plugin')
    ],
    daisyui: {
        themes: true,
        logs: false,
    },
};
