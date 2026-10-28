<?php
declare(strict_types=1);

namespace Uikit;

use Cake\Console\CommandCollection;
use Cake\Core\BasePlugin;
use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Core\PluginApplicationInterface;
use Cake\Event\EventInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\RouteBuilder;

/**
 * Plugin for Uikit
 */
class UikitPlugin extends BasePlugin
{
    /**
     * Load all the plugin configuration and bootstrap logic.
     *
     * The host application is provided as an argument. This allows you to load
     * additional plugin dependencies, or attach events.
     *
     * @param \Cake\Core\PluginApplicationInterface $app The host application
     * @return void
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        parent::bootstrap($app);

        $formDefaults = require dirname(__DIR__) . '/config/app.php';
        foreach ($formDefaults['Uikit'] as $key => $default) {
            if (Configure::read('Uikit.' . $key) === null) {
                Configure::write('Uikit.' . $key, $default);
            }
        }

        if (file_exists(dirname(__DIR__) . '/config/app_vite.php')) {
            Configure::load('Uikit.app_vite');
        }

        if (file_exists(dirname(__DIR__) . '/config/app_view.php')) {
            Configure::load('Uikit.app_view');
        }

        $app->getEventManager()->on('Controller.initialize', function (EventInterface $event): void {
            $controller = $event->getSubject();
            if ($controller->viewBuilder()->getClassName() !== null) {
                return;
            }

            $controller->viewBuilder()->setClassName(
                (string)Configure::read('Uikit.viewClass', 'Uikit.App'),
            );
        });

        $app->getEventManager()->on('Controller.beforeRender', function (EventInterface $event): void {
            $controller = $event->getSubject();
            $request = $controller->getRequest();
            if ($request->getParam('plugin') !== 'CakeDC/Users'
                || $request->getParam('controller') !== 'Users'
                || $request->getParam('prefix') !== null
            ) {
                return;
            }

            $builder = $controller->viewBuilder();
            if ($builder->getTheme() !== null && $builder->getTheme() !== 'Uikit') {
                return;
            }
            $template = $builder->getTemplate() ?? $request->getParam('action');
            if (!is_string($template) || str_contains($template, '/') || str_contains($template, '.')) {
                return;
            }
            $template = \Cake\Utility\Inflector::underscore($template);
            $authTemplates = [
                'login', 'register', 'request_login_link', 'request_reset_password',
                'resend_token_validation', 'single_token_login', 'social_email', 'verify', 'webauthn2fa',
            ];
            if (!in_array($template, $authTemplates, true)) {
                return;
            }

            $relativePath = 'CakeDC' . DS . 'Users' . DS . 'Users' . DS . $template . '.php';
            foreach ((array)Configure::read('App.paths.templates', []) as $path) {
                if (is_file(rtrim($path, DS) . DS . 'plugin' . DS . $relativePath)) {
                    return;
                }
            }
            $builder->setTemplate('Uikit./examples/users/auth/CakeDC/Users/Users/' . $template);
        });

        if (PHP_SAPI === 'cli') {
            $app->getEventManager()->on(new Event\BakeListener());
        }
    }

    /**
     * Add routes for the plugin.
     *
     * If your plugin has many routes and you would like to isolate them into a separate file,
     * you can create `$plugin/config/routes.php` and delete this method.
     *
     * @param \Cake\Routing\RouteBuilder $routes The route builder to update.
     * @return void
     */
    public function routes(RouteBuilder $routes): void
    {
        parent::routes($routes);
    }

    /**
     * Add middleware for the plugin.
     *
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to update.
     * @return \Cake\Http\MiddlewareQueue
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        // Add your middlewares here
        // remove this method hook if you don't need it

        return $middlewareQueue;
    }

    /**
     * Add commands for the plugin.
     *
     * @param \Cake\Console\CommandCollection $commands The command collection to update.
     * @return \Cake\Console\CommandCollection
     */
    public function console(CommandCollection $commands): CommandCollection
    {
        // Add your commands here
        // remove this method hook if you don't need it

        $commands = parent::console($commands);

        return $commands;
    }

    /**
     * Register application container services.
     *
     * @param \Cake\Core\ContainerInterface $container The Container to update.
     * @return void
     * @link https://book.cakephp.org/5/en/development/dependency-injection.html#dependency-injection
     */
    public function services(ContainerInterface $container): void
    {
        // Add your services here
        // remove this method hook if you don't need it
    }
}
