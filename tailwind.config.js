import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./modules/**/*.blade.php",
    ],

    theme: {
        extend: {
            colors: {
                primary: {
                    400: "#374151",
                    500: "#1F2937",
                },
                amethyst: {
                    500: "#A35EEC",
                },
                tangerine: {
                    400: "#F38E40",
                },
            },
            fontFamily: {
                sans: [...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
