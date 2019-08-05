<?php namespace App;

use Jenssegers\Blade\Blade;
use App\Component\Request;
use Illuminate\Support\Str;
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
     * request
     */
    protected $path;

    public function __construct($views, $error, $cache)
    {
        $this->request = Request::getInstance();
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
        (new RedirectResponse($url))->send();
    }

    private function ignore()
    {
        $root = dirname(__DIR__);
        $config = require $root . '/app/config.php';
        $ignores = $config['ignore'];
        $path = ltrim($this->path, '/');

        foreach ($ignores as $ignore) {
            if (Str::is($ignore, $path)) {
                return true;
            }
            continue;
        }
        return false;
    }

    /**
     * 回傳 blade檔案
     */
    public function views()
    {
        try {
            if ($this->ignore()) {
                throw new \Exception("blade not exists.");
            }

            $blade = new Blade($this->views, $this->cache);
            switch (true) {
                case $blade->exists($this->path):
                    $response = new Response($blade->make($this->path)->render(), Response::HTTP_OK, ['content-type' => 'text/html']);
                    $response->send();
                    break;
                case $blade->exists($this->path . '/index'):
                    $this->redirect($this->path . '/');
                    break;
                default:
                    throw new \Exception("blade not exists.");
            }
        } catch (\Exception $e) {
            $this->error();
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
    }
}