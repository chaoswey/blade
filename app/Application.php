<?php namespace App;

use Illuminate\Container\Container;

class Application
{
    /**
     * @var Container
     */
    protected $container;

    protected $providers = [
        \App\Providers\WhoopServiceProvider::class,
        \App\Providers\ConfigServiceProvider::class,
        \App\Providers\FileServiceProvider::class,
        \App\Providers\EventServiceProvider::class,
        \App\Providers\ViewServiceProvider::class,
        \App\Providers\RouteServiceProvider::class,
        \App\Providers\AuthenticatorServiceProvider::class,
    ];

    public function __construct()
    {
        $this->container = Container::getInstance();

        $this->registerBaseServiceProviders();
    }

    protected function registerBaseServiceProviders(): void
    {
        foreach ($this->providers as $provider) {
            (new $provider($this->container))->register();
        }
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