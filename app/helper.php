<?php

use App\Url;
use App\Request;

if (!function_exists('url')) {
    function url($path)
    {
        $url = new Url();
        return $url->get($path);
    }
}

if (!function_exists('asset')) {
    function asset($content = null)
    {
        $url = new Url();
        return $url->asset($content);
    }
}

if (!function_exists('is')) {
    function is()
    {
        $request = new Request();
        foreach (func_get_args() as $pattern) {
            return $request->is($pattern);
        }
        return false;
    }
}