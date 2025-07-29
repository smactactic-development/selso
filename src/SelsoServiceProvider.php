<?php

namespace Smactactic\Selso;

use Smactactic\Selso\Extensions\SelsoUserProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Smactactic\Selso\Http\Middleware\SelsoAuthenticate;

class SelsoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/selso.php' => config_path('selso.php'),
        ], 'config');

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        Auth::provider('selso', function ($app, array $config) {
            return new SelsoUserProvider();
        });

        app('router')->aliasMiddleware('selso.auth', SelsoAuthenticate::class);
    }
}
