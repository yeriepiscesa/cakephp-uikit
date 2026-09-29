<?php
$this->layout = 'Uikit.landing';
$this->assign('title', __d('cake_d_c/users', 'Profile'));
?>
<div class="uk-section uk-section-muted uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
    <div class="uk-width-large">
        <div class="uk-card uk-card-default uk-card-body uk-box-shadow-large">
            <div class="uk-text-center">
                <?= $this->Html->image(empty($user->avatar) ? $avatarPlaceholder : $user->avatar, [
                    'width' => 96, 'height' => 96, 'class' => 'uk-border-circle',
                    'alt' => __d('cake_d_c/users', 'Avatar'),
                ]) ?>
                <h1 class="uk-card-title"><?= h(trim((string)$user->first_name . ' ' . (string)$user->last_name)) ?></h1>
            </div>
            <dl class="uk-description-list">
                <dt><?= __d('cake_d_c/users', 'Username') ?></dt><dd><?= h($user->username) ?></dd>
                <dt><?= __d('cake_d_c/users', 'Email') ?></dt><dd><?= h($user->email) ?></dd>
            </dl>
            <?= $this->User->socialConnectLinkList($user->social_accounts ?? []) ?>
            <?php if ($isCurrentUser): ?>
                <?= $this->Html->link(__d('cake_d_c/users', 'Change Password'), [
                    'plugin' => 'CakeDC/Users', 'controller' => 'Users', 'action' => 'changePassword',
                ], ['class' => 'uk-button uk-button-primary']) ?>
            <?php endif; ?>
        </div>
    </div>
</div>
