<?php 
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $entity
 */
$controller = $this->getRequest()->getParam('controller');
$plugin = $this->getRequest()->getParam('plugin') ?: false;
?>
<?= $this->Html->link(
        '<span class="list-actions-icon" uk-icon="icon: eye"></span>', 
        ['prefix' => 'Admin', 'controller' => $controller, 'action' => 'view', $entity->id, 'plugin' => $plugin], 
        ['escape' => false, 'class' => 'uk-icon-link', 'title' => __('View'), 'uk-tooltip' => '']) 
?>
<?= $this->Html->link(
        '<span class="list-actions-icon" uk-icon="icon: file-edit"></span>', 
        ['prefix' => 'Admin', 'controller' => $controller, 'action' => 'edit', $entity->id, 'plugin' => $plugin], 
        ['escape' => false, 'class' => 'uk-icon-link uk-margin-small-left', 'title' => __('Edit'), 'uk-tooltip' => '']) 
?>
<a href="#" class="uk-icon-link uk-margin-small-left list-actions-icon" uk-icon="icon: trash" title="<?= __('Delete') ?>" uk-tooltip 
    onclick="UIkit.modal.confirm('<?= __('Are you sure you want to delete # {0}?', $entity->id) ?>').then(function() {
        document.getElementById('delete-form-<?= $entity->id ?>').submit();
    }); return false;"></a>
<?= $this->Form->create(null, [
    'url' => ['prefix' => 'Admin', 'controller' => $controller, 'action' => 'delete', 'plugin' => $plugin, $entity->id],
    'id' => 'delete-form-' . $entity->id,
    'style' => 'display:none'
]) ?>
<?= $this->Form->end() ?>