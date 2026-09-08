<?php
/**
 * Page Header Element
 * Menampilkan title dan action buttons
 * 
 * @var \App\View\AppView $this
 * @var string $title Page title
 * @var array $actions Array of action buttons [['label' => '', 'url' => [], 'class' => ''], ...]
 */

$title = $title ?? null;
$actions = $actions ?? [];
?>

<?php if ($title): ?>
    <?php $this->assign('title', $title); ?>
<?php endif; ?>

<?php if (!empty($actions)): ?>
    <?php $this->start('actionButtons'); ?>
    <div class="uk-flex uk-gap">
        <?php foreach ($actions as $action): ?>
            <?= $this->Html->link(
                $action['label'],
                $action['url'],
                ['class' => $action['class'] ?? 'uk-button uk-button-default']
            ) ?>
        <?php endforeach; ?>
    </div>
    <?php $this->end(); ?>
<?php endif; ?>
