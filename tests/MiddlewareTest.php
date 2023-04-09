<?php

declare(strict_types = 1);

namespace TheRobFonz\SecurityHeaders\Tests;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Route;
use TheRobFonz\SecurityHeaders\ContentSecurityPolicyGenerator;
use TheRobFonz\SecurityHeaders\Middleware\RespondWithSecurityHeaders;

/**
 * @coversDefaultClass \TheRobFonz\SecurityHeaders\Middleware\RespondWithSecurityHeaders
 */
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

    /**
     * @covers ::handle
     */
    public function test_it_sets_up_default_security_headers(): void
    {
        $headers = $this->getResponseHeaders();

        foreach(config('security.headers') as $header => $value) {
            $this->assertArrayHasKey(strtolower($header), $headers->all());
        }
    }

    /**
     * @covers ::handle
     * @covers \TheRobFonz\SecurityHeaders\ContentSecurityPolicyGenerator::add
     * @covers \TheRobFonz\SecurityHeaders\ContentSecurityPolicyGenerator::generate
     */
    public function test_it_can_override_default_headers_from_config(): void
    {
        config([
            'security.headers.X-Frame-Options' => 'deny',
            'security.headers.X-Content-Type-Options' => 'none',
            'security.headers.X-XSS-Protection' => '1',
            'security.headers.Strict-Transport-Security' => 'max-age=3200',
            'security.headers.Referrer-Policy' => 'origin',
            'security.headers.Feature-Policy' => "geolocation 'true'",
            'security.headers.Content-Security-Policy' => (new ContentSecurityPolicyGenerator(request()))->add('default-src', "'self'")
                ->add('object-src', "'none'")
                ->generate(),
        ]);

        $headers = $this->getResponseHeaders();

        $this->assertStringContainsString('deny', $headers->get('X-Frame-Options'));
        $this->assertStringContainsString('none', $headers->get('X-Content-Type-Options'));
        $this->assertStringContainsString('1', $headers->get('X-XSS-Protection'));
        $this->assertStringContainsString('max-age=3200', $headers->get('Strict-Transport-Security'));
        $this->assertStringContainsString('origin', $headers->get('Referrer-Policy'));
        $this->assertStringContainsString("object-src 'none'", $headers->get('Content-Security-Policy'));
    }

    /**
     * @covers ::handle
     */
    public function test_it_disables_security_headers_enabled(): void
    {
        config([
            'security.enabled' => true,
        ]);

        $headers = $this->getResponseHeaders();

        foreach(config('security.headers') as $header => $value) {
            $this->assertArrayHasKey(strtolower($header), $headers->all());
        }
    }

    /**
     * @covers ::handle
     */
    public function test_it_disables_security_headers_if_not_enabled(): void
    {
        config([
            'security.enabled' => false,
        ]);

        $headers = $this->getResponseHeaders();

        foreach(config('security.headers') as $header => $value) {
            $this->assertArrayNotHasKey(strtolower($header), $headers->all());
        }
    }

    /**
     * @covers ::handle
     */
    public function test_it_excludes_routes_in_excludes_config(): void
    {
        config([
            'security.excludes' => [
                'exclude-test/*',
            ],
        ]);

        Route::get('exclude-test/should-be-excluded', function () {
            return 'success';
        });

        $headers = $this->get('exclude-test/should-be-excluded')
            ->assertSuccessful()
            ->headers;

        foreach(config('security.headers') as $header => $value) {
            $this->assertArrayNotHasKey(strtolower($header), $headers->all());
        }
    }

    protected function getResponseHeaders()
    {
        return $this->get('middleware-test')
            ->assertSuccessful()
            ->headers;
    }
}
