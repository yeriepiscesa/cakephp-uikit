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

$user = ${$tableAlias};
$this->assign('title', h($user->email));
$this->layout = 'Uikit.admin';
?>

<img class="user-list-avatar uk-margin-bottom" src="<?= h($this->Url->build(['plugin' => 'BusinessUsers', 'prefix' => false, 'controller' => 'ProfilePhotos', 'action' => 'view', $user->id])) ?>" alt="">
<div class="uk-overflow-auto">
    <table class="uk-table uk-table-striped uk-table-divider">
        <tbody>
            <tr>
                <th><?= __d('cake_d_c/users', 'ID') ?></th>
                <td><?= h($user->id) ?></td>
            </tr>
            <tr>
                <th><?= __d('cake_d_c/users', 'Email') ?></th>
                <td><?= h($user->email) ?></td>
            </tr>
            <tr>
                <th><?= __d('cake_d_c/users', 'First Name') ?></th>
                <td><?= h($user->first_name) ?></td>
            </tr>
            <tr>
                <th><?= __d('cake_d_c/users', 'Last Name') ?></th>
                <td><?= h($user->last_name) ?></td>
            </tr>
            <tr>
                <th><?= __d('cake_d_c/users', 'Role') ?></th>
                <td><?= h($user->role) ?></td>
            </tr>
            <tr>
                <th><?= __d('cake_d_c/users', 'Active') ?></th>
                <td><?= $user->active ? '<span class="uk-badge uk-badge-success">Yes</span>' : '<span class="uk-badge">No</span>' ?></td>
            </tr>
            <tr>
                <th><?= __d('cake_d_c/users', 'Created') ?></th>
                <td><?= h($user->created) ?></td>
            </tr>
            <tr>
                <th><?= __d('cake_d_c/users', 'Modified') ?></th>
                <td><?= h($user->modified) ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?= $this->element('crud_buttons', [
    'type' => 'view',
    'entity' => $user,
    'options' => [
        'showDelete' => true,
        'showList' => true,
        'showNew' => true,
    ]
]) ?>

<?php if (!empty($user->social_accounts)): ?>
    <div class="uk-margin-large-top uk-overflow-auto">
        <h4><?= __d('cake_d_c/users', 'Social Accounts') ?></h4>
        <table class="uk-table uk-table-striped uk-table-divider">
            <thead>
                <tr>
                    <th><?= __d('cake_d_c/users', 'Provider') ?></th>
                    <th><?= __d('cake_d_c/users', 'Avatar') ?></th>
                    <th><?= __d('cake_d_c/users', 'Active') ?></th>
                    <th><?= __d('cake_d_c/users', 'Created') ?></th>
                    <th><?= __d('cake_d_c/users', 'Modified') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($user->social_accounts as $socialAccount): ?>
                    <tr>
                        <td><?= h($socialAccount->provider) ?></td>
                        <td><?= $socialAccount->avatar ? $this->Html->image($socialAccount->avatar, ['width' => 50, 'height' => 50]) : '-' ?></td>
                        <td><?= $socialAccount->active ? '<span class="uk-badge uk-badge-success">Yes</span>' : '<span class="uk-badge">No</span>' ?></td>
                        <td><?= h($socialAccount->created) ?></td>
                        <td><?= h($socialAccount->modified) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

