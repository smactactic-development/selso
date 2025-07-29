# Selso – Laravel JWT Client Authentication Handler

[![Latest Version](https://img.shields.io/packagist/v/smactactic/selso.svg?style=flat-square)](https://packagist.org/packages/smactactic/selso)
[![License](https://img.shields.io/packagist/l/smactactic/selso.svg?style=flat-square)](https://packagist.org/packages/smactactic/selso)

`smactactic/selso` is a Laravel package that provides secure JWT (JSON Web Token) "Our" Single Sign On authentication for client applications, built on top of [firebase/php-jwt](https://github.com/firebase/php-jwt). The package simplifies JWT token handling and integrates seamlessly with Laravel's middleware system.

## Features

- Easy JWT authentication setup for Laravel applications
- Middleware protection for routes
- Configurable client credentials and redirects
- Built on the reliable firebase/php-jwt library

## Installation

Install the package via Composer:

```bash
composer require smactactic/selso
```

## Configuration

### Environment Variables

Publish the configuration file:

```bash
php artisan vendor:publish --tag=selso-config
```

Update the default guard in `config/auth.php`:

```
'defaults' => [
    'guard' => env('AUTH_GUARD', 'selso'),
    'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
],
```

Add a new guard under the `guards` section:

```
'guards' => [
    // .....

    'selso' => [
        'driver' => 'session',
        'provider' => 'selso',
    ],
]
```

Register a new user `provider` in the providers section:

```
'providers' => [
    .....

    'selso' => [
        'driver' => 'selso',
    ],
],
```

Configure your environment variables in `.env`:

```
SSO_CLIENT_ID=
SSO_CLIENT_SECRET=
SSO_REDIRECT_URI=http://localhost:8001/auth/callback
SSO_SERVER_URL=http://localhost:8000
```

## Post-Login Redirect

Set the default redirect path after successful authentication in config/selso.php:

```php
'redirect_after_login' => '/dashboard',
```

## Usage

Protect your routes using the included middleware:

```php
Route::middleware('selso.auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    // Add other protected routes here
});
```

## Security

If you discover any security related issues, please email the author directly instead of using the issue tracker.
