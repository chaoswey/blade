<?php namespace App\Builders;

use App\Component\Request;
use App\Setting\AppSetting;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\Container as ContainerInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class Route
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
     * 404資料夾
     */
    protected $error;

    /**
     * cache資料夾
     */
    protected $cache;

    /**
     * request
     */
    protected $request;

    /**
     * 檔案路徑
     */
    protected $path;

    /**
     * config
     */
    protected $config;

    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container ?: Container::getInstance();
        $this->request = Request::getInstance();
        $this->config = $this->container['app_config'];
        $this->path = $this->builder($this->request->getPathInfo());

        $this->views = Arr::get($this->config['views'], 'path');
        $this->error = Arr::get($this->config['views'], 'error');
        $this->cache = Arr::get($this->config['views'], 'cache');
    }

    /**
     * @return mixed
     */
    private function ignore()
    {
        //TODO 跳脫
        $ignores = $this->config['ignore'];
        $path = ltrim($this->path, '/');

        return Arr::first($ignores, function ($ignore) use ($path) {
            return Str::is($ignore, $path);
        }, false);
    }

    /**
     * @return bool
     */
    private function export()
    {
        $path = ltrim($this->path, '/');
        return $path == $this->config['config_path'];
    }

    /**
     * 路徑整理
     *
     * @param string $path
     * @return string
     */
    protected function builder($path)
    {
        //有 index 轉跳 /
        Str::is('*index', $path) && $this->redirect(str_replace('index', '', $path));

        //  / 轉成index
        $path == '/' && $path = 'index';
        substr($path, -1) == '/' && $path .= 'index';

        return $path;
    }

    /**
     * @param $url
     * @return RedirectResponse
     */
    public function redirect($url)
    {
        $url = $this->request->getSchemeAndHttpHost() . $this->request->getBaseUrl() . $url;
        return new RedirectResponse($url);
    }

    /**
     * 回傳 blade檔案
     *
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function response()
    {
        if ($this->ignore()) {
            $this->notExists();
        }

        if ($this->export()) {
            return (new AppSetting($this->container))->response();
        }

        $blade = new Blade($this->views, $this->cache, $this->container);

        if ($blade->exists($this->path)) {
            return new Response($blade->make($this->path)->render(), Response::HTTP_OK, ['content-type' => 'text/html']);
        }

        if ($blade->exists($this->path . '/index')) {
            return $this->redirect($this->path . '/');
        }

        $this->notExists();
    }

    /**
     * @return Response
     */
    public function error()
    {
        $blade = new Blade($this->error, $this->cache);
        return new Response($blade->make('404')->render(), Response::HTTP_NOT_FOUND, ['content-type' => 'text/html']);
    }

    /**
     * @throws \Exception
     */
    public function notExists()
    {
        throw new \Exception("blade not exists.");
    }
}