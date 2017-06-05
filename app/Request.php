<?php namespace App;

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
        $filePath = preg_replace('/[^A-Za-z0-9\-]/', '', $filePath);

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

    public function is()
    {
        foreach (func_get_args() as $pattern) {
            if (Str::is($pattern, $this->decodedPath())) {
                return true;
            }
        }
        return false;
    }
}