<?php
/**
 *
 * @var \App\View\AppView $this
 */

$siteName = (string)\Cake\Core\Configure::read('Uikit.siteName', 'Application');
$user = $this->getRequest()->getAttribute('identity');
$profileUrl = \Cake\Core\Plugin::isLoaded('BusinessUsers')
    ? ['plugin' => 'BusinessUsers', 'prefix' => 'Admin', 'controller' => 'Users', 'action' => 'profile']
    : ['plugin' => 'CakeDC/Users', 'prefix' => false, 'controller' => 'Users', 'action' => 'profile'];
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
    <?= $this->element('Uikit.branding_styles') ?>
</head>
<?php $formWidth = $this->fetch('formWidth') ?: '1-1'; ?>
<body class="admin-form-width-<?= h(in_array($formWidth, ['1-1', '1-2', '1-3', '1-4'], true) ? $formWidth : '1-1') ?>">
    <!-- Header -->
    <header class="admin-header">
        <nav class="uk-navbar-container" uk-navbar>
            <div class="uk-navbar-left">
                <div class="uk-navbar-item">
                    <button class="sidebar-toggle" type="button" onclick="toggleSidebar()" aria-controls="adminSidebar" aria-expanded="true" aria-label="<?= h(__('Toggle navigation')) ?>">
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

                <div class="admin-account">
                    <a class="admin-account-trigger" href="#admin-account-menu" aria-label="<?= h(__('Account menu')) ?>">
                        <span class="admin-account-initial"><?= h(strtoupper(substr((string)($user->first_name ?? $user->email ?? 'A'), 0, 1))) ?></span>
                        <span><?= h($user ? ($user->first_name ?? $user->email) : __('Guest')) ?></span>
                        <span uk-icon="icon: chevron-down"></span>
                    </a>
                    <div id="admin-account-menu" uk-dropdown="mode: click; pos: bottom-right">
                        <ul class="uk-nav uk-dropdown-nav">
                            <li><?= $this->Html->link('<span uk-icon="icon: user" aria-hidden="true"></span> ' . h(__('Profile')), $profileUrl, ['escape' => false]) ?></li>
                            <li><?= $this->Html->link('<span uk-icon="icon: sign-out" aria-hidden="true"></span> ' . h(__('Logout')), ['controller' => 'Users', 'action' => 'logout', 'plugin' => 'CakeDC/Users', 'prefix' => false], ['escape' => false]) ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <a class="theme-brand theme-brand-light" href="<?= h($this->Url->build('/')) ?>">
            <?php if ($logo = \Cake\Core\Configure::read('Uikit.branding.logo')): ?>
                <img class="theme-brand-logo" src="<?= h($this->Url->build((string)$logo)) ?>" alt="">
            <?php else: ?><span class="theme-brand-mark" aria-hidden="true">✦</span><?php endif; ?>
            <span><?= h($siteName) ?><small><?= h((string)\Cake\Core\Configure::read('Uikit.branding.tagline', __('Workspace'))) ?></small></span>
        </a>
        <!-- User Info -->
        <div class="admin-user-info">
            <a class="admin-user-avatar" href="<?= h($this->Url->build($profileUrl)) ?>" aria-label="<?= h(__('Go to profile')) ?>">
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
            <!-- Page navigation -->
            <?php if ($this->fetch('breadcrumbs')): ?>
                <?= $this->fetch('breadcrumbs') ?>
            <?php elseif ($this->fetch('title')): ?>
                <?php
                $currentAction = (string)$this->getRequest()->getParam('action');
                $controllerLabel = \Cake\Utility\Inflector::humanize(
                    \Cake\Utility\Inflector::underscore((string)$this->getRequest()->getParam('controller')),
                );
                ?>
                <nav class="admin-breadcrumb" aria-label="<?= h(__('Breadcrumb')) ?>">
                    <?= $this->Html->link(__('Dashboard'), '/admin') ?>
                    <?php if (in_array($currentAction, ['add', 'edit', 'view'], true)): ?>
                        <span aria-hidden="true">/</span>
                        <?= $this->Html->link($controllerLabel, $returnUrl ?? ['action' => 'index']) ?>
                    <?php endif; ?>
                    <span aria-hidden="true">/</span>
                    <span aria-current="page"><?= h(strip_tags($this->fetch('title'))) ?></span>
                </nav>
            <?php endif; ?>
            <!-- Page Title -->
            <div class="admin-page-header uk-flex uk-flex-between uk-flex-middle uk-margin-small-bottom">
                <div>
                <?php if ($this->fetch('title')): ?>
                    <h2 class="uk-margin-remove">
                        <?= $this->fetch('title') ?>
                    </h2>
                <?php endif; ?>
                <?php if ($this->fetch('subtitle')): ?>
                    <p class="admin-page-subtitle"><?= $this->fetch('subtitle') ?></p>
                <?php endif; ?>
                </div>
                <div class="action-buttons">
                    <?= $this->fetch('actionButtons') ?>
                    <?php if (isset($returnUrl) && in_array($this->getRequest()->getParam('action'), ['add', 'edit'], true)): ?>
                        <?= $this->Html->link(__('Back to list'), $returnUrl, ['class' => 'uk-button uk-button-default']) ?>
                    <?php endif; ?>
                </div>
            </div>
            <hr class="uk-margin-medium-bottom">

            <!-- Flash Messages -->
            <?= $this->Flash->render() ?>

            <!-- Page Content -->
            <?php if ($this->getRequest()->getParam('action') === 'view'): ?>
                <div class="admin-view-container">
                    <?= $this->fetch('content') ?>
                </div>
            <?php else: ?>
                <?= $this->fetch('content') ?>
            <?php endif; ?>
        </div>
    </main>

    <?= $this->fetch('deleteForms') ?>
    <?= $this->fetch('script') ?>
</body>
</html>
