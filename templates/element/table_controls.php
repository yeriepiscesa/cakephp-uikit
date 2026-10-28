<?php
/** Shared search and page-size controls for admin lists. */
$query = $this->getRequest()->getQueryParams();
$search = $query['search'] ?? '';
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
                'value' => $this->getRequest()->getQuery('limit', 10),
                'label' => false,
                'class' => 'uk-select',
                'onchange' => 'this.form.requestSubmit()',
            ]) ?>
        </div>
        <?= $this->Form->button(__('Search'), ['class' => 'uk-button uk-button-primary']) ?>
        <?php if (is_string($search) && trim($search) !== '') : ?>
            <?= $this->Html->link(__('Clear Search'), $clearUrl, ['class' => 'uk-button uk-button-default']) ?>
        <?php endif; ?>
    <?= $this->Form->end() ?>
</div>
