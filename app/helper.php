<?php

if (!function_exists('host')) {
    function host($hasIndex = true)
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'];
        if (preg_match('/index.php/', $_SERVER['REQUEST_URI'])) {
            $SCRIPT_NAME = preg_replace('/\/index.php/', '', $_SERVER['SCRIPT_NAME']);
            $uri = explode('/', ltrim($_SERVER['REQUEST_URI'], '/'));
            if (!empty($SCRIPT_NAME)) {
                if ($hasIndex) {
                    $host .= '/' . $uri[0] . '/' . $uri[1] . '/';
                } else {
                    $host .= '/' . $uri[0] . '/';
                }
            } else {
                if ($hasIndex) {
                    $host .= '/' . $uri[0] . '/';
                } else {
                    $host .= '/';
                }
            }
        } else {
            $SCRIPT_NAME = preg_replace('/\/index.php/', '', $_SERVER['SCRIPT_NAME']);
            $host .= $SCRIPT_NAME . '/';
        }

        return $host;
    }
}

if (!function_exists('url')) {
    function url($url)
    {
        return host() . ltrim($url, '/');
    }
}

if (!function_exists('asset')) {
    function asset($url)
    {
        return host(false) .'public/'. ltrim($url, '/');
    }
}