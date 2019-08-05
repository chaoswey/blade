<?php

namespace App\Component;

use App\Url as UrlBuilder;

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
}