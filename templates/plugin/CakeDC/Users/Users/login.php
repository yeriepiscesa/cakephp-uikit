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
                    <span uk-icon="icon: lock; ratio: 1.2"></span>
                    <?= __d('cake_d_c/users', 'Login') ?>
                </h3>
                <p class="uk-text-muted uk-margin-small-top"><?= __d('cake_d_c/users', 'Please enter your email and password') ?></p>
            </div>

            <?= $this->Flash->render('auth') ?>
            
            <?= $this->Form->create(null, ['class' => 'uk-form-stacked']) ?>
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
                    <label class="uk-form-label" for="password"><?= __d('cake_d_c/users', 'Password') ?></label>
                    <div class="uk-form-controls">
                        <?= $this->Form->control('password', [
                            'label' => false,
                            'required' => true,
                            'class' => 'uk-input',
                            'placeholder' => __d('cake_d_c/users', 'Enter your password')
                        ]) ?>
                    </div>
                </div>

                <?php
                if (Configure::read('Users.reCaptcha.login')) {
                    echo '<div class="uk-margin">';
                    echo $this->User->addReCaptcha();
                    echo '</div>';
                }
                
                if (Configure::read('Users.RememberMe.active')) {
                    echo '<div class="uk-margin">';
                    echo '<label>';
                    echo $this->Form->checkbox(Configure::read('Users.Key.Data.rememberMe'), [
                        'class' => 'uk-checkbox',
                        'checked' => Configure::read('Users.RememberMe.checked')
                    ]);
                    echo ' ' . __d('cake_d_c/users', 'Remember me');
                    echo '</label>';
                    echo '</div>';
                }
                ?>

                <?php
                $socialLoginList = $this->User->socialLoginList();
                if (!empty($socialLoginList)) {
                    echo '<div class="uk-margin">';
                    echo '<div class="uk-grid-small uk-child-width-1-1" uk-grid>';
                    foreach ($socialLoginList as $socialLogin) {
                        echo '<div>' . $socialLogin . '</div>';
                    }
                    echo '</div>';
                    echo '</div>';
                }
                ?>

                <div class="uk-margin">
                    <?= $this->Form->button(__d('cake_d_c/users', 'Login'), [
                        'class' => 'uk-button uk-button-primary uk-width-1-1'
                    ]) ?>
                </div>

                <div class="uk-text-center uk-text-small">
                    <?php
                    $links = [];
                    $registrationActive = Configure::read('Users.Registration.active');
                    
                    if ($registrationActive) {
                        $links[] = $this->Html->link(__d('cake_d_c/users', 'Register'), ['action' => 'register', 'plugin' => 'CakeDC/Users', 'controller' => 'Users']);
                    }
                    
                    if (Configure::read('Users.Email.required')) {
                        $links[] = $this->Html->link(__d('cake_d_c/users', 'Reset Password'), ['action' => 'requestResetPassword', 'plugin' => 'CakeDC/Users', 'controller' => 'Users']);
                        
                        if (Configure::read('OneTimeLogin.enabled')) {
                            $links[] = $this->Html->link(
                                __d('cake_d_c/users', 'Send me a login link'),
                                ['plugin' => 'CakeDC/Users', 'controller' => 'Users', 'action' => 'requestLoginLink'],
                                ['allowed' => true, 'escape' => false]
                            );
                        }
                    }
                    
                    echo implode(' <span class="uk-text-muted">|</span> ', $links);
                    ?>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
