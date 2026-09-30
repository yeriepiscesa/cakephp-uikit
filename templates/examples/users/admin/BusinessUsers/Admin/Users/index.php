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

use BusinessUsers\Domain\Enum\UserRole;


echo $this->element('Uikit.page_header', [
    'title' => __d('cake_d_c/users', 'Users'),
    'actions' => [
        [
            'label' => __d('cake_d_c/users', 'New User'),
            'url' => ['action' => 'add'],
            'class' => 'uk-button uk-button-primary'
        ]
    ]
]);
$this->layout = 'Uikit.admin';
?>

<?= $this->element('Uikit.table_controls') ?>

<?php
$sortParam = $this->request->getQuery('sort');
$directionParam = $this->request->getQuery('direction', 'asc');
?>
<?php if (!empty(${$tableAlias})): ?>
<div class="datalist-table datalist-freeze-2">    
    <div class="uk-overflow-auto">
        <table class="uk-table uk-table-small uk-table-striped uk-table-hover">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th><?= __d('cake_d_c/users', 'Photo') ?></th>
                    <th><?= $this->Paginator->sort('email', __d('cake_d_c/users', 'Email') . ($sortParam === 'email' ? ' <span uk-icon="icon: triangle-' . ($directionParam === 'asc' ? 'up' : 'down') . '; ratio: 0.7"></span>' : ''), ['escape' => false]) ?></th>
                    <th><?= $this->Paginator->sort('first_name', __d('cake_d_c/users', 'First name') . ($sortParam === 'first_name' ? ' <span uk-icon="icon: triangle-' . ($directionParam === 'asc' ? 'up' : 'down') . '; ratio: 0.7"></span>' : ''), ['escape' => false]) ?></th>
                    <th><?= $this->Paginator->sort('last_name', __d('cake_d_c/users', 'Last name') . ($sortParam === 'last_name' ? ' <span uk-icon="icon: triangle-' . ($directionParam === 'asc' ? 'up' : 'down') . '; ratio: 0.7"></span>' : ''), ['escape' => false]) ?></th>
                    <th><?= $this->Paginator->sort('role', __d('cake_d_c/users', 'Role') . ($sortParam === 'role' ? ' <span uk-icon="icon: triangle-' . ($directionParam === 'asc' ? 'up' : 'down') . '; ratio: 0.7"></span>' : ''), ['escape' => false]) ?></th>
                    <th><?= $this->Paginator->sort('active', __d('cake_d_c/users', 'Active') . ($sortParam === 'active' ? ' <span uk-icon="icon: triangle-' . ($directionParam === 'asc' ? 'up' : 'down') . '; ratio: 0.7"></span>' : ''), ['escape' => false]) ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (${$tableAlias} as $user): ?>
                <tr>
                    <td class="uk-text-center uk-table-shrink uk-text-nowrap">
                        <?= $this->element('Uikit.list_action_buttons', ['entity' => $user]); ?>
                    </td>
                    <td><img class="user-list-avatar" src="<?= h($this->Url->build(['plugin' => 'BusinessUsers', 'prefix' => false, 'controller' => 'ProfilePhotos', 'action' => 'view', $user->id])) ?>" alt=""></td>
                    <td><?= h($user->email) ?></td>
                    <td><?= h($user->first_name) ?></td>
                    <td><?= h($user->last_name) ?></td>
                    <td><?= h(UserRole::tryFrom($user->role)?->label() ?? $user->role) ?></td>
                    <td>
                        <?php if ($user->active): ?>
                            <span class="uk-badge uk-badge-success"><?= __d('cake_d_c/users', 'Active') ?></span>
                        <?php else: ?>
                            <span class="uk-badge"><?= __d('cake_d_c/users', 'Inactive') ?></span>
                        <?php endif; ?>
                    </td>                
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->element('Uikit.table_paginator') ?>
<?php else: ?>
<div class="uk-alert uk-alert-primary" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <p><?= __d('cake_d_c/users', 'No users found') ?></p>
</div>
<?php endif; ?>

