<?php
$this->layout = 'Uikit.admin';
$this->assign('title', __d('cake_d_c/users', 'User'));
$user = ${$tableAlias};
?>
<img class="user-list-avatar uk-margin-bottom" src="<?= h($this->Url->build(['plugin' => 'BusinessUsers', 'prefix' => false, 'controller' => 'ProfilePhotos', 'action' => 'view', $user->id])) ?>" alt="">
<dl class="uk-description-list">
    <dt><?= __d('cake_d_c/users', 'Username') ?></dt><dd><?= h($user->username) ?></dd>
    <dt><?= __d('cake_d_c/users', 'Email') ?></dt><dd><?= h($user->email) ?></dd>
    <dt><?= __d('cake_d_c/users', 'First Name') ?></dt><dd><?= h($user->first_name) ?></dd>
    <dt><?= __d('cake_d_c/users', 'Last Name') ?></dt><dd><?= h($user->last_name) ?></dd>
    <dt><?= __d('cake_d_c/users', 'Role') ?></dt><dd><?= h($user->role) ?></dd>
    <dt><?= __d('cake_d_c/users', 'Active') ?></dt><dd><?= $user->active ? __('Yes') : __('No') ?></dd>
</dl>
<div class="uk-margin">
    <?= $this->Html->link(__d('cake_d_c/users', 'Edit User'), ['action' => 'edit', $user->id], ['class' => 'uk-button uk-button-primary']) ?>
    <?= $this->Html->link(__d('cake_d_c/users', 'List Users'), ['action' => 'index'], ['class' => 'uk-button uk-button-default']) ?>
</div>
