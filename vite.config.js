import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";

export default defineConfig({
    plugins: [
        laravel(["resources/css/app.css", "resources/js/App.jsx"]),
        react(),
    ],
    build: {
        rollupOptions: {
            input: {
                main: "resources/js/App.jsx",
            },
        },
    },
});
