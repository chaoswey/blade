<?php namespace App;

use App\Builders\Auth;
use App\Builders\Route;
use Illuminate\Container\Container;
use SlashTrace\EventHandler\DebugHandler;
use SlashTrace\SlashTrace;

class Application
{
    /**
     * @var Container
     */
    protected $container;

    public function __construct()
    {
        $this->container = Container::getInstance();

        $this->registerBaseServiceProviders();
    }

    protected function registerBaseServiceProviders()
    {
        $this->registerTrace();
        $this->registerConfig();
        $this->registerAuthenticator();
        $this->registerRoute();
    }

    protected function registerTrace()
    {
        $this->container->singleton('trace', function () {
            $slashtrace = new SlashTrace();
            $slashtrace->addHandler(new DebugHandler());
            $slashtrace->register();

            return $slashtrace;
        });
    }

    protected function registerConfig()
    {
        $this->container->bindIf('app_config', function () {
            return require dirname(__DIR__) . '/app/config.php';
        }, true);
    }

    protected function registerRoute()
    {
        $this->container->bindIf('route', function () {
            return new Route($this->container);
        }, true);
    }

    protected function registerAuthenticator()
    {
        $this->container->singleton(\Illuminate\Contracts\Auth\Factory::class, function ($app) {
            $app['auth.loaded'] = true;
            return new Auth($app);
        });
    }

    public function response()
    {
        try {
            return $this->container['route']->response();
        } catch (\Exception $exception) {
            if ($this->container['app_config']['debug']) {
                $this->container['trace']->handleException($exception);
            }

            return $this->container['route']->error();
        }
    }
}