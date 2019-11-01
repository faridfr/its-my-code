<?php

namespace faridfr\itsMyCode;

use Illuminate\Support\ServiceProvider;

class ItsMyCodeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->make('faridfr\itsMyCode\ProveController');
        $this->loadViewsFrom(__DIR__ . '/views', 'itsMyCode');

        if (isNotLumen())
            $this->publishes([
                __DIR__ . '/views' => resource_path('views/vendor/itsMyCode'),
            ], 'view');

        $this->publishes([
            __DIR__.'/../config/itsMyCode.php' => config_path('itsMyCode.php')
        ], 'config');
    }

    public function boot()
    {
        include __DIR__.'/routes.php';
    }
}
