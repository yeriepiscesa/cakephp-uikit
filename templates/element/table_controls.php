<?php
/**
 * Table Controls Element
 * Menampilkan limit control dan search box
 * 
 * @var \App\View\AppView $this
 */
?>
<div class="uk-margin-bottom">
    <div class="uk-flex uk-flex-between uk-flex-middle uk-flex-wrap uk-gap">
        <!-- Limit Control -->
        <div>
            <?= $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query']]) ?>
            <div class="uk-flex uk-flex-middle uk-gap">
                <label for="limit" class="uk-text-small uk-margin-remove"><?= __('Limit:') ?></label>
                <?= $this->Form->control('limit', [
                    'type' => 'select',
                    'options' => [10 => 10, 25 => 25, 50 => 50, 100 => 100],
                    'value' => $this->request->getQuery('limit', 10),
                    'label' => false,
                    'class' => 'uk-select uk-margin-small-left',
                    'onchange' => 'this.form.submit()',
                    'style' => 'width: 80px;'
                ]) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>

        <!-- Search Box -->
        <div>
            <?= $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query']]) ?>
            <div class="uk-flex uk-flex-middle uk-gap">
                <?= $this->Form->control('search', [
                    'type' => 'text',
                    'placeholder' => __('Search...'),
                    'value' => $this->request->getQuery('search'),
                    'label' => false,
                    'class' => 'uk-input',
                    'style' => 'width: 250px;'
                ]) ?>
                <?= $this->Form->button(__('Search'), ['class' => 'uk-button uk-button-secondary']) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>