<?php

namespace Petshop\CurrencyExchangeRate;

use Illuminate\Support\ServiceProvider;

class CurrencyExchangeRateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //Publish config file
        $this->publishes([
            __DIR__ . '/../config/currencyexchange.php' => config_path('currencyexchange.php'),
        ]);

        //Load API Routes
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
    }

    public function register()
    {
        $this->app->singleton(Currency::class, function () {
            return new Currency();
        });
    }
}
