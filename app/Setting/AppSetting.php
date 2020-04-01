<?php

namespace App\Setting;

use App\Builders\Blade;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\Container as ContainerInterface;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\RedirectResponse;
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

        if ($this->request->isMethod('post') && method_exists($this, $this->request->get('type'))) {
            $this->{$this->request->get('type')}($config);
        }
    }

    public function mocklogin($config)
    {
        if ($this->request->get("login", false) == "true") {
            setcookie('app', true, time() + 3600);
        } else {
            unset($_COOKIE['app']);
            setcookie('app', null, -1);
        }

        (new Response(json_encode(['status' => true]), Response::HTTP_OK, ['content-type' => 'application/json']))->send();
        die(1);
    }

    protected function export($config)
    {
        new GenerateHtml(Arr::get($config, 'path', null), $this->cache);
        (new RedirectResponse($this->container['config_path'] . '?status=success'))->send();
        exit;
    }

    public function response()
    {
        $blade = new Blade(__DIR__ . '/views', $this->cache, $this->container);
        return new Response($blade->make('index')->render(), Response::HTTP_OK, ['content-type' => 'text/html']);
    }
}