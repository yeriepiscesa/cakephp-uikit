<?php
/**
 *
 * @var \App\View\AppView $this
 */

$siteName = (string)\Cake\Core\Configure::read('Uikit.siteName', 'Application');
$user = $this->getRequest()->getAttribute('identity');
?>
<!DOCTYPE html>
<html lang="<?= h(\Cake\I18n\I18n::getLocale()) ?>">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= h($siteName) ?> - Admin:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?php
    // Load Vite assets for Uikit theme
    // CRITICAL: uikit-admin.js MUST load first, before any other scripts
    
    // Load uikit-admin.js first
    $this->Vite->script([
        'devEntries' => ['resources/js/uikit-admin.js'],
        'prodFilter' => 'uikit-admin.js',
        'config' => 'uikit',
    ]);
    
    // Then load additional scripts (like form.js)
    $additionalDevScripts = $devScripts ?? [];
    $additionalProdScripts = $prodScripts ?? [];
    
    if (!empty($additionalDevScripts) || !empty($additionalProdScripts)) {
        $this->Vite->script([
            'devEntries' => $additionalDevScripts,
            'prodFilter' => $additionalProdScripts,
            'config' => 'uikit',
        ]);
    }
    ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>
    <!-- Header -->
    <header class="admin-header">
        <nav class="uk-navbar-container" uk-navbar>
            <div class="uk-navbar-left">
                <div class="uk-navbar-item">
                    <button class="sidebar-toggle" onclick="toggleSidebar()">
                        <span uk-icon="icon: menu; ratio: 1.2"></span>
                    </button>
                </div>
                <a class="uk-navbar-item uk-logo" href="<?= $this->Url->build('/') ?>">
                    <strong><?= h($siteName) ?></strong> <span class="uk-text-muted uk-text-small"><?= __('Admin') ?></span>
                </a>
            </div>

            <div class="uk-navbar-right">
            <?php if ($languageSwitcher = \Cake\Core\Configure::read('Uikit.languageSwitcherElement')): ?>
                <?= $this->element($languageSwitcher) ?>
            <?php endif; ?>

                <ul class="uk-navbar-nav">
                    <li>
                        <a href="#">
                            <span uk-icon="icon: bell"></span>
                            <span class="uk-badge">3</span>
                        </a>
                        <div class="uk-navbar-dropdown">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li class="uk-nav-header"><?= __('Notifications') ?></li>
                                <li><a href="#"><?= __('New booking received') ?></a></li>
                                <li><a href="#"><?= __('Payment confirmed') ?></a></li>
                                <li class="uk-nav-divider"></li>
                                <li><a href="#"><?= __('View all') ?></a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="#">
                            <span uk-icon="icon: user"></span>
                            <?= h($user ? ($user->first_name ?? $user->email) : __('Guest')) ?>
                        </a>
                        <div class="uk-navbar-dropdown">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'profile', 'plugin' => 'CakeDC/Users', 'prefix' => false]) ?>"><span uk-icon="icon: user"></span> <?= __('Profile') ?></a></li>
                                <li><a href="#"><span uk-icon="icon: settings"></span> <?= __('Settings') ?></a></li>
                                <li class="uk-nav-divider"></li>
                                <li><?= $this->Html->link('<span uk-icon="icon: sign-out"></span> ' . __('Logout'), ['controller' => 'Users', 'action' => 'logout', 'plugin' => 'CakeDC/Users', 'prefix' => false], ['escape' => false]) ?></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <!-- User Info -->
        <div class="admin-user-info">
            <a class="admin-user-avatar" href="<?= h($this->Url->build([
                'plugin' => 'CakeDC/Users', 'prefix' => false,
                'controller' => 'Users', 'action' => 'profile',
            ])) ?>" aria-label="<?= h(__('Go to profile')) ?>">
                <?php if ($user && !empty($user['id']) && \Cake\Core\Plugin::isLoaded('BusinessUsers')): ?>
                    <img src="<?= h($this->Url->build([
                        'plugin' => 'BusinessUsers', 'prefix' => false,
                        'controller' => 'ProfilePhotos', 'action' => 'view', $user['id'],
                    ])) ?>" alt="<?= h(__('Your profile photo')) ?>">
                <?php else: ?>
                    <?= h(strtoupper(substr((string)($user->first_name ?? $user->email ?? 'A'), 0, 1))) ?>
                <?php endif; ?>
            </a>
            <h4 class="admin-user-name uk-margin-remove"><?= h($user ? trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: $user->email : __('Admin User')) ?></h4>
            <p class="admin-user-role uk-margin-remove"><?= h($user->role ?? __('Administrator')) ?></p>
        </div>

        <!-- Menu -->
        <div class="admin-menu">
            <?= $this->element('Menu/admin') ?>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="admin-content" id="adminContent">
        <div class="admin-content-inner uk-card uk-card-body">
            <!-- Page Title -->
            <div class="uk-flex uk-flex-between uk-flex-middle uk-margin-small-bottom">
                <div>
                <?php if ($this->fetch('title')): ?>                
                    <h2 class="uk-margin-remove">
                        <?= $this->fetch('title') ?>
                    </h2>
                <?php endif; ?>
                </div>
                <div class="action-buttons">
                    <?= $this->fetch('actionButtons') ?>
                </div>
            </div>
            <hr class="uk-margin-medium-bottom">

            <!-- Flash Messages -->
            <?= $this->Flash->render() ?>

            <!-- Page Content -->
            <?= $this->fetch('content') ?>
        </div>
    </main>

    <?= $this->fetch('deleteForms') ?>
    <?= $this->fetch('script') ?>
</body>
</html>
