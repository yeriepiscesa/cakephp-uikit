<?php
/**
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="uk-alert-danger" uk-alert>
    <button class="uk-alert-close" type="button" aria-label="<?= h(__('Close')) ?>" uk-close></button>
    <p><?= $message ?></p>
</div>

