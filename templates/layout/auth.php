<?php
/**
 * UIkit Layout Template
 *
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;

$siteName = (string)\Cake\Core\Configure::read('Uikit.siteName', 'Application');
?>
<!DOCTYPE html>
<html lang="<?= h(\Cake\I18n\I18n::getLocale()) ?>">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= h($siteName) ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?php
    // Load Vite assets for Uikit theme
    $this->Vite->script([
        'devEntries' => ['resources/js/uikit.js'],
        'prodFilter' => 'uikit.js',
        'config' => 'uikit',
    ]);
    ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->element('Uikit.branding_styles') ?>
</head>
<body>
    <?php if ($languageSwitcher = \Cake\Core\Configure::read('Uikit.languageSwitcherElement')): ?>
        <div class="uk-flex uk-flex-right uk-padding-small">
            <?= $this->element($languageSwitcher) ?>
        </div>
    <?php endif; ?>


    <!-- Main Content -->
<?php
$siteName = (string)Configure::read('Uikit.siteName', 'Application');
$tagline = (string)Configure::read('Uikit.branding.tagline', __('Workspace'));
$loginImage = Configure::read('Uikit.branding.loginImage');
$logo = Configure::read('Uikit.branding.logo');
?>
<main class="theme-login-shell">
    <section class="theme-login-story">
        <?php if ($loginImage): ?><img class="theme-login-image" src="<?= h($this->Url->build((string)$loginImage)) ?>" alt=""><?php endif; ?>
        <div class="theme-login-story-content">
            <a class="theme-brand theme-brand-light" href="<?= h($this->Url->build('/')) ?>">
                <?php if ($logo): ?><img class="theme-brand-logo" src="<?= h($this->Url->build((string)$logo)) ?>" alt=""><?php else: ?><span class="theme-brand-mark" aria-hidden="true">&#10022;</span><?php endif; ?>
                <span><?= h($siteName) ?><small><?= h($tagline) ?></small></span>
            </a>
            <div class="theme-login-message">
                <span class="theme-eyebrow"><?= h((string)Configure::read('Uikit.branding.loginEyebrow', __('Welcome'))) ?></span>
                <h1><?= h((string)Configure::read('Uikit.branding.loginTitle', __('A more organized day.'))) ?></h1>
                <p><?= h((string)Configure::read('Uikit.branding.loginDescription', __('A simple workspace for your team.'))) ?></p>
            </div>
            <p class="theme-login-footer">&copy; <?= date('Y') ?> <?= h($siteName) ?></p>
        </div>
    </section>
    <section class="theme-login-main"><div class="theme-login-card">
        <div class="theme-login-mobile-brand theme-brand"><?php if ($logo): ?><img class="theme-brand-logo" src="<?= h($this->Url->build((string)$logo)) ?>" alt=""><?php else: ?><span class="theme-brand-mark" aria-hidden="true">&#10022;</span><?php endif; ?><span><?= h($siteName) ?><small><?= h($tagline) ?></small></span></div>
        <?= $this->Flash->render() ?>
        <?= $this->Flash->render('auth') ?>
        <?= $this->fetch('content') ?>
    </div></section>
</main>
    <?= $this->fetch('deleteForms') ?>
    <?= $this->fetch('script') ?>
</body>
</html>

