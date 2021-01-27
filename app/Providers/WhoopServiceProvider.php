<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class WhoopServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('whoops', function () {
            $whoops = new \Whoops\Run;
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            $whoops->register();

            return $whoops;
        });
    }
}