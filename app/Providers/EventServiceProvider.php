<?php namespace App\Providers;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bindIf('events', function () {
            return new Dispatcher;
        }, true);
    }
}