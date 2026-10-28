<?php
declare(strict_types=1);

namespace Uikit\Test\TestCase;

use App\Application;
use Cake\Core\Configure;
use Cake\Http\ServerRequest;
use PHPUnit\Framework\TestCase;
use Uikit\View\AppView;
use Uikit\View\Helper\MenuHelper;

class MenuHelperIntegrationTest extends TestCase
{
    private mixed $previousAdapters;

    public static function setUpBeforeClass(): void
    {
        $app = new Application(CONFIG);
        $app->bootstrap();
        $app->pluginBootstrap();
    }

    protected function setUp(): void
    {
        $this->previousAdapters = Configure::read('Menu.adminAdapters');
        Configure::write('Menu.adminAdapters', [MenuTestAdapter::class]);
    }

    protected function tearDown(): void
    {
        Configure::write('Menu.adminAdapters', $this->previousAdapters);
    }

    public function testAdapterItemsRespectPermissionAndRender(): void
    {
        $request = (new ServerRequest(['url' => '/admin/demo']))->withAttribute('identity', new MenuTestIdentity());
        $view = new AppView($request);
        $menu = $view->helpers()->get('Menu');
        self::assertInstanceOf(MenuHelper::class, $menu);
        $tree = $menu->adminMenu();
        self::assertNotNull($tree->getChild('section'));
        self::assertNotNull($tree['section']->getChild('allowed'));
        self::assertNull($tree['section']->getChild('denied'));
        self::assertNull($tree->getChild('super_only'));
        self::assertNotNull($tree['section']->getChild('route_allowed'));
        self::assertNull($tree['section']->getChild('route_denied'));
        $html = $view->element('Uikit.Menu/admin');
        self::assertStringContainsString('Visible', $html);
        self::assertStringNotContainsString('Hidden', $html);
    }

    public function testAccountingPermissionWithoutTenantIsDenied(): void
    {
        self::assertFalse(\Accounting\Menu\AdminMenuAdapter::isMenuItemAllowed(new ServerRequest(), 'accounting.coa.read'));
    }

    public function testAnonymousUserCannotSeeRestrictedItems(): void
    {
        $view = new AppView(new ServerRequest());
        $tree = $view->helpers()->get('Menu')->adminMenu();
        self::assertFalse($tree->hasChildren());
    }
}

class MenuTestIdentity
{
    public function getOriginalData(): array
    {
        return ['role' => 'user'];
    }

    public function can(string $action, mixed $resource): bool
    {
        return $action === 'access' && $resource->getParam('controller') === 'Allowed';
    }
}

class MenuTestAdapter
{
    public static function getAdminMenuItems(): array
    {
        return [
            ['id' => 'section', 'label' => 'Section', 'route' => '#', 'children' => [
                ['id' => 'allowed', 'label' => 'Visible', 'route' => '/visible', 'auth' => ['permission' => 'allowed']],
                ['id' => 'denied', 'label' => 'Hidden', 'route' => '/hidden', 'auth' => ['permission' => 'denied']],
                ['id' => 'route_allowed', 'label' => 'Allowed', 'route' => '/allowed', 'auth' => ['controller' => 'Allowed']],
                ['id' => 'route_denied', 'label' => 'Denied', 'route' => '/denied', 'auth' => ['controller' => 'Denied']],
            ]],
            ['id' => 'super_only', 'label' => 'Superuser', 'route' => '/super', 'auth' => ['superuser' => true]],
        ];
    }

    public static function isMenuItemAllowed(ServerRequest $request, string $permission): bool
    {
        return $permission === 'allowed';
    }
}
