<?php
$siteName = (string)\Cake\Core\Configure::read('Uikit.siteName', 'Application');
?>
<!DOCTYPE html>
<html lang="<?= h((string)\Cake\Core\Configure::read('App.defaultLocale', 'en')) ?>">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($siteName) ?> · <?= h(strip_tags($this->fetch('title'))) ?></title>
    <?= $this->Html->meta('icon') ?>
    <?php $this->Vite->script([
        'devEntries' => ['resources/js/uikit.js'],
        'prodFilter' => 'uikit.js',
        'config' => 'uikit',
    ]); ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body class="uk-background-muted">
    <header class="uk-background-default uk-box-shadow-small">
        <nav class="uk-container uk-navbar" uk-navbar>
            <div class="uk-navbar-left">
                <a class="uk-navbar-item uk-logo" href="<?= h($this->Url->build('/')) ?>"><?= h($siteName) ?></a>
            </div>
            <div class="uk-navbar-right">
                <a class="uk-navbar-item" href="<?= h($this->Url->build([
                    'plugin' => 'CakeDC/Users', 'prefix' => false, 'controller' => 'Users', 'action' => 'profile',
                ])) ?>"><?= __d('cake_d_c/users', 'Profile') ?></a>
                <a class="uk-navbar-item" href="<?= h($this->Url->build([
                    'plugin' => 'CakeDC/Users', 'prefix' => false, 'controller' => 'Users', 'action' => 'logout',
                ])) ?>"><?= __d('cake_d_c/users', 'Logout') ?></a>
            </div>
        </nav>
    </header>
    <main class="uk-container uk-section">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </main>
    <?= $this->fetch('deleteForms') ?>
    <?= $this->fetch('script') ?>
</body>
</html>
