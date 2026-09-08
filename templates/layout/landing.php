<?php
/**
 * UIkit Layout Template
 *
 * @var \App\View\AppView $this
 */

$siteName = 'Flight Booking';
?>
<!DOCTYPE html>
<html>
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
    <!-- Render flash messages as notifications -->
    <?php 
    $messages = $this->getRequest()->getFlash()->consume('flash');
    if(!empty($messages)) {
        foreach ($messages as $message) {
            $element = $message['element'] ?? 'notification';
            $elementName = $element === 'notification' ? 'flash/notification' : $element . '_notification';
            echo $this->element($elementName, [
                'message' => $message['message'],
                'params' => $message['params'] ?? [],
            ]);
        }
    }
    ?>

    <!-- Main Content -->
    <?= $this->fetch('content') ?>
    <?= $this->fetch('deleteForms') ?>
    <?= $this->fetch('script') ?>
</body>
</html>
