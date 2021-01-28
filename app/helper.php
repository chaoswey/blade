<?php
if (!function_exists('url')) {
    /**
     * @param  null|string  $path  about, csr/index ...etc
     * @return null|string
     */
    function url(?string $path = "/"): string
    {
        return \App\Component\Url::get($path);
    }
}

if (!function_exists('asset')) {
    /**
     * @param  null|string  $content  images/logo.png, css/style.css...etc
     * @return null|string
     */
    function asset(?string $content = null): ?string
    {
        return \App\Component\Url::asset($content);
    }
}

if (!function_exists('url_is')) {
    /**
     * @param  null|string  $url  path*, path...etc
     * @param  string  $class  active, is_active...etc
     * @return null|string
     */
    function url_is(?string $url, $class = "active"): ?string
    {
        return \App\Component\Request::is($url) ? $class : "";
    }
}

if (!function_exists('request')) {
    function request(): \Symfony\Component\HttpFoundation\Request
    {
        return \App\Component\Request::getInstance();
    }
}

if (!function_exists('dd')) {
    function dd(...$vars): void
    {
        foreach ($vars as $v) {
            \Symfony\Component\VarDumper\VarDumper::dump($v);
        }

        exit(1);
    }
}

if (!function_exists('app')) {
    /**
     * @param  null  $abstract
     * @param  array  $parameters
     * @return \Illuminate\Container\Container|mixed|object
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    function app($abstract = null, array $parameters = [])
    {
        if (is_null($abstract)) {
            return Illuminate\Container\Container::getInstance();
        }

        return Illuminate\Container\Container::getInstance()->make($abstract, $parameters);
    }
}

if (!function_exists('auth')) {
    /**
     * Get the available auth instance.
     *
     * @param  string|null  $guard
     * @return \Illuminate\Contracts\Auth\Factory|\Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    function auth(?string $guard = null)
    {
        if (is_null($guard)) {
            return app(Illuminate\Contracts\Auth\Factory::class);
        }

        return app(Illuminate\Contracts\Auth\Factory::class)->guard($guard);
    }
}
if (!function_exists('imageHelper')) {
    function imageHelper(string $path = null, string $format = null, ?int $width = null, ?int $height = null): ?string
    {
        $target = new \App\Builders\Image($path, $format, $width, $height);
        return $target != '' ? asset($target): null;
    }
}