<?php

use App\Url;

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