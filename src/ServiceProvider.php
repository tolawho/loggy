<?php

namespace Tolawho\Loggy;

use Illuminate\Support\ServiceProvider as Provider;

class ServiceProvider extends Provider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadConfiguration();

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerLoggy();
    }

    /**
     * Load the configuration files and allow them to be published.
     *
     * @author tolawho
     * @return void
     */
    private function loadConfiguration()
    {
        $configPath = __DIR__.'/config.php';

        $this->publishes([$configPath => config_path('loggy.php')], 'config');

        $this->mergeConfigFrom($configPath, 'loggy');
    }

    /**
     *
     *
     * @author tolawho
     */
    private function registerLoggy()
    {
        $this->app->bind('loggy', 'Tolawho\Loggy\Stream\Writer');
    }
}
