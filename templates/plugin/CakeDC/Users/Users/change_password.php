<?php
use Cake\Core\Configure;
$this->layout = 'Uikit.landing';
$this->assign('title', __d('cake_d_c/users', 'Change Password'));
?>
<div class="uk-section uk-section-muted uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
    <div class="uk-width-large">
        <div class="uk-card uk-card-default uk-card-body uk-box-shadow-large">
            <h1 class="uk-card-title"><?= __d('cake_d_c/users', 'Change Password') ?></h1>
            <?= $this->Flash->render('auth') ?>
            <?= $this->Form->create($user, ['class' => 'uk-form-stacked']) ?>
                <?php if ($validatePassword): ?>
                    <div class="uk-margin"><?= $this->Form->control('current_password', [
                        'type' => 'password', 'required' => true, 'class' => 'uk-input',
                        'label' => __d('cake_d_c/users', 'Current password'),
                    ]) ?></div>
                <?php endif; ?>
                <div class="uk-margin"><?= $this->Form->control('password', [
                    'type' => 'password', 'required' => true, 'id' => 'new-password',
                    'class' => 'uk-input', 'label' => __d('cake_d_c/users', 'New password'),
                ]) ?></div>
                <?php if (Configure::read('Users.passwordMeter.enabled')): ?>
                    <div class="uk-margin"><?= $this->User->addPasswordMeter() ?></div>
                <?php endif; ?>
                <div class="uk-margin"><?= $this->Form->control('password_confirm', [
                    'type' => 'password', 'required' => true, 'class' => 'uk-input',
                    'label' => __d('cake_d_c/users', 'Confirm password'),
                ]) ?></div>
                <?= $this->Form->button(__d('cake_d_c/users', 'Submit'), [
                    'id' => 'btn-submit', 'class' => 'uk-button uk-button-primary uk-width-1-1',
                ]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
