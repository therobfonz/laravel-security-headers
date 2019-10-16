<?php

namespace TheRobFonz\SecurityHeaders;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContentSecurityPolicyGenerator
{
	/**
	 * The randomized nonce
	 * 
	 * @var string
	 */
	protected $nonce;

    /**
     * The policy
     * 
     * @var string
     */
    protected $policy;

    /**
     * Construct the object
     */
    public function __construct()
    {
        $this->generateNonce();
    }

    /**
     * Add to the content security policy
     * 
     * @param string $policy
     * @param string $value
     */
    public function add($policy, $sources)
    {
        $nonce = "";
        if ($policy == 'script-src') {
            $nonce = "'nonce-" . $this->getNonce() . "' ";
        }

        $this->policy .= $policy . " " . $nonce . $sources . "; ";
        return $this;
    }

	/**
	 * Generates the security headers and adds them
	 * to the request
	 * 
	 * @return string
	 */
	public function generate(): string
	{
        return trim($this->policy);
	}

    /**
     * Generate a random string
     * 
     * @return string
     */
    private function generateNonce()
    {
        $this->nonce = Str::random(32);
    }

    /**
     * Generate a random string
     * 
     * @return string
     */
    public function getNonce(): string
    {
        return $this->nonce;
    }
}