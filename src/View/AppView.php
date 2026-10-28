<?php
declare(strict_types=1);

namespace Uikit\View;

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\View\View;

/**
 * Default application view for Uikit-themed apps and plugins.
 *
 * @property \CakeVite\View\Helper\ViteHelper $Vite
 * @property \Uikit\View\Helper\MenuHelper $Menu
 * @property \Uikit\View\Helper\ImageUploadHelper $ImageUpload
 * @property \Uikit\View\Helper\SortHelper $Sort
 * @property \Uikit\View\Helper\PaginatorHelper $Paginator
 */
class AppView extends View
{
    /**
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadHelper('Uikit.Flash');

        $this->loadHelper('Uikit.Paginator');
        $this->loadHelper('Uikit.Sort');
        $this->loadHelper('Uikit.ImageUpload');

        if (Plugin::isLoaded('CakeVite')) {
            $this->loadHelper('CakeVite.Vite');
        }

        if (Plugin::isLoaded('Icings/Menu')) {
            $this->loadHelper('Uikit.Menu');
        }

        foreach ((array)Configure::read('Uikit.viewHelpers', []) as $helper) {
            if (is_string($helper) && $helper !== '') {
                $this->loadHelper($helper);
            }
        }
    }
}

