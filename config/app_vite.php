<?php

/**
 * ViteHelper Configuration untuk Plugin Uikit
 * 
 * @see https://github.com/passchn/cakephp-vite
 */

use Cake\Core\Plugin;
use Cake\Core\Configure;

$pluginPath = Plugin::path('Uikit');

return [
    'CakeVite' => [
        'configs' => [
            'uikit' => [
                'build' => [
                    // Output directory di plugin webroot (false = langsung di webroot/build)
                    'outDirectory' => 'build',
                    // Path ke manifest.json di plugin (Vite 5 menaruh di .vite/)
                    'manifestPath' => $pluginPath . 'webroot' . DS . 'build' . DS . '.vite' . DS . 'manifest.json',
                ],
                'devServer' => [
                    // URL Vite dev server untuk Uikit (port berbeda dari main app)
                    'url' => 'http://localhost:3000',
                    // Host hints untuk mendeteksi local development
                    'hostHints' => ['localhost', '.test', '.local'],
                    'entries' => [
                        // Path relatif terhadap plugin root (vite root)
                        'script' => [
                            'resources/js/uikit.js',
                            'resources/js/uikit-admin.js',
                            'resources/js/admin/form.js',
                            'resources/js/admin/form-wysiwyg.js',
                            'resources/js/admin/airport.js',
                        ],
                        'style' => [],
                    ],
                ],
                'forceProductionMode' => Configure::read('ViteHelper.mode') === 'production',
                // Set plugin name untuk load dari plugin webroot
                'plugin' => 'Uikit',
                'preload' => 'none',
                'productionModeHint' => 'vprod',
                'viewBlocks' => [
                    'css' => 'css',
                    'script' => 'script',
                ],
            ],
        ],
    ],
];
