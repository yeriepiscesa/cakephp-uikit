<?php
$this->layout = 'Uikit.admin';
$this->assign('title', __d('cake_d_c/users', 'Users'));
$users = ${$tableAlias};
?>
<div class="uk-flex uk-flex-right uk-margin">
    <?= $this->Html->link(__d('cake_d_c/users', 'New {0}', $tableAlias), ['action' => 'add'], [
        'class' => 'uk-button uk-button-primary',
    ]) ?>
</div>
<div class="uk-overflow-auto">
    <table class="uk-table uk-table-divider uk-table-striped">
        <thead><tr>
            <th><?= __d('cake_d_c/users', 'Photo') ?></th>
            <th><?= $this->Paginator->sort('username', __d('cake_d_c/users', 'Username')) ?></th>
            <th><?= $this->Paginator->sort('email', __d('cake_d_c/users', 'Email')) ?></th>
            <th><?= $this->Paginator->sort('first_name', __d('cake_d_c/users', 'First name')) ?></th>
            <th><?= $this->Paginator->sort('last_name', __d('cake_d_c/users', 'Last name')) ?></th>
            <th><?= __d('cake_d_c/users', 'Actions') ?></th>
        </tr></thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><img class="user-list-avatar" src="<?= h($this->Url->build(['plugin' => 'BusinessUsers', 'prefix' => false, 'controller' => 'ProfilePhotos', 'action' => 'view', $user->id])) ?>" alt=""></td>
                <td><?= h($user->username) ?></td><td><?= h($user->email) ?></td>
                <td><?= h($user->first_name) ?></td><td><?= h($user->last_name) ?></td>
                <td>
                    <?= $this->Html->link(__d('cake_d_c/users', 'View'), ['action' => 'view', $user->id]) ?>
                    <?= $this->Html->link(__d('cake_d_c/users', 'Edit'), ['action' => 'edit', $user->id], ['class' => 'uk-margin-small-left']) ?>
                    <?= $this->Html->link(__d('cake_d_c/users', 'Change password'), ['action' => 'changePassword', $user->id], ['class' => 'uk-margin-small-left']) ?>
                    <?= $this->Form->postLink(__d('cake_d_c/users', 'Delete'), ['action' => 'delete', $user->id], [
                        'class' => 'uk-margin-small-left uk-text-danger',
                        'confirm' => __d('cake_d_c/users', 'Are you sure you want to delete # {0}?', $user->id),
                    ]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="uk-margin"><?= $this->Paginator->prev('< ' . __d('cake_d_c/users', 'previous')) ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__d('cake_d_c/users', 'next') . ' >') ?></div>
