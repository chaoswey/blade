<?php namespace App;

use App\Component\Request;
use App\Export\Export;
use Jenssegers\Blade\Blade;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Route
{
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

    public function __construct($views, $error, $cache)
    {
        $this->request = Request::getInstance();
        $this->config = require dirname(__DIR__) . '/app/config.php';
        $this->path = $this->builder($this->request->getPathInfo());

        $this->views = $views;
        $this->error = $error;
        $this->cache = $cache;
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

    public function redirect($url)
    {
        $url = $this->request->getSchemeAndHttpHost().$this->request->getBaseUrl().$url;
        (new RedirectResponse($url))->send();
        exit;
    }

    private function ignore()
    {
        $ignores = $this->config['ignore'];
        $path = ltrim($this->path, '/');

        return Arr::first($ignores, function ($ignore) use ($path) {
            return Str::is($ignore, $path);
        }, false);
    }

    public function export()
    {
        $path = ltrim($this->path, '/');
        return $path == $this->config['export'];
    }

    /**
     * 回傳 blade檔案
     */
    public function views()
    {
        if ($this->ignore()) {
            throw new \Exception("blade not exists.");
        }

        if ($this->export()) {
            (new Export($this->views, $this->cache))->response()->send();
            exit;
        }

        $blade = new Blade($this->views, $this->cache);
        switch (true) {
            case $blade->exists($this->path):
                $response = new Response($blade->make($this->path)->render(), Response::HTTP_OK, ['content-type' => 'text/html']);
                $response->send();
                exit;
                break;
            case $blade->exists($this->path . '/index'):
                $this->redirect($this->path . '/');
                break;
            default:
                throw new \Exception("blade not exists.");
        }
    }

    /**
     * 回傳 404檔案
     */
    public function error()
    {
        $blade = new Blade($this->error, $this->cache);
        $response = new Response($blade->make('404')->render(), Response::HTTP_NOT_FOUND, ['content-type' => 'text/html']);
        $response->send();
        exit;
    }
}