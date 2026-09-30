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

$this->layout = 'Uikit.landing';
?>

<div class="uk-section uk-section-muted uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
    <div class="uk-width-large">
        <div class="uk-card uk-card-default uk-card-body uk-box-shadow-large">
            <div class="uk-text-center uk-margin">
                <h3 class="uk-card-title uk-margin-remove-bottom">
                    <span uk-icon="icon: user-plus; ratio: 1.2"></span>
                    <?= __d('cake_d_c/users', 'Register') ?>
                </h3>
                <p class="uk-text-muted uk-margin-small-top"><?= __d('cake_d_c/users', 'Create a new account') ?></p>
            </div>

            <?= $this->Flash->render('auth') ?>
            
            <?= $this->Form->create($user, ['class' => 'uk-form-stacked']) ?>
                <div class="uk-margin">
                    <label class="uk-form-label" for="email"><?= __d('cake_d_c/users', 'Email') ?></label>
                    <div class="uk-form-controls">
                        <?= $this->Form->control('email', [
                            'label' => false,
                            'required' => true,
                            'type' => 'email',
                            'class' => 'uk-input',
                            'placeholder' => __d('cake_d_c/users', 'Enter your email')
                        ]) ?>
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="new-password"><?= __d('cake_d_c/users', 'Password') ?></label>
                    <div class="uk-form-controls">
                        <?= $this->Form->control('password', [
                            'label' => false,
                            'required' => true,
                            'id' => 'new-password',
                            'class' => 'uk-input',
                            'placeholder' => __d('cake_d_c/users', 'Enter your password')
                        ]) ?>
                    </div>
                </div>

                <?php if (Configure::read('Users.passwordMeter.enabled')): ?>
                    <div class="uk-margin">
                        <?= $this->User->addPasswordMeter() ?>
                    </div>
                <?php endif; ?>

                <div class="uk-margin">
                    <label class="uk-form-label" for="password_confirm"><?= __d('cake_d_c/users', 'Confirm password') ?></label>
                    <div class="uk-form-controls">
                        <?= $this->Form->control('password_confirm', [
                            'required' => true,
                            'type' => 'password',
                            'label' => false,
                            'class' => 'uk-input',
                            'placeholder' => __d('cake_d_c/users', 'Confirm your password')
                        ]) ?>
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="first_name"><?= __d('cake_d_c/users', 'First name') ?></label>
                    <div class="uk-form-controls">
                        <?= $this->Form->control('first_name', [
                            'label' => false,
                            'class' => 'uk-input',
                            'placeholder' => __d('cake_d_c/users', 'Enter your first name')
                        ]) ?>
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="last_name"><?= __d('cake_d_c/users', 'Last name') ?></label>
                    <div class="uk-form-controls">
                        <?= $this->Form->control('last_name', [
                            'label' => false,
                            'class' => 'uk-input',
                            'placeholder' => __d('cake_d_c/users', 'Enter your last name')
                        ]) ?>
                    </div>
                </div>

                <?php if (Configure::read('Users.Tos.required')): ?>
                    <div class="uk-margin">
                        <label>
                            <?= $this->Form->checkbox('tos', ['class' => 'uk-checkbox', 'required' => true]) ?>
                            <?= __d('cake_d_c/users', 'Accept TOS conditions?') ?>
                        </label>
                    </div>
                <?php endif; ?>

                <?php if (Configure::read('Users.reCaptcha.registration')): ?>
                    <div class="uk-margin">
                        <?= $this->User->addReCaptcha() ?>
                    </div>
                <?php endif; ?>

                <div class="uk-margin">
                    <?= $this->Form->button(__d('cake_d_c/users', 'Register'), ['class' => 'uk-button uk-button-primary uk-width-1-1']) ?>
                </div>

                <div class="uk-text-center uk-text-small">
                    <?= __d('cake_d_c/users', 'Already have an account?') ?>
                    <?= $this->Html->link(__d('cake_d_c/users', 'Login'), ['plugin' => 'CakeDC/Users', 'controller' => 'Users', 'action' => 'login']) ?>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
