<?php

namespace App\Setting;

use App\Builders\Blade;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class GenerateHtml
{
    /**
     * request
     */
    protected $request;

    /**
     * filesystem
     */
    private $filesystem;

    /**
     * root
     */
    private $root;

    public function __construct($views, $cache)
    {
        $this->request = \App\Component\Request::getInstance();
        $this->filesystem = new Filesystem();
        $this->root = dirname(dirname(__DIR__));

        $this->builder($views, $cache);
    }

    protected function builder($views, $cache)
    {
        $source = $this->request->get('dir') != '' ? $this->request->get('dir') : $this->root . '/html';
        $target = $this->getPath($source);
        $clear = $this->request->get('clear', false);

        try {
            $this->makeDirectory($target);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        if ($clear) {
            $this->clearTargetDir($target);
        }

        $this->copyPublicAllFiles($this->root, $target);

        $this->replaceUrl();

        $this->generatorHtml($views, $cache, $this->root, $target);
    }

    private function ignore($root, $views, $files)
    {
        $allfiles = [];
        $config = require $root . '/app/config.php';
        $ignores = $config['ignore'];
        foreach ($files as $file) {
            $is_ignore = false;
            foreach ($ignores as $ignore) {
                if (Str::is($this->getPath($views . '/' . trim(trim($ignore), '/')), $file)) {
                    $is_ignore = true;
                }
            }
            if (!$is_ignore) {
                $allfiles[] = $file;
            }
        }
        return $allfiles;
    }

    private function generatorHtml($views, $cache, $root, $path)
    {
        $views = $this->getPath($views);
        $cache = $this->getPath($cache);
        $blade = new Blade($views, $cache, Container::getInstance());

        $files = $this->filesystem->allFiles($views);
        $files = $this->ignore($root, $views, $files);

        foreach ($files as $file) {
            $target = $this->path_replace($views, $path, $file);
            $file = str_replace([$this->getPath($views . "/"), ".blade.php"], "", $file);
            $html = $blade->make($file)->render();
            $this->generate($target, $html);
        }
    }

    private function generate($target, $html)
    {
        $path = pathinfo($target)['dirname'];
        $this->makeDirectory($path);
        $target = str_replace(".blade.php", ".html", $target);
        $this->filesystem->put($target, $html);
    }

    private function copyPublicAllFiles($root, $path)
    {
        $public = $this->getPath($root . '/public');
        $files = $this->filesystem->allFiles($public);

        foreach ($files as $file) {
            $target = $this->path_replace($public, $path, $file);
            $this->copy($this->getPath($file), $this->getPath($target));
        }
    }

    private function copy($file, $target)
    {
        $path = pathinfo($target)['dirname'];
        $this->makeDirectory($path);
        try {
            $this->filesystem->copy($file, $target);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    private function replaceUrl()
    {
        $url = $this->request->get('url') != '' ? $this->request->get('url') : 'http://www.example.com';
        \App\Component\Url::setInstance($url);
    }

    private function clearTargetDir($target)
    {
        $this->filesystem->cleanDirectory($target);
    }

    private function path_replace($search, $path, $string)
    {
        return str_replace($search, $path, $string);
    }

    private function getPath($path)
    {
        return windows_os() ? str_replace('/', '\\', $path) : $path;
    }

    private function makeDirectory($target)
    {
        try {
            if (!$this->filesystem->isDirectory($target)) {
                $this->filesystem->makeDirectory($target, 0777, true);
            }
        } catch (\Exception $e) {
            throw new \Exception("make target dir fail. error msg:" . $e->getMessage());
        }
    }
}