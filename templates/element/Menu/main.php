<?php
/**
 * Main Menu Element
 * 
 * Renders Icings/Menu for public navbar
 * 
 * @var \App\View\AppView $this
 */

// Access Icings Menu helper via the MenuHelper dependency
$icingsMenu = $this->Menu->Menu;

// Access the menu via reflection since _menus is protected
$reflection = new \ReflectionClass($icingsMenu);
$menusProperty = $reflection->getProperty('_menus');
$menusProperty->setAccessible(true);
$menus = $menusProperty->getValue($icingsMenu);

if (isset($menus['main'])) {
    $menu = $menus['main'];
    
    // Get current active item
    $currentItem = $icingsMenu->getCurrentItem('main');
    
    // Helper function for rendering menu items
    $renderMenuItem = function ($item) use (&$renderMenuItem, $currentItem) {
        if (!$item->isDisplayed()) {
            return '';
        }
        
        // Build class list
        $classes = [];
        if ($currentItem && $currentItem === $item) {
            $classes[] = 'uk-active';
        }
        $classAttr = !empty($classes) ? ' class="' . implode(' ', $classes) . '"' : '';
        
        // Build link
        $link = sprintf(
            '<a href="%s">%s</a>',
            h($item->getUri() ?? '#'),
            h($item->getLabel())
        );
        
        return sprintf('<li%s>%s</li>', $classAttr, $link);
    };
    
    echo '<ul class="uk-navbar-nav uk-flex-1">';
    if ($menu->hasChildren()) {
        foreach ($menu->getChildren() as $item) {
            echo $renderMenuItem($item);
        }
    }
    echo '</ul>';
}
?>

