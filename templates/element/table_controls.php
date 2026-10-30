<?php
/** Shared search and page-size controls for admin lists. */
$query = $this->getRequest()->getQueryParams();
$filters = $filters ?? [];
$drawerQuery = $query;
$resetQuery = $query;
unset($drawerQuery['search'], $drawerQuery['page']);
unset($resetQuery['search'], $resetQuery['page']);
foreach ($filters as $name => $options) {
    unset($drawerQuery[$name], $resetQuery[$name]);
}
$search = $query['search'] ?? '';
$hasValue = static function ($value) use (&$hasValue): bool {
    if (is_array($value)) {
        foreach ($value as $item) {
            if ($hasValue($item)) {
                return true;
            }
        }

        return false;
    }

    return is_scalar($value) && trim((string)$value) !== '';
};
$hasActiveFilters = $hasValue($search);
foreach ($filters as $name => $options) {
    $hasActiveFilters = $hasActiveFilters || $hasValue($query[$name] ?? null);
}
$clearQuery = $query;
unset($clearQuery['search'], $clearQuery['page']);
$clearUrl = $this->getRequest()->getPath();
if ($clearQuery) {
    $clearUrl .= '?' . http_build_query($clearQuery);
}
unset($query['search'], $query['limit'], $query['page']);
$hiddenFields = function (array $values, string $prefix = '') use (&$hiddenFields): string {
    $html = '';
    foreach ($values as $key => $value) {
        $name = $prefix === '' ? (string)$key : $prefix . '[' . $key . ']';
        if (is_array($value)) {
            $html .= $hiddenFields($value, $name);
        } elseif (is_scalar($value)) {
            $html .= '<input type="hidden" name="' . h($name) . '" value="' . h((string)$value) . '">';
        }
    }

    return $html;
};
?>
<div class="admin-list-controls">
    <div class="admin-list-heading"><?= h(__('Search and filter')) ?></div>
    <?= $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query'], 'class' => 'admin-list-filter']) ?>
        <?= $hiddenFields($query) ?>
        <div class="admin-list-search">
            <label class="uk-hidden-visually" for="admin-list-search"><?= h(__('Search')) ?></label>
            <?= $this->Form->control('search', [
                'id' => 'admin-list-search',
                'type' => 'search',
                'placeholder' => __('Search...'),
                'value' => $this->getRequest()->getQuery('search'),
                'label' => false,
                'class' => 'uk-input',
            ]) ?>
        </div>
        <div class="admin-list-limit">
            <label for="limit"><?= h(__('Rows per page')) ?></label>
            <?= $this->Form->control('limit', [
                'type' => 'select',
                'options' => [10 => 10, 25 => 25, 50 => 50, 100 => 100],
                'value' => $this->getRequest()->getQuery('limit', $defaultLimit ?? 10),
                'label' => false,
                'class' => 'uk-select',
                'onchange' => 'this.form.requestSubmit()',
            ]) ?>
        </div>
        <?= $this->Form->button(__('Search'), ['class' => 'uk-button uk-button-primary']) ?>
        <?php if ($filters): ?>
            <button type="button" class="uk-button uk-button-default admin-filter-toggle" uk-toggle="target: #admin-list-filter-drawer" aria-label="<?= h($hasActiveFilters ? __('Filters active') : __('Filters')) ?>" aria-controls="admin-list-filter-drawer" aria-haspopup="dialog"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="M3 4h18l-7 8v6l-4 2v-8z"/></svg><?php if ($hasActiveFilters): ?><span class="admin-filter-toggle__active" aria-hidden="true"></span><?php endif; ?></button>
        <?php endif; ?>
        <?php if (is_string($search) && trim($search) !== '') : ?>
            <?= $this->Html->link(__('Clear Search'), $clearUrl, ['class' => 'uk-button uk-button-default']) ?>
        <?php endif; ?>
    <?= $this->Form->end() ?>
    <?php if ($filters): ?>
    <div id="admin-list-filter-drawer" uk-offcanvas="overlay: true; flip: true">
        <div class="uk-offcanvas-bar admin-filter-drawer" role="dialog" aria-modal="true" aria-labelledby="admin-filter-drawer-title">
            <header class="admin-filter-drawer__header">
                <h2 id="admin-filter-drawer-title"><?= h(__('Search and filter')) ?></h2>
                <button class="uk-offcanvas-close admin-filter-drawer__close" type="button" uk-close aria-label="<?= h(__('Close')) ?>"></button>
            </header>
            <?= $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query'], 'class' => 'uk-form-stacked admin-filter-drawer__body']) ?>
                <?= $hiddenFields($drawerQuery) ?>
                <div class="uk-margin"><?= $this->Form->control('search', ['id' => 'drawer-search', 'type' => 'search', 'label' => __('Search'), 'class' => 'uk-input', 'value' => is_scalar($search) ? $search : '']) ?></div>
                <?php foreach ($filters as $name => $options): ?>
                    <div class="uk-margin"><?= $this->Form->control($name, $options + ['value' => $this->getRequest()->getQuery($name)]) ?></div>
                <?php endforeach; ?>
                <div class="admin-filter-drawer__actions">
                    <?= $this->Form->button(__('Apply filters'), ['class' => 'uk-button uk-button-primary']) ?>
                    <?= $this->Html->link(__('Clear filters'), ['action' => 'index', '?' => $resetQuery], ['class' => 'uk-button uk-button-default']) ?>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <?php endif; ?>
</div>
