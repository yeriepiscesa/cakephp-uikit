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

$this->layout = 'Uikit.auth';
$identityField = (string)Configure::read('Auth.Authenticators.Form.fields.username', 'email');
?>

        <span class="theme-eyebrow"><?= h(__('Welcome back')) ?></span>
        <h2><?= h(__d('cake_d_c/users', 'Login')) ?></h2>
        <p class="theme-login-intro"><?= h(__d('cake_d_c/users', 'Please enter your username or email and password')) ?></p>
            
            <?= $this->Form->create(null, ['class' => 'uk-form-stacked']) ?>
                <div class="uk-margin">
                    <label class="uk-form-label" for="login-identity"><?= __d('cake_d_c/users', 'Email or username') ?></label>
                    <div class="uk-form-controls">
                        <?= $this->Form->control($identityField, [
                            'label' => false,
                            'required' => true,
                            'type' => $identityField === 'email' ? 'email' : 'text',
                            'id' => 'login-identity',
                            'autocomplete' => 'username',
                            'class' => 'uk-input',
                            'placeholder' => __d('cake_d_c/users', 'Enter your email or username')
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
