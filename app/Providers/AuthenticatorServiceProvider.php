<?php namespace App\Providers;

use App\Builders\Auth;
use Illuminate\Support\ServiceProvider;

class AuthenticatorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(\Illuminate\Contracts\Auth\Factory::class, function ($app) {
            $app['auth.loaded'] = true;
            return new Auth($app);
        });
    }
}