<?php
/**
 * UIkit Layout Template
 *
 * @var \App\View\AppView $this
 */

$siteName = 'Travel';
?>
<!DOCTYPE html>
<html lang="<?= h(\Cake\I18n\I18n::getLocale()) ?>">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $siteName ?>:
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
</head>
<body>
    <!-- Navigation -->
    <nav class="uk-navbar-container" uk-navbar>
        <div class="uk-navbar-left">
            <a class="uk-navbar-item uk-logo" href="<?= $this->Url->build('/') ?>">
                <?= $siteName ?>
            </a>
        </div>
        <div class="uk-navbar-right">
            <?php if ($languageSwitcher = \Cake\Core\Configure::read('Uikit.languageSwitcherElement')): ?>
                <?= $this->element($languageSwitcher) ?>
            <?php endif; ?>

            <?= $this->element('Menu/main') ?>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="uk-container uk-container-large uk-margin-top">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </main>

    <!-- Footer -->
    <footer class="uk-section uk-section-secondary uk-padding-small uk-margin-large-top">
        <div class="uk-container">
            <p class="uk-text-center uk-text-small">
                &copy; <?= date('Y') ?> <?= $siteName ?>. Powered by CakePHP & UIkit.
            </p>
        </div>
    </footer>
    
    <?= $this->fetch('deleteForms') ?>
    <?= $this->fetch('script') ?>
</body>
</html>
