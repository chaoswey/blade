<?php

namespace App\Setting;

use App\Builders\Blade;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\Container as ContainerInterface;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class AppSetting
{
    /**
     * ContainerInterface
     */
    protected $container;

    /**
     * 前端資料夾
     */
    protected $views;

    /**
     * cache資料夾
     */
    protected $cache;

    /**
     * request
     */
    protected $request;

    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container ?: Container::getInstance();
        $config = $this->container['app_config']['views'];
        $this->cache = Arr::get($config, 'cache', null);
        $this->request = \App\Component\Request::getInstance();

        if ($this->request->isMethod('post')) {
            new GenerateHtml(Arr::get($config, 'path', null), $this->cache);
        }
    }

    public function response()
    {
        $blade = new Blade(__DIR__ . '/views', $this->cache, $this->container);
        return new Response($blade->make('index')->render(), Response::HTTP_OK, ['content-type' => 'text/html']);
    }
}