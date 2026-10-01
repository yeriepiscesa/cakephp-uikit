import { defineConfig } from 'vite';
import fullReload from 'vite-plugin-full-reload';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const workDir = path.dirname(fileURLToPath(import.meta.url));
const hostRoot = process.env.UIKIT_HOST_ROOT || path.resolve(workDir, '../..');
const outputDirectory = process.env.UIKIT_OUTPUT_DIR || 'webroot/cakephp-uikit';
const publicDirectory = outputDirectory.replace(/^webroot\//, '');
const devServerUrl = new URL(process.env.UIKIT_DEV_SERVER_URL || 'http://localhost:3000');

export default defineConfig({
    plugins: [
        fullReload([
            path.join(hostRoot, 'config/**/*.php'),
            path.join(hostRoot, 'src/**/*.php'),
            path.join(hostRoot, 'templates/**/*.php'),
            path.join(hostRoot, 'plugins/**/templates/**/*.php'),
            path.join(hostRoot, 'vendor/yeriepiscesa/cakephp-uikit/templates/**/*.php'),
        ]),
    ],
    base: process.env.NODE_ENV === 'production' ? `/${publicDirectory}/` : '/',
    build: {
        manifest: true,
        outDir: path.resolve(hostRoot, outputDirectory),
        emptyOutDir: true,
        assetsDir: 'assets',
        rollupOptions: {
            input: {
                uikit: path.resolve(workDir, 'resources/js/uikit.js'),
                'uikit-admin': path.resolve(workDir, 'resources/js/uikit-admin.js'),
                'admin/form': path.resolve(workDir, 'resources/js/admin/form.js'),
                'admin/form-wysiwyg': path.resolve(workDir, 'resources/js/admin/form-wysiwyg.js'),
                'admin/airport': path.resolve(workDir, 'resources/js/admin/airport.js'),
                'admin/lookup-select': path.resolve(workDir, 'resources/js/admin/lookup-select.js'),
            },
        },
    },
    server: {
        origin: devServerUrl.origin,
        host: '0.0.0.0',
        port: Number(devServerUrl.port || 3000),
        strictPort: true,
        cors: true,
        hmr: { host: devServerUrl.hostname },
    },
    resolve: {
        alias: {
            '@': path.resolve(workDir, 'resources'),
            '@js': path.resolve(workDir, 'resources/js'),
            '@css': path.resolve(workDir, 'resources/css'),
        },
    },
});
