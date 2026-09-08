<?php
/**
 * Table Paginator Element
 * Menampilkan pagination controls dengan UIkit styling
 * 
 * @var \App\View\AppView $this
 */
?>
<div class="uk-margin-medium-top">
    <div class="uk-flex uk-flex-between uk-flex-middle uk-flex-wrap uk-gap">
        <p class="uk-text-small uk-margin-remove">
            <?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
        </p>
        <ul class="uk-pagination uk-margin-remove">
            <?= $this->Paginator->prev('<span uk-icon="icon: chevron-left"></span>', ['escape' => false, 'class' => 'uk-pagination-previous']) ?>
            <?= $this->Paginator->numbers(['separator' => '', 'modulus' => 7]) ?>
            <?= $this->Paginator->next('<span uk-icon="icon: chevron-right"></span>', ['escape' => false, 'class' => 'uk-pagination-next']) ?>
        </ul>
    </div>
</div>
