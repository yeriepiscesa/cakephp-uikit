<?php
use Cake\Core\Configure;

$this->layout = 'Uikit.admin';
$this->assign('title', __d('cake_d_c/users', 'Change Password'));
?>
<div class="uk-width-1-1 uk-width-1-2@m uk-width-1-3@xl">
    <?= $this->Flash->render('auth') ?>
    <?= $this->Form->create($user, ['class' => 'uk-form-stacked']) ?>
        <?php if ($validatePassword): ?>
            <div class="uk-margin"><?= $this->Form->control('current_password', [
                'type' => 'password', 'required' => true, 'class' => 'uk-input',
                'label' => __d('cake_d_c/users', 'Current password'),
                'autocomplete' => 'current-password',
            ]) ?></div>
        <?php endif; ?>
        <div class="uk-margin"><?= $this->Form->control('password', [
            'type' => 'password', 'required' => true, 'id' => 'new-password',
            'class' => 'uk-input', 'label' => __d('cake_d_c/users', 'New password'),
            'autocomplete' => 'new-password',
        ]) ?></div>
        <?php if (Configure::read('Users.passwordMeter.enabled')): ?>
            <?= $this->User->addPasswordMeter() ?>
        <?php endif; ?>
        <div class="uk-margin"><?= $this->Form->control('password_confirm', [
            'type' => 'password', 'required' => true, 'class' => 'uk-input',
            'label' => __d('cake_d_c/users', 'Confirm password'),
            'autocomplete' => 'new-password',
        ]) ?></div>
        <div class="uk-grid-small uk-child-width-1-1 uk-child-width-auto@s uk-margin-medium-top" uk-grid>
            <div><?= $this->Form->button(__d('cake_d_c/users', 'Save password'), [
                'id' => 'btn-submit', 'class' => 'uk-button uk-button-primary uk-width-1-1',
            ]) ?></div>
            <div><?= $this->Html->link(__d('cake_d_c/users', 'Back to profile'), [
                'plugin' => 'CakeDC/Users', 'prefix' => false,
                'controller' => 'Users', 'action' => 'profile',
            ], ['class' => 'uk-button uk-button-default uk-width-1-1']) ?></div>
        </div>
    <?= $this->Form->end() ?>
</div>
