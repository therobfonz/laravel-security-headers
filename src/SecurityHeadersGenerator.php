<?php

namespace TheRobFonz\SecurityHeaders;

use Illuminate\Support\Str;

class SecurityHeadersGenerator
{
	protected $response;

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
    	foreach (config('security') as $policy => $value) {
            if ($policy == 'Content-Security-Policy') {
                $this->response->headers->set($policy, $this->processCSP($value));
            } else {
                $this->response->headers->set($policy, $value);
            }
    	}

        return $this->response;
    }

    /**
     * Processes the content security policy
     * 
     * @param  mixed $policy
     * @return string
     */
    private function processCSP($policy): string
    {
        if (!is_array($policy)) {
            return $policy;
        }

        $csp = resolve('content-security-policy');
        foreach($policy as $source => $values) {
            $csp->add($source, $values);
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
    	return property_exists($this->response, 'exception') && !$this->response->exception 
                || !property_exists($this->response, 'exception');
    }
}