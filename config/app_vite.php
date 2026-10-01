<?php
declare(strict_types=1);

use Cake\Core\Configure;

// The optional host config is copied from Uikit/config/uikit_assets.json.
$defaults = json_decode((string)file_get_contents(__DIR__ . '/uikit_assets.json'), true, 512, JSON_THROW_ON_ERROR);
$hostConfig = CONFIG . 'uikit_assets.json';
$settings = is_file($hostConfig)
    ? array_replace($defaults, json_decode((string)file_get_contents($hostConfig), true, 512, JSON_THROW_ON_ERROR))
    : $defaults;
$buildDirectory = $settings['buildDirectory'];
if (!is_string($buildDirectory) || !preg_match('#^webroot/[a-zA-Z0-9_-]+(?:/[a-zA-Z0-9_-]+)*$#', $buildDirectory)) {
    throw new RuntimeException('Uikit buildDirectory must be a project-relative path inside webroot/.');
}
$publicDirectory = substr($buildDirectory, strlen('webroot/'));

return [
    'CakeVite' => [
        'configs' => [
            'uikit' => [
                'build' => [
                    'outDirectory' => $publicDirectory,
                    'manifestPath' => WWW_ROOT . str_replace('/', DS, $publicDirectory) . DS . '.vite' . DS . 'manifest.json',
                ],
                'devServer' => [
                    'url' => $settings['devServerUrl'],
                    'hostHints' => ['localhost', '.test', '.local'],
                    'entries' => [
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
                // Assets now live in the host webroot, so no plugin URL prefix.
                'plugin' => null,
                'preload' => 'none',
                'productionModeHint' => 'vprod',
                'viewBlocks' => ['css' => 'css', 'script' => 'script'],
            ],
        ],
    ],
];
