<?php

namespace Petshop\CurrencyExchangeRate;

use Illuminate\Support\ServiceProvider;

class CurrencyExchangeRateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/currencyexchange.php' => config_path('currencyexchange.php'),
        ]);
    }

    public function register()
    {
        $this->app->singleton(Currency::class, function () {
            return new Currency();
        });
    }
}
