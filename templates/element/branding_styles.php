<?php
/** Branding colors are restricted to hex values before use in CSS. */
use Cake\Core\Configure;

$colors = [
    'primary' => '#2864df',
    'primaryHover' => '#1d50bc',
    'sidebar' => '#16293d',
    'background' => '#f5f7fa',
];
foreach ($colors as $key => $fallback) {
    $value = Configure::read('Uikit.branding.colors.' . $key);
    $colors[$key] = is_string($value) && preg_match('/^#(?:[0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/D', $value)
        ? $value : $fallback;
}
?>
<style>
:root {
    --theme-primary: <?= h($colors['primary']) ?>;
    --theme-primary-hover: <?= h($colors['primaryHover']) ?>;
    --theme-sidebar: <?= h($colors['sidebar']) ?>;
    --theme-background: <?= h($colors['background']) ?>;
}
</style>
