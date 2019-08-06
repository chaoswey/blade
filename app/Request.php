<?php namespace App;

use Illuminate\Support\Str;
use App\Component\Request as RequestBuilder;

class Request
{
    protected $builder;

    public function __construct()
    {
        $this->builder = RequestBuilder::getInstance();
    }

    public function is($pattern)
    {
        return Str::is($pattern, ltrim($this->builder->getPathInfo(), '/'));
    }
}