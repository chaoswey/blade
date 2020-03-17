<?php

if (!function_exists('url')) {
    /**
     * @param string $path about, csr/index ...etc
     * @return string
     */
    function url($path = "/")
    {
        return \App\Component\Url::get($path);
    }
}

if (!function_exists('asset')) {
    /**
     * @param null $content images/logo.png, css/style.css...etc
     * @return string
     */
    function asset($content = null)
    {
        return \App\Component\Url::asset($content);
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
        return \App\Component\Request::is($url) ? $class : "";
    }
}

if (!function_exists('dd')) {
    function dd(...$vars)
    {
        foreach ($vars as $v) {
            \Symfony\Component\VarDumper\VarDumper::dump($v);
        }

        exit(1);
    }
}

if (! function_exists('app')) {
    function app($abstract = null, array $parameters = [])
    {
        if (is_null($abstract)) {
            return Illuminate\Container\Container::getInstance();
        }

        return Illuminate\Container\Container::getInstance()->make($abstract, $parameters);
    }
}

if (! function_exists('auth')) {
    /**
     * Get the available auth instance.
     *
     * @param  string|null  $guard
     * @return \Illuminate\Contracts\Auth\Factory|\Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    function auth($guard = null)
    {
        if (is_null($guard)) {
            return app(Illuminate\Contracts\Auth\Factory::class);
        }

        return app(Illuminate\Contracts\Auth\Factory::class)->guard($guard);
    }
}