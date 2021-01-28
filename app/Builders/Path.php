<?php namespace App\Builders;

use Illuminate\Support\Str;

class Path
{
    public static $root;

    public function __construct()
    {
        if (empty(static::$root)) {
            static::$root = Str::start(Str::finish(dirname(__DIR__, 2), '/'), '/');
        }
    }

    public static function os($path)
    {
        return windows_os() ? Str::of($path)->replace('/', '\\') : $path;
    }

    public static function root_path(?string $path = null): ?string
    {
        if (empty(static::$root)) {
            new static();
        }

        $path = Str::finish(static::$root, '/').Str::of($path)->trim('/');
        return static::os($path);
    }

    public static function public_path(?string $path = null): ?string
    {
        return static::root_path('public/'.Str::of($path)->trim('/'));
    }

    public static function storage_path(?string $path = null): ?string
    {
        return static::root_path('storage/'.Str::of($path)->trim('/'));
    }

    public static function app_path(?string $path = null): ?string
    {
        return static::root_path('app/'.Str::of($path)->trim('/'));
    }
}