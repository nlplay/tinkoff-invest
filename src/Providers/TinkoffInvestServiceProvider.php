<?php

namespace Nlplay\TinkoffInvest\Providers;

use Illuminate\Support\ServiceProvider;
use Nlplay\TinkoffInvest\TinkoffInvest;

class TinkoffInvestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('tinkoff-invest', function () {
            return new TinkoffInvest();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/tinkoff.php' => config_path('tinkoff.php'),
        ], 'tinkoff-invest');
    }
}
