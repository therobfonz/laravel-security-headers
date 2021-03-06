<?php

namespace TheRobFonz\SecurityHeaders;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use TheRobFonz\SecurityHeaders\ContentSecurityPolicyGenerator;

class SecurityHeadersGenerator
{
    /** @var object $request */
    protected $request;

    /** @var object $response */
	protected $response;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Generate a random string
     * 
     * @return string
     */
    public function attach($response)
    {
    	$this->response = $response;

    	// don't attach the headers
    	if (!$this->shouldAttachHeaders()) {
    		return $response;
    	}

    	// add the headers to the response
    	foreach (config('security.headers') as $header => $value) {
            if ($header == 'Content-Security-Policy') {
                $this->response->headers->set($header, $this->processContentSecurityPolicy($value));
            } else {
                $this->response->headers->set($header, $value);
            }
    	}

        return $this->response;
    }

    /**
     * Determine if the request has a URI that should pass through CSRF verification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    private function inExceptArray()
    {
        foreach (config('security.excludes') as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($this->request->fullUrlIs($except) || $this->request->is($except)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Processes the content security policy
     * 
     * @param  mixed $policy
     * @return string
     */
    private function processContentSecurityPolicy($header): string
    {
        if (!is_array($header)) {
            return $header;
        }

        $csp = resolve('content-security-policy');
        foreach($header as $policy => $values) {
            $csp->add($policy, $values);
        }

        return $csp->generate();
    }

    /**
     * Decides if headers should be attached to the response
     * 
     * @return bool
     */
    private function shouldAttachHeaders(): bool
    {
        $enabled = config()->has('security.enabled') ? config('security.enabled') : true;

    	return property_exists($this->response, 'exception') 
                    && !$this->response->exception 
                    && $enabled
                    && !$this->inExceptArray()
                || !property_exists($this->response, 'exception') 
                    && $enabled
                    && !$this->inExceptArray();
    }
}