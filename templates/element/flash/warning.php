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
<div class="uk-alert-warning" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p><?= $message ?></p>
</div>
