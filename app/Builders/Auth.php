<?php namespace App\Builders;

use Illuminate\Contracts\Auth\Factory as AuthFactory;

class Auth implements AuthFactory
{
    public function __construct($app)
    {
    }

    public function guard($name = null)
    {
        return new Guard();
    }

    public function shouldUse($name)
    {

    }
}