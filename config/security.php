<?php

declare(strict_types = 1);

return [
    /**
     * Routes to exclude from the security header response
     */
    'excludes' => [
    ],

    /**
     * Used to enable or disable adding the security headers to the response
     */
    'enabled' => env('SECURITY_HEADERS', true),

    /**
     * Changes Content-Security-Policy to report-only
     */
    'csp_report_only' => env('SECURITY_CSP_REPORT_ONLY', false),

    'headers' => [
        /*
         * Used to indicate whether or not a browser should be allowed to render a page
         * in a <frame>, <iframe>, <embed> or <object>.
         *
         * Options: see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Frame-Options
         */
        'X-Frame-Options' => 'sameorigin',

        /*
         * Used by the server to indicate that the MIME types advertised in the Content-Type headers
         * should not be changed and be followed.
         *
         * Options: see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Content-Type-Options
         */
        'X-Content-Type-Options' => 'nosniff',

        /*
         * A feature of Internet Explorer, Chrome and Safari that stops pages from loading when
         * they detect reflected cross-site scripting (XSS) attacks.
         *
         * Options: see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-XSS-Protection
         */
        'X-XSS-Protection' => '1; mode=block',

        /*
         * Lets a web site tell browsers that it should only be accessed using HTTPS, instead of using HTTP.
         *
         * Options: see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Strict-Transport-Security
         */
        'Strict-Transport-Security' => 'max-age=31536000 ; includeSubDomains; preload',

        /*
         * Governs which referrer information, sent in the Referer header, should be included with requests made.
         *
         * Options: see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Referrer-Policy
         */
        'Referrer-Policy' => 'strict-origin-when-cross-origin',

        /*
         * Provides a mechanism to allow and deny the use of browser features in its own frame, and in content
         * within any <iframe> elements in the document.
         *
         * Options: see https://developer.mozilla.org/en-US/docs/Web/HTTP/Permissions_Policy
         */
        'Permissions-Policy' => "accelerometer=(), ambient-light-sensor=(), attribution-reporting=(), autoplay=(), bluetooth=(), browsing-topics=(), camera=(), compute-pressure=(), display-capture=(), document-domain=(), encrypted-media=(), fullscreen=(), gamepad=(), geolocation=(), gyroscope=(), hid=(), identity-credentials-get=(), idle-detection=(), local-fonts=(), magnetometer=(), microphone=(), midi=(), otp-credentials=(), payment=(), picture-in-picture=(), publickey-credentials-create=(), publickey-credentials-get=(), screen-wake-lock=(), serial=(), speaker-selection=(), storage-access=(), usb=(), web-share=(), window-management=(), xr-spatial-tracking=()",

        /*
         * Configures embedding cross-origin resources into the document.
         *
         * Options: see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cross-Origin-Embedder-Policy
         */
        'Cross-Origin-Embedder-Policy' => 'require-corp; report-to="default"',

        /*
         * Allows you to ensure a top-level document does not share a browsing context group with cross-origin documents.
         * COOP will process-isolate your document and potential attackers can't access your global object if they were
         * to open it in a popup, preventing a set of cross-origin attacks dubbed XS-Leaks
         *
         * Options: see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cross-Origin-Opener-Policy
         */
        'Cross-Origin-Opener-Policy' => 'same-origin;  report-to="default"',

        /*
         * Allows web site administrators to control resources the user agent is allowed to load for a given page.
         *
         * NOTE: The semicolon at the end of the policy will be automatically added as well as the nonce for script-src
         *
         * Options: see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy
         */
        'Content-Security-Policy' => [
            'default-src' => "'self'",
            'script-src' => "'self'",
            'style-src' => "'self'",
            'img-src' => "'self'",
            'font-src' => "'self'",
            'frame-src' => "'self'",
            'object-src' => "'self'",
        ],
    ],
];
