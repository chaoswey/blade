<?php namespace App;

use Illuminate\Support\Str;

class Request
{
    protected function getFilePath()
    {
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $scriptName = addcslashes(preg_replace('/\/index.php/', '', $scriptName), '/');

        $filePath = $_SERVER['REQUEST_URI'];
        $filePath = preg_replace("/{$scriptName}/", '', $filePath);
        $filePath = preg_replace('/\/index.php/', '', $filePath);
        $filePath = preg_replace('/(\?.*)|(#.*)/', '', ltrim($filePath, '/'));
        $path = explode('/', $filePath);
        foreach ($path as $k => $file) {
            $path[$k] = preg_replace('/[^A-Za-z0-9\-]/', '', $file);
        }
        $filePath = implode('/', $path);

        return $filePath;
    }

    public function path()
    {
        $pattern = trim($this->getFilePath(), '/');

        return $pattern == '' ? '/' : $pattern;
    }

    public function decodedPath()
    {
        return rawurldecode($this->path());
    }

    public function is($pattern)
    {
        $pattern = $this->check($pattern);
        if (Str::is($pattern, $this->decodedPath())) {
            return true;
        }
        return false;
    }

    protected function check($pattern)
    {
        $pattern = trim(trim($pattern, "/"));
        $url = explode("/", $pattern);
        if (end($url) == "index") {
            array_pop($url);
        }
        $pattern = implode("/", $url);
        if (empty($pattern)) {
            return "/";
        }
        return $pattern;
    }
}