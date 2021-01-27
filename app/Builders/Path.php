<?php namespace App\Builders;

class Path
{
    public static function os($path)
    {
        return windows_os() ? str_replace('/', '\\', $path) : $path;
    }
}