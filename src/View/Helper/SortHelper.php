<?php
declare(strict_types=1);

namespace Uikit\View\Helper;

use Cake\View\Helper;

/**
 * Sort Helper
 * 
 * Simplifies pagination sorting with automatic sort indicators
 * @property \Cake\View\Helper\PaginatorHelper $Paginator
 */
class SortHelper extends Helper
{
    /**
     * Helpers
     *
     * @var array
     */
    protected array $helpers = ['Paginator'];

    /**
     * Generate sortable column header with icon indicator
     *
     * @param string $field Field name to sort by (e.g., 'id', 'Origins.code')
     * @param string|null $label Label to display (if null, uses field name)
     * @param array $options Additional options for Paginator->sort()
     * @return string
     */
    public function column(string $field, ?string $label = null, array $options = []): string
    {
        $label = $label ?? $field;
        $label = __($label);
        $sortParam = $this->getView()->getRequest()->getQuery('sort');
        $directionParam = $this->getView()->getRequest()->getQuery('direction', 'asc');
        
        // Add sort indicator icon if this column is currently sorted
        if ($sortParam === $field) {
            $icon = $directionParam === 'asc' ? 'triangle-up' : 'triangle-down';
            $label .= ' <span uk-icon="icon: ' . $icon . '; ratio: 0.7"></span>';
        }
        
        $defaultOptions = ['escape' => false];
        $options = array_merge($defaultOptions, $options);
        
        return $this->Paginator->sort($field, $label, $options);
    }

    /**
     * Generate sortable column header with custom icons
     *
     * @param string $field Field name to sort by
     * @param string|null $label Label to display
     * @param array $icons Custom icons ['asc' => 'icon-name', 'desc' => 'icon-name']
     * @param array $options Additional options for Paginator->sort()
     * @return string
     */
    public function columnWithIcons(string $field, ?string $label = null, array $icons = [], array $options = []): string
    {
        $label = $label ?? $field;
        $label = __($label);
        $sortParam = $this->getView()->getRequest()->getQuery('sort');
        $directionParam = $this->getView()->getRequest()->getQuery('direction', 'asc');
        
        $defaultIcons = [
            'asc' => 'triangle-up',
            'desc' => 'triangle-down'
        ];
        $icons = array_merge($defaultIcons, $icons);
        
        if ($sortParam === $field) {
            $icon = $directionParam === 'asc' ? $icons['asc'] : $icons['desc'];
            $label .= ' <span uk-icon="icon: ' . $icon . '; ratio: 0.7"></span>';
        }
        
        $defaultOptions = ['escape' => false];
        $options = array_merge($defaultOptions, $options);
        
        return $this->Paginator->sort($field, $label, $options);
    }
}
