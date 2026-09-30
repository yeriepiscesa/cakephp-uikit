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

use Cake\Core\Configure;

$user = ${$tableAlias};
$this->assign('title', __d('cake_d_c/users', 'Edit User'));
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
                'empty' => false,
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
            'returnUrl' => $returnUrl ?? ['action' => 'index'],
            'showDelete' => true,
            'showNew' => true,
        ]
    ]) ?>

<?= $this->Form->end() ?>

<?php if (Configure::read('OneTimePasswordAuthenticator.login')): ?>
    <div class="uk-margin-large-top">
        <div class="uk-card uk-card-default">
            <div class="uk-card-header">
                <h4 class="uk-card-title">
                    <span uk-icon="icon: lock"></span> Reset Google Authenticator
                </h4>
            </div>
            
            <div class="uk-card-body">
                <p><?= __d('cake_d_c/users', 'Click the button below to reset Google Authenticator token for this user.') ?></p>
                <?= $this->Form->postLink(
                    __d('cake_d_c/users', 'Reset Google Authenticator Token'), [
                    'action' => 'resetOneTimePasswordAuthenticator', $user->id
                ], [
                    'class' => 'uk-button uk-button-warning',
                    'confirm' => __d(
                        'cake_d_c/users',
                        'Are you sure you want to reset token for user "{0}"?', $user->email
                    )
                ]) ?>
            </div>
        </div>
    </div>
<?php endif; ?>

