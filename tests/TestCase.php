<?php

namespace TheRobFonz\SecurityHeaders\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use TheRobFonz\SecurityHeaders\Providers\ContentSecurityPolicyServiceProvider;
use TheRobFonz\SecurityHeaders\Providers\SecurityHeadersServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
        	ContentSecurityPolicyServiceProvider::class,
            SecurityHeadersServiceProvider::class,
        ];
    }
}