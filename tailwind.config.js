import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./modules/**/*.blade.php",
        "./modules/**/**/*.blade.php",
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
                    500: "#F0721F",
                    600: "#E47524",
                },
                azure: {
                    50: "#EFF6FF",
                    200: "#BEDDFF",
                },
            },
            fontFamily: {
                sans: [...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
