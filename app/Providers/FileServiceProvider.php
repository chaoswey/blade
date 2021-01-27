<?php namespace App\Providers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class FileServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bindIf('files', function () {
            return new Filesystem;
        }, true);
    }
}