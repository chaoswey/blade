<?php

namespace App\Component;

use App\Builders\Url as UrlBuilder;

class Url
{
    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new UrlBuilder();
        }
        return self::$instance;
    }

    public static function setInstance($base_url = null)
    {
        self::$instance = new UrlBuilder($base_url);
    }

    public static function asset($content = null)
    {
        return self::getInstance()->asset($content);
    }

    public static function get($path = "/")
    {
        return self::getInstance()->get($path);
    }
}