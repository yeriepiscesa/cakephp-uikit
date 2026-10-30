<?php
$query = $this->getRequest()->getQueryParams();
unset($query['_locale']);
$path = $this->getRequest()->getUri()->getPath() ?: '/';
$locale = \Cake\I18n\I18n::getLocale();
$languages = ['en_US' => 'English', 'id_ID' => 'Bahasa Indonesia'];
$currentLabel = $languages[$locale] ?? $languages['en_US'];
?>
<nav class="language-switcher" aria-label="<?= h(__('Language')) ?>">
    <button class="language-switcher__trigger" type="button" aria-label="<?= h(__('Language')) ?>" aria-haspopup="true">
        <span uk-icon="icon: world" aria-hidden="true"></span>
        <span><?= h($currentLabel) ?></span>
        <span uk-icon="icon: chevron-down" aria-hidden="true"></span>
    </button>
    <div class="language-switcher__menu" uk-dropdown="mode: click; pos: bottom-right">
        <ul class="uk-nav uk-dropdown-nav">
    <?php foreach ($languages as $code => $label): ?>
        <?php $url = $path . '?' . http_build_query($query + ['_locale' => $code], '', '&', PHP_QUERY_RFC3986); ?>
        <li<?= $locale === $code ? ' class="uk-active"' : '' ?>>
        <?= $this->Html->link($label, $url, [
            'lang' => $code === 'id_ID' ? 'id' : 'en',
            'aria-current' => $locale === $code ? 'true' : null,
        ]) ?>
        </li>
    <?php endforeach; ?>
        </ul>
    </div>
</nav>
