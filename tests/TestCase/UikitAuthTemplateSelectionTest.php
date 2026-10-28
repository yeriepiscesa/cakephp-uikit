<?php
declare(strict_types=1);

namespace Uikit\Test\TestCase;

use App\Application;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Http\ServerRequest;
use PHPUnit\Framework\TestCase;

class UikitAuthTemplateSelectionTest extends TestCase
{
    private static Application $app;

    public static function setUpBeforeClass(): void
    {
        self::$app = new Application(CONFIG);
        self::$app->bootstrap();
        self::$app->pluginBootstrap();
    }

    public function testAuthTemplatesAreSelectedAndOtherActionsAreUntouched(): void
    {
        foreach (['login', 'register', 'requestResetPassword', 'requestLoginLink'] as $action) {
            $controller = $this->controller($action);
            self::$app->getEventManager()->dispatch(new Event('Controller.beforeRender', $controller));
            $name = \Cake\Utility\Inflector::underscore($action);
            self::assertSame('Uikit./examples/users/auth/CakeDC/Users/Users/' . $name, $controller->viewBuilder()->getTemplate());
        }

        $controller = $this->controller('profile');
        self::$app->getEventManager()->dispatch(new Event('Controller.beforeRender', $controller));
        self::assertNull($controller->viewBuilder()->getTemplate());
    }

    public function testHostTemplateOverrideTakesPriority(): void
    {
        $previous = Configure::read('App.paths.templates');
        $base = sys_get_temp_dir() . '/uikit-auth-' . bin2hex(random_bytes(8));
        $dir = $base . '/plugin/CakeDC/Users/Users';
        mkdir($dir, 0777, true);
        file_put_contents($dir . '/login.php', '<?php // host override');
        Configure::write('App.paths.templates', [$base . '/']);

        try {
            $controller = $this->controller('login');
            self::$app->getEventManager()->dispatch(new Event('Controller.beforeRender', $controller));
            self::assertNull($controller->viewBuilder()->getTemplate());
        } finally {
            Configure::write('App.paths.templates', $previous);
            unlink($dir . '/login.php');
            rmdir($dir);
            rmdir($base . '/plugin/CakeDC/Users');
            rmdir($base . '/plugin/CakeDC');
            rmdir($base . '/plugin');
            rmdir($base);
        }
    }

    private function controller(string $action): Controller
    {
        return new Controller(new ServerRequest(['params' => [
            'plugin' => 'CakeDC/Users', 'controller' => 'Users', 'action' => $action,
        ]]));
    }
}
