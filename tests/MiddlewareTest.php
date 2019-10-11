<?php

namespace TheRobFonz\SecurityHeaders\Tests;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\HeaderBag;
use TheRobFonz\SecurityHeaders\ContentSecurityPolicyGenerator;
use TheRobFonz\SecurityHeaders\Facades\ContentSecurityPolicy;
use TheRobFonz\SecurityHeaders\Middleware\RespondWithSecurityHeaders;

class MiddlewareTest extends TestCase
{
    protected $headers;
    protected $nonce;

    public function setUp(): void
    {
        parent::setUp();
        app(Kernel::class)->pushMiddleware(RespondWithSecurityHeaders::class);

        // set up a route that uses the middleware
        Route::get('middleware-test', function () {
            return 'test';
        });
    }

    /** @test */
    public function it_sets_up_default_security_headers()
    {
        $headers = $this->getResponseHeaders();

        foreach(config('security') as $policy => $value) {
            $this->assertStringContainsString($headers->get($policy), $value);
        }
    }

    /** @test */
    public function it_can_override_default_headers_from_config()
    {
        config([
            'security.X-Frame-Options' => 'deny',
            'security.X-Content-Type-Options' => 'none',
            'security.X-XSS-Protection' => '1',
            'security.Strict-Transport-Security' => 'max-age=3200',
            'security.Referrer-Policy' => 'origin',
            'security.Feature-Policy' => "geolocation 'true'",
            'security.Content-Security-Policy' => (new ContentSecurityPolicyGenerator)->add("default-src", "'self'")
                                                    ->add("object-src", "'none'")
                                                    ->generate()
        ]);
        
        $headers = $this->getResponseHeaders();

        $this->assertStringContainsString('deny', $headers->get('X-Frame-Options'));
        $this->assertStringContainsString('none', $headers->get('X-Content-Type-Options'));
        $this->assertStringContainsString('1', $headers->get('X-XSS-Protection'));
        $this->assertStringContainsString('max-age=3200', $headers->get('Strict-Transport-Security'));
        $this->assertStringContainsString('origin', $headers->get('Referrer-Policy'));
        $this->assertStringContainsString("object-src 'none'", $headers->get('Content-Security-Policy'));
    }

    protected function getResponseHeaders()
    {
        return $this->get('middleware-test')
            ->assertSuccessful()
            ->headers;
    }
}