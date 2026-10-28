<?php
declare(strict_types=1);

namespace Uikit\View\Helper;

use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\View\Helper;
use Knp\Menu\ItemInterface;

/**
 * Builds shared menu trees from adapters registered by domain plugins.
 *
 * @property \Icings\Menu\View\Helper\MenuHelper $IcingsMenu
 */
class MenuHelper extends Helper
{
    protected array $helpers = [
        'IcingsMenu' => ['className' => 'Icings/Menu.Menu'],
    ];

    private ?ItemInterface $adminMenu = null;
    private ?ItemInterface $mainMenu = null;

    public function adminMenu(): ItemInterface
    {
        if ($this->adminMenu !== null) {
            return $this->adminMenu;
        }

        $menu = $this->IcingsMenu->create('admin');
        $this->adminMenu = $menu;
        foreach ((array)Configure::read('Menu.adminAdapters', []) as $adapter) {
            if (!is_string($adapter) || !is_callable([$adapter, 'getAdminMenuItems'])) {
                continue;
            }
            foreach ($adapter::getAdminMenuItems() as $item) {
                $this->addItem($menu, $item, $adapter);
            }
        }

        return $menu;
    }

    public function mainMenu(): ItemInterface
    {
        return $this->mainMenu ??= $this->IcingsMenu->create('main');
    }

    private function addItem(ItemInterface $parent, array $item, string $adapter): bool
    {
        if (!$this->isAllowed($item, $adapter)) {
            return false;
        }

        $id = (string)($item['id'] ?? '');
        if ($id === '' || !isset($item['label'])) {
            return false;
        }
        $route = $item['route'] ?? '#';
        $uri = is_array($route) ? Router::url($route) : (string)$route;
        $child = $parent->addChild($id, ['label' => (string)$item['label'], 'uri' => $uri]);
        $icon = (string)($item['icon'] ?? '');
        if ($icon !== '') {
            $child->setExtra('templateVars', ['icon' => '<span uk-icon="icon: ' . h($icon) . '"></span>']);
        }

        foreach (($item['children'] ?? []) as $nested) {
            $this->addItem($child, $nested, $adapter);
        }
        if (!empty($item['children']) && !$child->hasChildren() && ($uri === '' || $uri === '#')) {
            $parent->removeChild($id);

            return false;
        }

        return true;
    }

    private function isAllowed(array $item, string $adapter): bool
    {
        $auth = $item['auth'] ?? [];
        if (!$auth) {
            return true;
        }

        $request = $this->getView()->getRequest();
        $identity = $request->getAttribute('identity');
        if ($identity === null) {
            return false;
        }

        if (isset($auth['roles']) || !empty($auth['superuser'])) {
            $data = method_exists($identity, 'getOriginalData') ? $identity->getOriginalData() : $identity;
            $role = (string)($data['role'] ?? '');
            $isSuperuser = !empty($data['is_superuser']) || in_array($role, ['superuser', 'superadmin'], true);
            if (isset($auth['roles']) && !in_array($role, (array)$auth['roles'], true) && !$isSuperuser) {
                return false;
            }
            if (!empty($auth['superuser']) && !$isSuperuser) {
                return false;
            }
        }

        if (isset($auth['permission'])) {
            return is_callable([$adapter, 'isMenuItemAllowed'])
                && $adapter::isMenuItemAllowed($request, (string)$auth['permission']);
        }

        if (isset($auth['controller'])) {
            if (!method_exists($identity, 'can')) {
                return false;
            }
            $route = is_array($item['route'] ?? null) ? $item['route'] : [];
            foreach (['plugin', 'prefix', 'controller', 'action'] as $key) {
                $request = $request->withParam($key, $route[$key] ?? $auth[$key] ?? null);
            }

            return $identity->can('access', $request);
        }

        return true;
    }
}
