<?php

namespace TheRobFonz\SecurityHeaders\Tests;

use TheRobFonz\SecurityHeaders\ContentSecurityPolicyGenerator;

class ContentSecurityPolicyTest extends TestCase
{
    protected $csp;

    public function setUp(): void
    {
        parent::setUp();
        $this->csp = resolve('content-security-policy');
    }

	/** @test */
    public function nonce_is_constant()
    {
        
        $nonce1 = $this->csp->getNonce();
        $nonce2 = $this->csp->getNonce();

        $this->assertEquals($nonce1, $nonce2);
        $this->assertEquals(strlen($nonce1), 32);
    }

    /** @test */
    public function it_adds_a_policy()
    {
        
        $this->csp->add('test-src', "'test' http://test.com");

        $this->assertStringContainsString("test-src 'test' http://test.com;", $this->csp->generate());
    }

    /** @test */
    public function nonce_blade_directive_generates_proper_attribute()
    {
        $nonce = $this->csp->getNonce();

        $view = app('view')
            ->file(__DIR__.'/views/view.blade.php')
            ->render();

        $this->assertEquals('<script nonce="'.$nonce.'">', $view);
    }
}