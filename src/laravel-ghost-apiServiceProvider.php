<?php

namespace c0013r\laravel-ghost-api;

use Illuminate\Support\ServiceProvider;

class laravel-ghost-apiServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'c0013r');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'c0013r');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

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
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-ghost-api.php', 'laravel-ghost-api');

        // Register the service the package provides.
        $this->app->singleton('laravel-ghost-api', function ($app) {
            return new laravel-ghost-api;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravel-ghost-api'];
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
            __DIR__.'/../config/laravel-ghost-api.php' => config_path('laravel-ghost-api.php'),
        ], 'laravel-ghost-api.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/c0013r'),
        ], 'laravel-ghost-api.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/c0013r'),
        ], 'laravel-ghost-api.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/c0013r'),
        ], 'laravel-ghost-api.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
