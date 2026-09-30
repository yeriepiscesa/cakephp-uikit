<?php
/**
 * Copyright 2010 - 2020, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2020, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * @var \CakeDC\Users\Model\Entity\User $user
 */

$this->layout = 'Uikit.landing';
?>

<div class="uk-section uk-section-muted uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
    <div class="uk-width-large">
        <div class="uk-card uk-card-default uk-card-body uk-box-shadow-large">
            <div class="uk-text-center uk-margin">
                <h3 class="uk-card-title uk-margin-remove-bottom">
                    <span uk-icon="icon: key; ratio: 1.2"></span>
                    <?= __d('cake_d_c/users', 'Reset Password') ?>
                </h3>
                <p class="uk-text-muted uk-margin-small-top"><?= __d('cake_d_c/users', 'Please enter your email to reset your password') ?></p>
            </div>

            <?= $this->Flash->render('auth') ?>
            
            <?= $this->Form->create($user, ['class' => 'uk-form-stacked']) ?>
                <div class="uk-margin">
                    <label class="uk-form-label" for="reference"><?= __d('cake_d_c/users', 'Email') ?></label>
                    <div class="uk-form-controls">
                        <?= $this->Form->control('reference', [
                            'label' => false,
                            'required' => true,
                            'type' => 'email',
                            'class' => 'uk-input',
                            'placeholder' => __d('cake_d_c/users', 'Enter your email')
                        ]) ?>
                    </div>
                </div>

                <div class="uk-margin">
                    <?= $this->Form->button(__d('cake_d_c/users', 'Submit'), ['class' => 'uk-button uk-button-primary uk-width-1-1']) ?>
                </div>

                <div class="uk-text-center uk-text-small">
                    <?= __d('cake_d_c/users', 'Remember your password?') ?>
                    <?= $this->Html->link(__d('cake_d_c/users', 'Login'), ['plugin' => 'CakeDC/Users', 'controller' => 'Users', 'action' => 'login']) ?>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
