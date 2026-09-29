<?php
$this->layout = 'Uikit.landing';
$this->assign('title', __d('cake_d_c/users', 'Verification Code'));
?>
<div class="uk-section uk-section-muted uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
    <div class="uk-width-large">
        <div class="uk-card uk-card-default uk-card-body uk-box-shadow-large">
            <h1 class="uk-card-title"><?= __d('cake_d_c/users', 'Verification Code') ?></h1>
            <?= $this->Flash->render('auth') ?>
            <?= $this->Form->create(null, ['class' => 'uk-form-stacked']) ?>
                <?php if (!empty($secretDataUri)): ?>
                    <p class="uk-text-center"><img src="<?= h($secretDataUri) ?>" alt="<?= h(__d('cake_d_c/users', 'Authenticator QR code')) ?>"></p>
                <?php endif; ?>
                <div class="uk-margin"><?= $this->Form->control('code', [
                    'required' => true, 'class' => 'uk-input',
                    'label' => __d('cake_d_c/users', 'Verification Code'),
                ]) ?></div>
                <?= $this->Form->button(__d('cake_d_c/users', 'Verify'), [
                    'class' => 'uk-button uk-button-primary uk-width-1-1',
                ]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
