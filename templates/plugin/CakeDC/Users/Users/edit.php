<?php
use Cake\Core\Configure;
$this->layout = 'Uikit.admin';
$this->assign('title', __d('cake_d_c/users', 'Edit User'));
$user = ${$tableAlias};
?>
<?= $this->Form->create($user, ['class' => 'uk-form-stacked']) ?>
<div class="uk-margin"><?= $this->Form->control('username', ['label' => __d('cake_d_c/users', 'Username'), 'class' => 'uk-input']) ?></div>
<div class="uk-margin"><?= $this->Form->control('email', ['label' => __d('cake_d_c/users', 'Email'), 'type' => 'email', 'class' => 'uk-input']) ?></div>
<div class="uk-margin"><?= $this->Form->control('first_name', ['label' => __d('cake_d_c/users', 'First name'), 'class' => 'uk-input']) ?></div>
<div class="uk-margin"><?= $this->Form->control('last_name', ['label' => __d('cake_d_c/users', 'Last name'), 'class' => 'uk-input']) ?></div>
<div class="uk-margin"><?= $this->Form->control('active', ['type' => 'checkbox', 'label' => __d('cake_d_c/users', 'Active'), 'class' => 'uk-checkbox']) ?></div>
<?= $this->Form->button(__d('cake_d_c/users', 'Submit'), ['class' => 'uk-button uk-button-primary']) ?>
<?= $this->Html->link(__d('cake_d_c/users', 'List Users'), ['action' => 'index'], ['class' => 'uk-button uk-button-default']) ?>
<?= $this->Form->end() ?>
<?= $this->Form->postLink(__d('cake_d_c/users', 'Delete'), ['action' => 'delete', $user->id], [
    'class' => 'uk-button uk-button-danger uk-margin-small-top',
    'confirm' => __d('cake_d_c/users', 'Are you sure you want to delete # {0}?', $user->id),
]) ?>
<?php if (Configure::read('OneTimePasswordAuthenticator.login')): ?>
    <div class="uk-margin">
        <?= $this->Form->postLink(__d('cake_d_c/users', 'Reset Google Authenticator Token'), [
            'plugin' => 'CakeDC/Users', 'controller' => 'Users',
            'action' => 'resetOneTimePasswordAuthenticator', $user->id,
        ], ['class' => 'uk-button uk-button-danger',
            'confirm' => __d('cake_d_c/users', 'Are you sure you want to reset token for user "{0}"?', $user->username)]) ?>
    </div>
<?php endif; ?>
