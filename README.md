# Selso – Laravel JWT Client Auth Handler

`smactactic/selso` is a Laravel package that provides a simple and flexible handler for managing **JWT (JSON Web Tokens)** authorization for client applications using [firebase/php-jwt](https://github.com/firebase/php-jwt).

---

## 🚀 Installation

Require the package via Composer:

## Installation

```bash
composer require smactactic/selso
```

Add the `LarastromServiceProvider` to your `bootstrap/providers.php` file:

```php
return [
    App\Providers\AppServiceProvider::class,
    Soara\Larastrom\LarastromServiceProvider::class, // add this line
    Tymon\JWTAuth\Providers\LaravelServiceProvider::class // add this line
];
```
