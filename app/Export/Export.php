<?php

namespace App\Export;

use App\Export\GenerateHtml;
use Jenssegers\Blade\Blade;
use Symfony\Component\HttpFoundation\Response;

class Export
{
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

    public function __construct($views, $cache)
    {
        $this->cache = $cache;
        $this->request = \App\Component\Request::getInstance();

        if ($this->request->isMethod('post')) {
            new GenerateHtml($views, $cache);
        }
    }

    public function response()
    {
        $blade = new Blade(__DIR__ . '/views', $this->cache);
        return new Response($blade->make('index')->render(), Response::HTTP_OK, ['content-type' => 'text/html']);
    }
}