<?php namespace App\Providers;

use App\Compilers\BladeCompiler;
use Illuminate\View\DynamicComponent;
use Illuminate\View\ViewServiceProvider as ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * 編譯器
     * Register the Blade compiler implementation.
     *
     * @return void
     */
    public function registerBladeCompiler()
    {
        $this->app->singleton('blade.compiler', function ($app) {
            return tap(new BladeCompiler($app['files'], $app['config']['view.compiled']), function ($blade) {
                $blade->component('dynamic-component', DynamicComponent::class);
            });
        });
    }
}