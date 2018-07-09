<?php

if (!function_exists('url')) {
    function url($path = "/")
    {
        $url = new \App\Url();
        return $url->get($path);
    }
}

if (!function_exists('asset')) {
    function asset($content = null)
    {
        $url = new \App\Url();
        return $url->asset($content);
    }
}

if (!function_exists('url_is')) {
    function url_is($url, $class = "active")
    {
        $request = new \App\Request();
        if ($request->is($url)) {
            return $class;
        }
        return "";
    }
}