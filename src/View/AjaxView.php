<?php
declare(strict_types=1);

namespace Uikit\View;

/**
 * AJAX view using Uikit helpers and defaults.
 */
class AjaxView extends AppView
{
    protected string $layout = 'ajax';

    /**
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->response = $this->response->withType('ajax');
    }
}
