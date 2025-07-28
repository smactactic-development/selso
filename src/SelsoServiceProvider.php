<?php

namespace Smactactic\Selso;

use Illuminate\Support\ServiceProvider;

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
    }
}
