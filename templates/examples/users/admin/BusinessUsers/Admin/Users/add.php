<?php
/**
 * Copyright 2010 - 2019, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2018, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$this->assign('title', __d('cake_d_c/users', 'Add User'));
$user = ${$tableAlias};
$this->layout = 'Uikit.admin';
?>

<?= $this->Form->create($user, ['class' => 'uk-form-stacked']) ?>
    <div class="uk-margin">
        <label class="uk-form-label" for="email"><?= __d('cake_d_c/users', 'Email') ?></label>
        <div class="uk-form-controls">
            <?= $this->Form->control('email', ['label' => false, 'class' => 'uk-input', 'type' => 'email', 'required' => true]) ?>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="password"><?= __d('cake_d_c/users', 'Password') ?></label>
        <div class="uk-form-controls">
            <?= $this->Form->control('password', ['label' => false, 'class' => 'uk-input', 'required' => true]) ?>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="first_name"><?= __d('cake_d_c/users', 'First Name') ?></label>
        <div class="uk-form-controls">
            <?= $this->Form->control('first_name', ['label' => false, 'class' => 'uk-input']) ?>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="last_name"><?= __d('cake_d_c/users', 'Last Name') ?></label>
        <div class="uk-form-controls">
            <?= $this->Form->control('last_name', ['label' => false, 'class' => 'uk-input']) ?>
        </div>
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="role"><?= __d('cake_d_c/users', 'Role') ?></label>
        <div class="uk-form-controls">
            <?= $this->Form->control('role', [
                'label' => false,
                'class' => 'uk-select',
                'options' => $roles,
                'empty' => __d('cake_d_c/users', '-- Select Role --'),
                'required' => true,
            ]) ?>
        </div>
    </div>

    <div class="uk-margin">
        <label>
            <?= $this->Form->control('active', ['label' => false, 'class' => 'uk-checkbox', 'type' => 'checkbox']) ?>
            <?= __d('cake_d_c/users', 'Active') ?>
        </label>
    </div>

    <?= $this->element('crud_buttons', [
        'type' => 'form',
        'entity' => $user,
        'options' => [
            'showDelete' => false,
        ]
    ]) ?>
<?= $this->Form->end() ?>


