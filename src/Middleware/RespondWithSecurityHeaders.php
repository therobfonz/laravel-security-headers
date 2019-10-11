<?php

namespace TheRobFonz\SecurityHeaders\Middleware;

use Closure;
use TheRobFonz\SecurityHeaders\Facades\SecurityHeaders;

class RespondWithSecurityHeaders
{
    /**
     * Add security headers to the request
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        return SecurityHeaders::attach($response);
    }
}