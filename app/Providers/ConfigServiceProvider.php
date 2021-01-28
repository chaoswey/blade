<?php namespace App\Providers;

use App\Builders\Path;
use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('app_config', function () {
            return require Path::app_path('config.php');
        });
    }
}