<?php
/**
 * Admin Menu Element
 * 
 * Renders Icings/Menu for admin sidebar
 * 
 * @var \App\View\AppView $this
 */

// This element only renders menu trees; feature/menu definitions are provided by adapters (eg. Cms plugin).

// Access Icings Menu helper via the MenuHelper dependency
$icingsMenu = $this->Menu->Menu;
$menus = (fn() => $this->_menus)->call($icingsMenu);

if (isset($menus['admin'])) {
    $menu = $menus['admin'];
    
    // Get current active item (exact URL match)
    $currentItem = $icingsMenu->getCurrentItem('admin');

    // Fallback: on add/edit/view pages there's no exact match.
    // Find the deepest menu item whose URI is a prefix of the current request path.
    if ($currentItem === null) {
        $currentPath = rtrim((string)$this->request->getUri()->getPath(), '/');
        $findByPrefix = function (iterable $items) use (&$findByPrefix, $currentPath) {
            $best = null;
            $bestLen = 0;
            foreach ($items as $item) {
                // Recurse into children first (prefer more specific match)
                if ($item->hasChildren()) {
                    $found = $findByPrefix($item->getChildren());
                    if ($found !== null) {
                        $uri = rtrim((string)$found->getUri(), '/');
                        $len = strlen($uri);
                        if ($len > $bestLen) {
                            $best = $found;
                            $bestLen = $len;
                        }
                    }
                }
                $uri = rtrim((string)$item->getUri(), '/');
                if ($uri && $uri !== '#' && str_starts_with($currentPath, $uri . '/')) {
                    if (strlen($uri) > $bestLen) {
                        $best = $item;
                        $bestLen = strlen($uri);
                    }
                }
            }
            return $best;
        };
        if ($menu->hasChildren()) {
            $currentItem = $findByPrefix($menu->getChildren());
        }
    }

    $isInActiveTrail = function ($item) use ($currentItem): bool {
        $node = $currentItem;
        while ($node !== null) {
            if ($node === $item) {
                return true;
            }
            $node = $node->getParent();
        }

        return false;
    };
    
    // Helper function for rendering menu items
    $renderMenuItem = function ($item) use (&$renderMenuItem, $currentItem, $isInActiveTrail) {
        if (!$item->isDisplayed()) {
            return '';
        }

        $isCurrent = $currentItem && $currentItem === $item;
        $isActiveTrail = $isInActiveTrail($item);
        $isParent = $item->hasChildren();
        
        // Get icon from templateVars if available
        $templateVars = $item->getExtra('templateVars') ?? [];
        $icon = $templateVars['icon'] ?? '';
        
        // Generate arrow for parent items
        $arrow = '';
        if ($isParent) {
            $arrow = '<span class="menu-arrow" uk-icon="icon: chevron-down; ratio: 0.8"></span>';
        }
        
        // Build class list
        $classes = [];
        if ($isCurrent || $isActiveTrail) {
            $classes[] = 'uk-active';
        }
        if ($isParent) {
            $classes[] = 'uk-parent';
        }
        if ($isParent && $isActiveTrail) {
            $classes[] = 'uk-open';
        }
        $classAttr = !empty($classes) ? ' class="' . implode(' ', $classes) . '"' : '';
        
        // Build link
        $link = sprintf(
            '<a href="%s">%s<span class="menu-text">%s</span>%s</a>',
            h($item->getUri() ?? '#'),
            $icon,
            h($item->getLabel()),
            $arrow
        );
        
        // Build submenu HTML
        $submenuHtml = '';
        if ($isParent && $item->getDisplayChildren()) {
            $submenuHiddenAttr = $isActiveTrail ? '' : ' hidden';
            $submenuHtml = '<ul class="uk-nav-sub"' . $submenuHiddenAttr . '>';
            foreach ($item->getChildren() as $child) {
                $submenuHtml .= $renderMenuItem($child);
            }
            $submenuHtml .= '</ul>';
        }
        
        return sprintf(
            '<li%s>%s%s</li>',
            $classAttr,
            $link,
            $submenuHtml
        );
    };
    
    echo '<ul class="uk-nav uk-nav-default">';
    if ($menu->hasChildren()) {
        foreach ($menu->getChildren() as $item) {
            echo $renderMenuItem($item);
        }
    }
    echo '</ul>';
}