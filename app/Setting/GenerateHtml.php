<?php

namespace App\Setting;

use App\Builders\Blade;
use App\Builders\Path;
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

    /**
     *
     */
    private $container;

    public function __construct($views, $cache, $request, $container)
    {
        $this->request = $request;
        $this->container = $container;
        $this->filesystem = $container['files'];
        $this->root = Path::root_path();

        $this->builder($views, $cache);
    }

    protected function builder($views, $cache)
    {
        $source = $this->request->get('dir') != '' ? $this->request->get('dir') : $this->root.'/html';
        $target = Path::os($source);
        $clear = $this->request->get('clear', false);
        $this->makeDirectory($target);
        if ($clear) {
            $this->clearTargetDir($target);
        }

        $this->copyPublicAllFiles($this->root, $target);

        $this->replaceUrl();

        $this->generatorHtml($views, $cache, $target);
    }

    private function ignore($views, $files)
    {
        $allfiles = [];
        $config = $this->container['app_config'];
        $ignores = array_merge($config['ignore'], [$config['guess']], $config['components']);

        foreach ($files as $file) {
            $is_ignore = false;
            foreach ($ignores as $ignore) {
                $path = $views.'/'.trim(trim(trim($ignore), '/'), '*').'*';
                if (Str::is(Path::os($path), $file)) {
                    $is_ignore = true;
                }
            }
            if (!$is_ignore) {
                $allfiles[] = $file;
            }
        }

        return $allfiles;
    }

    private function generatorHtml($views, $cache, $path)
    {
        $views = Path::os($views);
        $cache = Path::os($cache);
        $blade = new Blade($views, $cache, $this->container);

        $files = $this->filesystem->allFiles($views);
        $files = $this->ignore($views, $files);

        foreach ($files as $file) {
            $target = $this->path_replace($views, $path, $file);
            $file = str_replace([Path::os($views."/"), ".blade.php"], "", $file);
            $html = $blade->make($file)->render();
            $this->generate($target, $html);
        }
    }

    private function generate($target, $html)
    {
        $path = pathinfo($target, PATHINFO_DIRNAME);
        $this->makeDirectory($path);
        $target = str_replace(".blade.php", ".html", $target);
        $this->filesystem->put($target, $html);
    }

    private function copyPublicAllFiles($root, $path)
    {
        $public = Path::os($root.'/public');
        $files = $this->filesystem->allFiles($public);

        foreach ($files as $file) {
            $target = $this->path_replace($public, $path, $file);
            $this->copy(Path::os($file), Path::os($target));
        }
    }

    private function copy($file, $target)
    {
        $path = pathinfo($target, PATHINFO_DIRNAME);
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

    private function makeDirectory($target)
    {
        if (!$this->filesystem->isDirectory($target)) {
            $this->filesystem->makeDirectory($target, 0777, true);
        }
    }
}