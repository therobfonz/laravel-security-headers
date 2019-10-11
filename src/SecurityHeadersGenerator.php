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
    	foreach (config('security') as $header => $value) {
    		$this->response->headers->set($header, $value);
    	}

        return $this->response;
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