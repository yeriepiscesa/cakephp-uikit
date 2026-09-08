import { defineConfig } from 'vite';
import fullReload from 'vite-plugin-full-reload';
import path from 'path';

export default defineConfig({
    plugins: [
        fullReload([
            '../../config/**/*.php',
            '../../src/**/*.php',
            '../../templates/**/*.php',
            '../../plugins/Cms/templates/**/*.php',
            '../../plugins/FlightBooking/templates/**/*.php',
            'templates/**/*.php',
        ])
    ],
    
    base: process.env.NODE_ENV === 'production' ? '/uikit/' : '/',
    
    build: {
        manifest: true,
        outDir: 'webroot/build',
        emptyOutDir: true,
        assetsDir: 'assets',
        rollupOptions: {
            input: {
                'uikit': path.resolve(__dirname, 'resources/js/uikit.js'),
                'uikit-admin': path.resolve(__dirname, 'resources/js/uikit-admin.js'),
                'admin/form': path.resolve(__dirname, 'resources/js/admin/form.js'),
                'admin/form-wysiwyg': path.resolve(__dirname, 'resources/js/admin/form-wysiwyg.js'),
                'admin/airport': path.resolve(__dirname, 'resources/js/admin/airport.js'),
                'admin/lookup-select': path.resolve(__dirname, 'resources/js/admin/lookup-select.js'),
            },
        },
    },
    
    server: {
        origin: 'http://localhost:3000',
        host: '0.0.0.0',
        port: 3000,
        strictPort: true,
        cors: true,
        hmr: {
            host: 'localhost',
        },
    },
    
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources'),
            '@js': path.resolve(__dirname, 'resources/js'),
            '@css': path.resolve(__dirname, 'resources/css'),
        }
    }
});
