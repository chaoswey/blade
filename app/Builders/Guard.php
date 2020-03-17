<?php namespace App\Builders;

class Guard
{
    public function check()
    {
        return !empty($_COOKIE['app']);
    }

    public function guest()
    {
        return empty($_COOKIE['app']);
    }
}