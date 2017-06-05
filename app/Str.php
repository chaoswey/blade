<?php namespace App;

class Str
{
    public static function is($pattern, $value)
    {
        if ($pattern == $value) {
            return true;
        }
        $pattern = preg_quote($pattern, '#');
        $pattern = str_replace('\*', '.*', $pattern);
        return (bool) preg_match('#^'.$pattern.'\z#u', $value);
    }
}