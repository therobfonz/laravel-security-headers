<?php

namespace TheRobFonz\SecurityHeaders\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TheRobFonz\SecurityHeaders\ContentSecurityPolicyGenerator
 */
class ContentSecurityPolicy extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'content-security-policy';
    }
}
