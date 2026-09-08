<?php
declare(strict_types=1);

namespace Uikit\Event;

use Cake\Event\EventInterface;
use Cake\Event\EventListenerInterface;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;

/**
 * Bake event listener for upload field detection in Uikit templates.
 */
class BakeListener implements EventListenerInterface
{
    /**
     * @return array<string, string>
     */
    public function implementedEvents(): array
    {
        return [
            'Bake.initialize' => 'bakeInitialize',
            'Bake.beforeRender' => 'bakeBeforeRender',
        ];
    }

    /**
     * Bake beforeRender callback.
     */
    public function bakeBeforeRender(EventInterface $event): void
    {
        $view = $event->getSubject();

        $fileFields = [];
        $uploadRelatedFields = [];

        $modelClass = null;
        if (isset($view->model)) {
            $modelClass = $view->model;
        } elseif (isset($view->pluralVar)) {
            $modelClass = Inflector::camelize($view->pluralVar);
        }

        if ($modelClass) {
            try {
                $table = TableRegistry::getTableLocator()->get($modelClass);

                if ($table->hasBehavior('Upload')) {
                    $uploadBehavior = $table->getBehavior('Upload');
                    $uploadConfig = $uploadBehavior->getConfig();

                    foreach ($uploadConfig as $field => $config) {
                        if (is_string($field) && is_array($config) && isset($config['fields'])) {
                            $fileFields[] = $field;
                            if (is_array($config['fields'])) {
                                $uploadRelatedFields = array_merge(
                                    $uploadRelatedFields,
                                    array_values($config['fields']),
                                );
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                // Silent fail if model not found
            }
        }

        $view->set('fileFields', $fileFields);
        $view->set('uploadRelatedFields', array_unique($uploadRelatedFields));
    }

    /**
     * Bake initialize callback.
     */
    public function bakeInitialize(EventInterface $event): void
    {
    }
}
