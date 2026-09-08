<?php
declare(strict_types=1);

namespace Uikit\View\Helper;

use Cake\View\Helper\PaginatorHelper as CakePaginatorHelper;

class PaginatorHelper extends CakePaginatorHelper
{
    /**
     * Initialize the helper and set UIkit templates
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);
        
        $this->setTemplates([
            'current' => '<li class="uk-active uk-text-bold"><a href="{{url}}">{{text}}</a></li>'
        ]);
    }
}
