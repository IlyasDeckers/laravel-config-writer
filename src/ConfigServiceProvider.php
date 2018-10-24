<?php

namespace Tekreme73\Laravel\ConfigWriter;

use Illuminate\Support\ServiceProvider;
use Tekreme73\Laravel\ConfigWriter\FileWriter;
use Tekreme73\Laravel\ConfigWriter\Repository;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Bind it only once so we can reuse in IoC
        $this->app->singleton('Tekreme73\Laravel\ConfigWriter\Repository', function($app, $items) {
            $writer = new FileWriter($app['files'], $app['path.config']);
            return new Repository($writer, $items);
        });

        $this->app->extend('config', function($config, $app) {
            // Capture the loaded configuration items
            $config_items = $config->all();
            return $app->make('Tekreme73\Laravel\ConfigWriter\Repository', $config_items);
        });
    }
}
