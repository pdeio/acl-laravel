<?php namespace Pdeio\Entrust;

/**
 * This file is part of Entrust,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package Pdeio\Entrust
 */

use Illuminate\Support\ServiceProvider;

class EntrustServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // register command
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('entrust.php'),
        ]);
        //load migrations and routes
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Publish config files
        $this->mergeConfigFrom(
            __DIR__ . '/config/config.php',
            'entrust.php'
        );
        $this->registerEntrust();
    }

  

    /**
     * Register the application bindings.
     *
     * @return void
     */
    private function registerEntrust()
    {
        $this->app->bind('entrust', function ($app) {
            return new Entrust($app);
        });

        $this->app->alias('entrust', 'Pdeio\Entrust\Entrust');
    }
}
