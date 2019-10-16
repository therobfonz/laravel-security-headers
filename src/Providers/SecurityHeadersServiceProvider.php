<?php

namespace TheRobFonz\SecurityHeaders\Providers;

use Illuminate\Support\ServiceProvider;
use TheRobFonz\SecurityHeaders\SecurityHeadersGenerator;

class SecurityHeadersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // initialize the security headers class
        $this->app->singleton(SecurityHeadersGenerator::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // publish the config file
        $source = realpath(__DIR__ . '/../../config/security.php');
        $this->publishes([$source => config_path('security.php')]);
        $this->mergeConfigFrom($source, 'security');
    }

     /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [SecurityHeadersGenerator::class];
    }
}
