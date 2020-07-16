<?php

namespace App\Component;

use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request as RequestBuilder;

class Request
{
    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new RequestBuilder($_GET, $_POST, [], $_COOKIE, $_FILES, $_SERVER);
        }
        return self::$instance;
    }

    public  function is($pattern)
    {
        return Str::is($pattern, ltrim(self::$instance->getPathInfo(), '/'));
    }
}