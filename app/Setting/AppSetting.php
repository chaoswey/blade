<?php

namespace App\Setting;

use App\Builders\Blade;
use App\Builders\Path;
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
        $this->request = \App\Component\Request::getInstance();
        $config = Arr::get($this->container['app_config'], 'views');
        $this->cache = Arr::get($config, 'cache');

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
        new GenerateHtml(Arr::get($config, 'path'), $this->cache, $this->request, $this->container);
        (new RedirectResponse('_setting?status=success'))->send();
        exit;
    }

    public function response()
    {
        $path = Path::os(dirname(__DIR__, 2).'/storage/setting');
        $blade = new Blade($path, $this->cache, $this->container);
        return new Response($blade->make('index')->render(), Response::HTTP_OK, ['content-type' => 'text/html']);
    }
}