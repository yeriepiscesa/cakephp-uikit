<?php
$this->layout = 'Uikit.admin';
$this->assign('title', __d('cake_d_c/users', 'Add User'));
$user = ${$tableAlias};
?>
<?= $this->Form->create($user, ['class' => 'uk-form-stacked']) ?>
<div class="uk-margin"><?= $this->Form->control('username', ['label' => __d('cake_d_c/users', 'Username'), 'class' => 'uk-input']) ?></div>
<div class="uk-margin"><?= $this->Form->control('email', ['label' => __d('cake_d_c/users', 'Email'), 'type' => 'email', 'class' => 'uk-input']) ?></div>
<div class="uk-margin"><?= $this->Form->control('password', ['label' => __d('cake_d_c/users', 'Password'), 'type' => 'password', 'class' => 'uk-input']) ?></div>
<div class="uk-margin"><?= $this->Form->control('first_name', ['label' => __d('cake_d_c/users', 'First name'), 'class' => 'uk-input']) ?></div>
<div class="uk-margin"><?= $this->Form->control('last_name', ['label' => __d('cake_d_c/users', 'Last name'), 'class' => 'uk-input']) ?></div>
<div class="uk-margin"><?= $this->Form->control('active', ['type' => 'checkbox', 'label' => __d('cake_d_c/users', 'Active'), 'class' => 'uk-checkbox']) ?></div>
<?= $this->Form->button(__d('cake_d_c/users', 'Submit'), ['class' => 'uk-button uk-button-primary']) ?>
<?= $this->Html->link(__d('cake_d_c/users', 'List Users'), ['action' => 'index'], ['class' => 'uk-button uk-button-default']) ?>
<?= $this->Form->end() ?>
