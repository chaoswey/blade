<?php namespace App;

use Philo\Blade\Blade;

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
     * 執行檔位置
     */
    protected $scriptName;

    /**
     * 網址
     */
    protected $requestURI;

    /**
     * 實體檔案位置
     */
    protected $filePath;

    /**
     * blade 檔案格式
     */
    protected $path;

    public function __construct($views, $error, $cache)
    {
        $this->views = $views;
        $this->error = $error;
        $this->cache = $cache;
        $this->scriptName = $this->removeIndex($_SERVER['SCRIPT_NAME']);
        $this->requestURI = $this->removeIndex($_SERVER['REQUEST_URI']);
        $this->combinationFolder();
    }

    /**
     * 回傳blade檔案格式
     */
    public function views()
    {
        $blade = new Blade($this->views, $this->cache);
        return $blade->view()->make($this->path)->render();
    }

    /**
     * 判斷檔案
     */
    protected function blade_exists()
    {
        $file = "{$this->views}/{$this->filePath}.blade.php";
        if (windows_os()) {
            $file = str_replace('/', '\\', $file);
        }
        return file_exists($file);
    }


    /**
     * 檢查檔案或者資料夾
     *
     * @param bool $dir
     */
    protected function route_exists($dir = false)
    {
        try {
            if (!$this->blade_exists()) {
                if ($dir) {
                    throw new \Exception('404');
                }
                $this->path .= '.index';
                $this->filePath .= '/index';
                $this->route_exists(true);
            }
        } catch (\Exception $e) {
            $this->error();
        }
    }

    public function error()
    {
        header("HTTP/1.0 404 Not Found");
        $blade = new Blade($this->error, $this->cache);
        return $blade->view()->make('404')->render();
    }

    /**
     * 將 URI / 轉換成 .
     */
    protected function combinationFile()
    {
        $this->path = preg_replace('/\//', '.', $this->filePath);
        if (empty($this->path) || substr($this->path, -1) == '.') {
            $this->filePath .= 'index';
            $this->path .= 'index';
        }
        $this->route_exists();
    }

    /**
     * 移除 ? 及 # 之後字串
     * 移除 特殊字型
     *
     * @return mixed
     */
    protected function removeQueryString()
    {
        $this->filePath = preg_replace('/(\?.*)|(#.*)/', '', ltrim($this->requestURI, '/'));
        $filepath = explode('/', $this->filePath);
        foreach ($filepath as $k => $file) {
            $filepath[$k] = preg_replace('/[^A-Za-z0-9\-\_]/', '', $file);
        }
        $this->filePath = implode('/', $filepath);
        $this->combinationFile();
    }

    /**
     * 如果用資料夾模式打開 組合資料夾
     */
    protected function combinationFolder()
    {
        if (!empty($this->scriptName)) {
            $this->scriptName = addcslashes($this->scriptName, '/');
            $this->requestURI = preg_replace("/{$this->scriptName}/", '', $this->requestURI);
        }
        $this->removeQueryString();
    }

    /**
     * 移除index.php
     *
     * @param $str
     * @return mixed
     */
    protected function removeIndex($str)
    {
        return preg_replace('/\/index.php/', '', $str);
    }
}