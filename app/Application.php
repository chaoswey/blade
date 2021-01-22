<?php namespace App;

use App\Builders\Auth;
use App\Builders\Route;
use Illuminate\Container\Container;
use function set_error_handler;

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

    protected function registerBaseServiceProviders(): void
    {
        $this->registerWhoops();
        $this->handler();
        $this->registerConfig();
        $this->registerAuthenticator();
        $this->registerRoute();
    }

    protected function handler()
    {
        set_error_handler(static function ($errno, $errstr, $errfile, $errline, $errcontext) {
            throw new \Exception($errstr, $errno);
        });
    }

    protected function registerWhoops(): void
    {
        $this->container->singleton('whoops', function () {
            $whoops = new \Whoops\Run;
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            $whoops->register();

            return $whoops;
        });
    }

    protected function registerConfig(): void
    {
        $this->container->bindIf('app_config', function () {
            return require dirname(__DIR__).'/app/config.php';
        }, true);
    }

    protected function registerRoute(): void
    {
        $this->container->bindIf('route', function () {
            return new Route($this->container);
        }, true);
    }

    protected function registerAuthenticator(): void
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
                $this->container['whoops']->handleException($exception);
            }

            return $this->container['route']->error();
        }
    }
}