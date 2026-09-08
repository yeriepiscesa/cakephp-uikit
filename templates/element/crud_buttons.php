<?php
/**
 * CRUD Action Buttons Element
 * 
 * @var \App\View\AppView $this
 * @var string $type Button type: 'form' (add/edit) or 'view'
 * @var array $entity The entity being displayed/edited
 * @var array $options Additional options
 *   - cancelUrl: URL for cancel button (default: index)
 *   - showDelete: Show delete button (default: true for edit/view)
 *   - showList: Show list button (default: true for view)
 *   - showNew: Show new button (default: true for view)
 *   - returnUrl: Return URL for cancel button
 * @var \Cake\Datasource\EntityInterface $entity
 */

$defaults = [
    'cancelUrl' => ['action' => 'index'],
    'showDelete' => true,
    'showList' => false,
    'showNew' => false,
    'returnUrl' => null,
];
$options = array_merge($defaults, $options ?? []);

// Use returnUrl if provided, otherwise use cancelUrl
$cancelUrl = $options['returnUrl'] ?? $options['cancelUrl'];
?>

<?php if ($type === 'form'): ?>
    <!-- Form buttons (add/edit) -->     
    <hr class="uk-divider uk-margin-large-top">
    <div class="uk-flex uk-flex-between">
        <div class="uk-grid-small" uk-grid>
            <div><?= $this->Html->link(__('Cancel'), $cancelUrl, ['class' => 'uk-button uk-button-default']) ?></div>
            <div><?= $this->Form->button(__('Submit'), ['class' => 'uk-button uk-button-primary']) ?></div>
        </div>
        <div>
            <?php if ($options['showDelete'] && isset($entity->id)): ?>
                <?php $deleteConfirm = __('Are you sure you want to delete # {0}?', $entity->id); ?>
                <?php
                    // postLink saves/restores formProtector, preventing the nested form
                    // from corrupting the parent form's _Token field.
                    $postLinkHtml = $this->Form->postLink(
                        __('Delete'),
                        ['action' => 'delete', $entity->id],
                        ['block' => 'deleteForms', 'method' => 'delete']
                    );
                    preg_match('/document\.(\S+?)\.requestSubmit/', $postLinkHtml, $matches);
                    $deleteFormName = $matches[1] ?? '';
                ?>
                <button
                    type="button"
                    class="uk-button uk-button-danger js-uikit-delete-confirm"
                    data-confirm-message="<?= h($deleteConfirm) ?>"
                    data-delete-form-name="<?= h($deleteFormName) ?>"
                ><?= __('Delete') ?></button>
            <?php endif; ?>
            <?php if ($options['showNew']): ?>
                <?= $this->Html->link(__('New'), ['action' => 'add'], ['class' => 'uk-button uk-button-primary']) ?>
            <?php endif; ?>
        </div>
    </div>

<?php elseif ($type === 'view'): ?>
    <!-- View buttons -->
    <div class="uk-margin-medium-top uk-flex uk-flex-between">
        <div class="uk-grid-small" uk-grid>
            <div><?= $this->Html->link(__('Edit'), ['action' => 'edit', $entity->id], ['class' => 'uk-button uk-button-default']) ?></div>
            
            <?php if ($options['showDelete']): ?>
                <?php $deleteConfirm = __('Are you sure you want to delete # {0}?', $entity->id); ?>
                <?php
                    $postLinkHtml = $this->Form->postLink(
                        __('Delete'),
                        ['action' => 'delete', $entity->id],
                        ['block' => 'deleteForms', 'method' => 'delete']
                    );
                    preg_match('/document\.(\S+?)\.requestSubmit/', $postLinkHtml, $matches);
                    $deleteFormName = $matches[1] ?? '';
                ?>
                <div>
                    <a
                        href="#"
                        class="uk-button uk-button-danger js-uikit-delete-confirm"
                        data-confirm-message="<?= h($deleteConfirm) ?>"
                        data-delete-form-name="<?= h($deleteFormName) ?>"
                    ><?= __('Delete') ?></a>
                </div>    
            <?php endif; ?>
        </div>
        <div class="uk-grid-small" uk-grid>
            <?php if ($options['showList']): ?>
                <div><?= $this->Html->link(__('List'), ['action' => 'index'], ['class' => 'uk-button uk-button-default']) ?></div>
            <?php endif; ?>
            
            <?php if ($options['showNew']): ?>
                <div><?= $this->Html->link(__('New'), ['action' => 'add'], ['class' => 'uk-button uk-button-primary']) ?></div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<?php $this->append('script'); ?>
<script>
    (function () {
        if (window.__crudDeleteConfirmBound) {
            return;
        }
        window.__crudDeleteConfirmBound = true;

        document.addEventListener('click', function (event) {
            var trigger = event.target.closest('.js-uikit-delete-confirm');
            if (!trigger) {
                return;
            }

            event.preventDefault();

            var message = trigger.getAttribute('data-confirm-message') || 'Are you sure?';
            var formName = trigger.getAttribute('data-delete-form-name');
            var form = formName ? document.forms[formName] : null;

            if (!form) {
                return;
            }

            UIkit.modal.confirm(message).then(function () {
                form.requestSubmit();
            }).catch(function () {
                return null;
            });
        });
    })();
</script>
<?php $this->end(); ?>
