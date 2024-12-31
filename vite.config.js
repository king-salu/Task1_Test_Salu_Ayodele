import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import { resolve } from 'path';

export default defineConfig({
    plugins: [laravel(['resources/js/app.jsx']), react()],
    server: {
        host: 'localhost',
        port: 3000,
    },
    build: {
        outDir: 'vpublic',
        manifest: true,
        rollupOptions: {
            input: resolve(__dirname, 'resources/js/app.jsx'),
        },
    },
    resolve: {
        alias: {
            '@': resolve(__dirname, 'resources/js'),
        },
    },
    publicDir: 'public', // Ensure publicDir is set to the correct directory
});


// export default defineConfig({
//     plugins: [react()],
//     server: { host: 'localhost', port: 3000, },
//     build: { outDir: 'public', rollupOptions: { input: 'resources/js/app.js', }, },
//     resolve: { alias: { '@': '/resources/js', }, },
//     esbuild: {
//         loader: 'jsx', // Set the loader to 'jsx' to handle JSX syntax 
//         include: /src\/.*\.jsx?$/, // Process .js and .jsx files 
//         exclude: /node_modules/, // Exclude node_modules
//     }
// });
