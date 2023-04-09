<?php

declare(strict_types = 1);

namespace TheRobFonz\SecurityHeaders\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use TheRobFonz\SecurityHeaders\SecurityHeadersGenerator;

class SecurityHeadersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // initialize the security headers class
        $this->app->singleton('SecurityHeadersGenerator', function () {
            $request = app(Request::class);

            return app(SecurityHeadersGenerator::class, [$request]);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // publish the config file
        $source = realpath(__DIR__ . '/../../config/security.php');
        $this->publishes([$source => config_path('security.php')]);
        $this->mergeConfigFrom($source, 'security');
    }

     /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [SecurityHeadersGenerator::class];
    }
}
