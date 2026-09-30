<?php
$this->layout = 'Uikit.landing';
$this->assign('title', __d('cake_d_c/users', 'Resend Validation email'));
?>
<div class="uk-section uk-section-muted uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
    <div class="uk-width-large">
        <div class="uk-card uk-card-default uk-card-body uk-box-shadow-large">
            <h1 class="uk-card-title"><?= __d('cake_d_c/users', 'Resend Validation email') ?></h1>
            <?= $this->Flash->render('auth') ?>
            <?= $this->Form->create($user, ['class' => 'uk-form-stacked']) ?>
                <div class="uk-margin"><?= $this->Form->control('reference', [
                    'label' => __d('cake_d_c/users', 'Email or username'),
                    'required' => true, 'class' => 'uk-input',
                ]) ?></div>
                <?= $this->Form->button(__d('cake_d_c/users', 'Submit'), [
                    'class' => 'uk-button uk-button-primary uk-width-1-1',
                ]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
