<?php namespace App\Providers;

use App\Builders\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('route', function () {
            return new Route($this->app);
        });
    }
}