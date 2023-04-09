<?php

declare(strict_types = 1);

namespace TheRobFonz\SecurityHeaders;

use Illuminate\Support\Str;

class ContentSecurityPolicyGenerator
{
    protected string $nonce = '';
    protected string $policy = '';

    /**
     * Construct the object
     */
    public function __construct()
    {
        $this->generateNonce();
    }

    /**
     * Add to the content security policy
     */
    public function add(string $policy, string $sources): self
    {
        $nonce = '';

        if ($policy === 'script-src') {
            $nonce = "'nonce-" . $this->getNonce() . "' ";
        }

        $this->policy .= "{$policy} {$nonce}{$sources}; ";

        return $this;
    }

    /**
     * Generates the security headers and adds them
     * to the request
     */
    public function generate(): string
    {
        return trim($this->policy);
    }

    /**
     * Get the nonce
     */
    public function getNonce(): string
    {
        return $this->nonce;
    }

    /**
     * Generate a random string
     */
    private function generateNonce(): void
    {
        $this->nonce = Str::random(32);
    }
}
