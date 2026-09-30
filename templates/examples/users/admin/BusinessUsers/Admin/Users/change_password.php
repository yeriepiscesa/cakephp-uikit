<?php
use Cake\Core\Configure;

$this->layout = 'Uikit.admin';
$this->assign('title', __d('cake_d_c/users', 'Change Password'));
$this->layout = 'Uikit.admin';
?>
<div class="uk-width-large uk-margin-auto">
    <div class="uk-card uk-card-default uk-card-body">
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
                <?= $this->User->addPasswordMeter() ?>
            <?php endif; ?>
            <div class="uk-margin"><?= $this->Form->control('password_confirm', [
                'type' => 'password', 'required' => true, 'class' => 'uk-input',
                'label' => __d('cake_d_c/users', 'Confirm password'),
            ]) ?></div>
            <?= $this->Form->button(__d('cake_d_c/users', 'Submit'), [
                'id' => 'btn-submit', 'class' => 'uk-button uk-button-primary',
            ]) ?>
            <?= $this->Html->link(__d('cake_d_c/users', 'Cancel'),
                ['action' => 'profile'], ['class' => 'uk-button uk-button-default']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
