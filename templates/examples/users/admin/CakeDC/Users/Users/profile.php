<?php
$this->layout = 'Uikit.admin';
$this->assign('title', __d('cake_d_c/users', 'My Profile'));
?>
<div class="uk-grid-medium" uk-grid>
    <div class="uk-width-1-3@m">
        <div class="uk-card uk-card-default uk-card-body uk-text-center">
            <img src="<?= h($this->Url->build(['plugin' => 'BusinessUsers', 'prefix' => false, 'controller' => 'ProfilePhotos', 'action' => 'view', $user->id])) ?>"
                alt="<?= h(__d('cake_d_c/users', 'Profile photo')) ?>"
                class="uk-border-circle" width="112" height="112"
                style="width:112px;height:112px;object-fit:cover">
            <h3 class="uk-card-title uk-margin-small-top"><?= h(trim((string)$user->first_name . ' ' . (string)$user->last_name) ?: $user->email) ?></h3>
            <p class="uk-text-muted uk-margin-remove-top"><?= h($user->email) ?></p>
            <?php if ($isCurrentUser): ?>
                <?= $this->Form->create(null, [
    'type' => 'file',
    'url' => ['plugin' => 'BusinessUsers', 'prefix' => false, 'controller' => 'ProfilePhotos', 'action' => 'upload'],
    'class' => 'uk-form-stacked uk-margin-top',
]) ?>
    <?= $this->Form->control('avatar_file', [
        'type' => 'file', 'accept' => 'image/jpeg,image/png,image/webp',
        'label' => __d('cake_d_c/users', 'Profile photo'), 'required' => true,
        'class' => 'uk-input',
    ]) ?>
    <p class="uk-text-meta uk-margin-small-top"><?= __('JPEG, PNG, or WebP; maximum 2 MB.') ?></p>
    <?= $this->Form->button(__('Upload photo'), ['class' => 'uk-button uk-button-primary uk-width-1-1']) ?>
<?= $this->Form->end() ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="uk-width-expand@m">
        <div class="uk-card uk-card-default uk-card-body">
            <dl class="uk-description-list">
                <dt><?= __d('cake_d_c/users', 'Username') ?></dt><dd><?= h($user->username) ?></dd>
                <dt><?= __d('cake_d_c/users', 'Email') ?></dt><dd><?= h($user->email) ?></dd>
                <dt><?= __d('cake_d_c/users', 'First name') ?></dt><dd><?= h($user->first_name) ?></dd>
                <dt><?= __d('cake_d_c/users', 'Last name') ?></dt><dd><?= h($user->last_name) ?></dd>
            </dl>
            <?php if ($isCurrentUser): ?>
                <?= $this->Html->link(__d('cake_d_c/users', 'Change Password'),
                    ['plugin' => 'CakeDC/Users', 'prefix' => false, 'controller' => 'Users', 'action' => 'changePassword'],
                    ['class' => 'uk-button uk-button-default']) ?>
            <?php endif; ?>
        </div>
    </div>
</div>
