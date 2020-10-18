<?php

namespace tiagomichaelsousa\LaravelResources;

use Illuminate\Support\ServiceProvider;

class LaravelResourcesServiceProvider extends ServiceProvider
{
    /**
     * The console commands.
     *
     * @var array
     */
    protected $commands = [
        'tiagomichaelsousa\LaravelResources\Commands\ResourceCommand',
    ];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-resources.php', 'laravel-resources');
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/laravel-resources.php' => config_path('laravel-resources.php'),
        ], 'config');

        // Registering package commands.
        $this->commands($this->commands);
    }
}
