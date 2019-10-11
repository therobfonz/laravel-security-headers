<?php

namespace TheRobFonz\SecurityHeaders\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TheRobFonz\SecurityHeaders\SecurityHeadersGenerator
 */
class SecurityHeaders extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'security-headers';
    }
}
