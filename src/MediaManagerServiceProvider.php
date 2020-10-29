<?php

namespace MasterDmx\LaravelMediaManager;

use Illuminate\Support\ServiceProvider;

class MediaManagerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this->publishes([
            __DIR__.'/../resources/js' => resource_path('js/vendor/media-manager'),
            __DIR__.'/../resources/sass' => resource_path('sass/vendor/media-manager'),
        ], 'media-manager');
    }


    public function register()
    {
        $this->mergeConfigFrom( __DIR__.'/../config/media-manager.php', 'media-manager');
    }
}
