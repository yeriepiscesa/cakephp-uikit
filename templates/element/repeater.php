<?php
/**
 * Reusable form repeater. $itemTemplate is trusted markup supplied by the caller.
 * It has access to Alpine's item and index variables.
 * @var \Cake\View\View $this
 * @var string $itemTemplate
 */
$config = [
    'items' => $items ?? [], 'defaults' => $defaults ?? [], 'expanded' => $expanded ?? true,
    'trackRemoved' => isset($removedName), 'removedIds' => $removedIds ?? [],
];
$json = json_encode($config, JSON_THROW_ON_ERROR | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
?>
<div x-data="repeater(<?= h($json) ?>)">
    <?php if (isset($removedName)): ?>
    <template x-for="id in removedIds" :key="id">
        <input type="hidden" name="<?= h($removedName) ?>[]" :value="id">
    </template>
    <?php endif; ?>
    <?php if (isset($heading) || ($collapseControls ?? false)): ?>
    <div class="uk-flex uk-flex-between uk-flex-middle uk-flex-wrap uk-margin-small-bottom">
        <?php if (isset($heading)): ?><h3 class="uk-margin-remove"><?= h($heading) ?></h3><?php endif; ?>
        <?php if ($collapseControls ?? false): ?>
        <div class="uk-button-group uikit-repeater-controls" x-show="items.length > 0">
            <button type="button" class="uk-button uk-button-default uk-button-small" @click="expandAll()"><?= h(__('Expand all')) ?></button>
            <button type="button" class="uk-button uk-button-default uk-button-small" @click="collapseAll()"><?= h(__('Collapse all')) ?></button>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <template x-for="(item, index) in items" :key="item.key">
        <div class="uk-margin-small">
            <?= $itemTemplate ?>
        </div>
    </template>
    <p x-show="items.length === 0"><?= h($emptyLabel ?? __('No items.')) ?></p>
    <button type="button" class="uk-button uk-button-default" @click="add()">
        <?= h($addLabel ?? __('Add')) ?>
    </button>
</div>
