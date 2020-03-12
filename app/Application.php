<?php namespace App;

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

    protected $route;

    public function __construct()
    {
        $this->container = new Container;

        $this->registerBaseServiceProviders();
    }

    protected function registerBaseServiceProviders()
    {
        $this->registerTrace();
        $this->registerConfig();
        $this->route = new Route($this->container);
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

    public function response()
    {
        try {
            return $this->route->response();
        } catch (\Exception $exception) {
            $this->container['trace']->handleException($exception);
        }
    }
}