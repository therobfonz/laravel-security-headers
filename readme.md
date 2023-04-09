# Laravel Security Headers

This is a [Laravel](http://laravel.com/) service provider for adding security header responses to your application.

## Installation

The SecurityHeaders Service Provider can be installed via [Composer](http://getcomposer.org) by requiring the
`therobfonz/laravel-security-headers` package in your project's `composer.json`.

```json
{
    "require": {
        "therobfonz/laravel-security-headers": "^2.0"
    }
}
```

Packages are auto-discovered in Laravel 5.6+. Service Providers and Facades are defined in **composer.json**.

## Config File

Publish the confirguration file using Artisan.

```sh
php artisan vendor:publish --provider="TheRobFonz\SecurityHeaders\SecurityHeadersServiceProvider"
```

Update your settings in the generated `config/security.php` configuration file.

## Configuration

Add the middleware to the 'web' middleware group in `App\Http\Kernel.php`

```php
protected $middlewareGroups = [
    'web' => [
        //...
    
        \TheRobFonz\SecurityHeaders\Middleware\RespondWithSecurityHeaders::class,
```

### Nonces

Every inline script tag needs to include the `@nonce` blade directive in the opening tag.

```php
<script @nonce>
```

## Links

* [Laravel website](http://laravel.com/)
