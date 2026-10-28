<?php
$this->layout = 'Uikit.auth';
$this->assign('title', __d('cake_d_c/users', 'Please enter your email'));
?>
<div class="uk-section uk-section-muted uk-flex uk-flex-center uk-flex-middle">
    <div class="uk-width-large">
        <div class="uk-card uk-card-default uk-card-body uk-box-shadow-large">
            <h1 class="uk-card-title"><?= __d('cake_d_c/users', 'Please enter your email') ?></h1>
            
            <?= $this->Form->create(null, ['class' => 'uk-form-stacked']) ?>
                <div class="uk-margin"><?= $this->Form->control('email', [
                    'type' => 'email', 'required' => true, 'class' => 'uk-input',
                    'label' => __d('cake_d_c/users', 'Email'),
                ]) ?></div>
                <?= $this->Form->button(__d('cake_d_c/users', 'Submit'), [
                    'class' => 'uk-button uk-button-primary uk-width-1-1',
                ]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
