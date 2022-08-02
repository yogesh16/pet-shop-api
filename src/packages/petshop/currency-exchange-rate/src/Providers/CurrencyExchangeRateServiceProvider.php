<?php

namespace Petshop\CurrencyExchangeRate\Providers;

use Illuminate\Support\ServiceProvider;

class CurrencyExchangeRateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //Publish config file
        $this->publishes([
            __DIR__ . '/../../config/currencyexchange.php' => config_path('currencyexchange.php'),
            __DIR__ . '/../resources/swagger' => public_path('vendor/currency-exchange-rate/swagger'),
        ]);

        //Load API Routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        //Load Web Routes for API Documentation
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        //Register View Folder
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'CurrencyExchange');
    }

    public function register()
    {
        $this->app->singleton(Currency::class, function () {
            return new Currency();
        });
    }
}
