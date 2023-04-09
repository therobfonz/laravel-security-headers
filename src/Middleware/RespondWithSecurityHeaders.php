<?php

declare(strict_types = 1);

namespace TheRobFonz\SecurityHeaders\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use TheRobFonz\SecurityHeaders\SecurityHeadersGenerator;

class RespondWithSecurityHeaders
{
    public function __construct(
        protected SecurityHeadersGenerator $securityHeaders
    ) {
    }

    /**
     * Add security headers to the request
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        return $this->securityHeaders->attach($response);
    }
}
