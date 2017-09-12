<?php

namespace App\Providers;

use App\Channel;
use Cache;
use Illuminate\Support\ServiceProvider;
use View;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // share method run before MigrationTransaction in testing, so that we use composer
        View::composer('*', function ($view) {
            // caching here
            $channels = Cache::rememberForever('channels', function() {
               return Channel::all();
            });

            $view->with('channels', $channels);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal())
        {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
