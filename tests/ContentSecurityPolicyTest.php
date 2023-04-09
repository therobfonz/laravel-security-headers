<?php

declare(strict_types = 1);

namespace TheRobFonz\SecurityHeaders\Tests;

use TheRobFonz\SecurityHeaders\ContentSecurityPolicyGenerator;

/**
 * @coversDefaultClass TheRobFonz\SecurityHeaders\ContentSecurityPolicyGenerator
 */
class ContentSecurityPolicyTest extends TestCase
{
    protected ContentSecurityPolicyGenerator $csp;

    public function setUp(): void
    {
        parent::setUp();

        $this->csp = resolve('content-security-policy');
    }

    /**
     * @covers ::getNonce
     */
    public function test_nonce_is_constant(): void
    {
        $nonce1 = $this->csp->getNonce();
        $nonce2 = $this->csp->getNonce();

        $this->assertEquals($nonce1, $nonce2);
        $this->assertEquals(strlen($nonce1), 32);
    }

    /**
     * @covers ::add
     */
    public function test_it_adds_a_policy(): void
    {
        $this->csp->add('test-src', "'test' http://test.com");

        $this->assertStringContainsString("test-src 'test' http://test.com;", $this->csp->generate());
    }

    /**
     * @covers ::getNonce
     */
    public function test_nonce_blade_directive_generates_proper_attribute(): void
    {
        $nonce = $this->csp->getNonce();

        $view = app('view')
            ->file(__DIR__ . '/views/view.blade.php')
            ->render();

        $this->assertEquals('<script nonce="' . $nonce . '">', $view);
    }
}
