<?php

namespace TheRobFonz\SecurityHeaders\Middleware;

use Closure;
use TheRobFonz\SecurityHeaders\SecurityHeadersGenerator;

class RespondWithSecurityHeaders
{
    /** @var SecurityHeadersGenerator $security_headers */
    protected $security_headers;
    
    public function __construct(SecurityHeadersGenerator $security_headers)
    {
        $this->security_headers = $security_headers;
    }
    
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

        return $this->security_headers->attach($response);
    }
}