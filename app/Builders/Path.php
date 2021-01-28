<?php namespace App\Builders;

class Path
{
    public static $root;

    public function __construct()
    {
        if (empty(static::$root)) {
            static::$root = dirname(__DIR__, 2);
        }
    }

    public static function os($path)
    {
        return windows_os() ? str_replace('/', '\\', $path) : $path;
    }

    public static function root_path(?string $path = null): ?string
    {
        if (empty(static::$root)) {
            new static();
        }

        $path = trim(static::$root, '/').'/'.trim($path, '/');
        return static::os(trim($path, '/'));
    }

    public static function public_path(?string $path = null): ?string
    {
        return static::root_path('public/'.trim($path, '/'));
    }

    public static function storage_path(?string $path = null): ?string
    {
        return static::root_path('storage/'.trim($path, '/'));
    }

    public static function app_path(?string $path = null): ?string
    {
        return static::root_path('app/'.trim($path, '/'));
    }
}