<?php

declare(strict_types = 1);

namespace TheRobFonz\SecurityHeaders\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use TheRobFonz\SecurityHeaders\Providers\SecurityHeadersServiceProvider;
use TheRobFonz\SecurityHeaders\Providers\ContentSecurityPolicyServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            ContentSecurityPolicyServiceProvider::class,
            SecurityHeadersServiceProvider::class,
        ];
    }
}
