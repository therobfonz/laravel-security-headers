<?php

namespace TheRobFonz\SecurityHeaders\Providers;

use Illuminate\Support\ServiceProvider;
use TheRobFonz\SecurityHeaders\ContentSecurityPolicyGenerator;

class ContentSecurityPolicyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('content-security-policy', function () {
            return app(ContentSecurityPolicyGenerator::class);
        });
        
        // add a blade directive
        $this->app->view->getEngineResolver()->resolve('blade')->getCompiler()->directive('nonce', function () {
            return '<?php echo "nonce=\"" . resolve("content-security-policy")->getNonce() . "\""; ?>';
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [ContentSecurityPolicyGenerator::class];
    }
}
