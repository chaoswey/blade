<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('app_config', function () {
            return require dirname(__DIR__).'/config.php';
        });
    }
}