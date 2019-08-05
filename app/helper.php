<?php

if (!function_exists('url')) {
    /**
     * @param string $path about, csr/index ...etc
     * @return string
     */
    function url($path = "/")
    {
        return \App\Component\Url::getInstance()->get($path);
    }
}

if (!function_exists('asset')) {
    /**
     * @param null $content images/logo.png, css/style.css...etc
     * @return string
     */
    function asset($content = null)
    {
        return \App\Component\Url::getInstance()->asset($content);
    }
}

if (!function_exists('url_is')) {
    /**
     * @param string $url path*, path...etc
     * @param string $class active, is_active...etc
     * @return string
     */
    function url_is($url, $class = "active")
    {
        return (new \App\Request())->is($url) ? $class : "";
    }
}