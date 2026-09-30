<?php
/**
 * @var \App\View\AppView $this
 * @var bool $isRegister
 * @var string $username
 */
$this->Html->script('CakeDC/Users.webauthn.js', ['block' => true]);
$this->layout = 'Uikit.landing';
$this->assign('title', __d('cake_d_c/users','Two-factor authentication'));
?>
<div class="uk-section uk-section-muted uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
    <div class="uk-width-large">
        <div class="uk-card uk-card-default uk-card-body uk-box-shadow-large">

                <?= $this->Flash->render('auth') ?>
                <?= $this->Flash->render() ?>
                <fieldset>
                    <div id="webauthn2faRegisterInfo" style="display:none;">
                        <h2 class='text-center'><?= __d('cake_d_c/users', 'Registering your yubico key')?> </h2>
                        <h3 class='text-center'><?= __d('cake_d_c/users', 'Please insert and tap your yubico key')?></h3>
                        <p><?= __d('cake_d_c/users', 'In order to enable your YubiKey the first step is to perform a registration.')?></p>
                        <p><?= __d('cake_d_c/users', 'When the YubiKey starts blinking, press the golden disc to activate it. Depending on the web browser you might need to confirm the use of extended information from the YubiKey.')?></p>
                    </div>
                    <div id="webauthn2faAuthenticateInfo" style="display:none;">
                        <h4 class='text-center'><?= __d('cake_d_c/users', 'Verify your registered yubico key')?> </h4>
                        <h3 class='text-center'><?= __d('cake_d_c/users', 'Please insert and tap your yubico key')?></h3>
                        <p><?= __d('cake_d_c/users', 'You can now finish the authentication process using the registered device.')?></p>
                        <p><?= __d('cake_d_c/users', 'When the YubiKey starts blinking, press the golden disc to activate it. Depending on the web browser you might need to confirm the use of extended information from the YubiKey.')?></p>
                    </div>
                    <p class="text-center"><?= $this->Html->link(
                            __d('cake_d_c/users','Reload'),
                            ['action' => 'webauthn2fa'],
                            ['class' => 'uk-button uk-button-primary']
                        )?></p>
                </fieldset>
            </div>
        </div>
    </div>
</div>
<?php
$options = [
    'authenticateActionUrl' => $this->Url->build(['action' => 'webauthn2faAuthenticate']),
    'authenticateOptionsUrl' => $this->Url->build(['action' => 'webauthn2faAuthenticateOptions']),
    'registerActionUrl' => $this->Url->build(['action' => 'webauthn2faRegister']),
    'registerOptionsUrl' => $this->Url->build(['action' => 'webauthn2faRegisterOptions']),
    'isRegister' => $isRegister,
    'username' => h($username),
    'registerElemId' => 'webauthn2faRegisterInfo',
    'authenticateElemId' => 'webauthn2faAuthenticateInfo',
];
$this->Html->scriptStart(['block' => true]);
?>
setTimeout(function() {
  Webauthn2faHelper.run(<?= json_encode($options)?>);
}, 1000);
<?php $this->Html->scriptEnd();?>
