<?php

namespace Petshop\CurrencyExchangeRate\Tests;


use Petshop\CurrencyExchangeRate\Providers\CurrencyExchangeRateServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // additional setup
        $code = [
            'USD',
            'JPY',
            'BGN',
            'CZK',
            'DKK',
            'GBP',
            'HUF',
            'PLN',
            'RON',
            'SEK',
            'CHF',
            'ISK',
            'NOK',
            'HRK',
            'TRY',
            'AUD',
            'BRL',
            'CAD',
            'CNY',
            'HKD',
            'IDR',
            'ILS',
            'INR',
            'KRW',
            'MXN',
            'NZD',
            'PHP',
            'SGD',
            'THB',
            'ZAR',
        ];

        config([
            'currencyexchange.url' =>  'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml',
            'currencyexchange.from' => 'EUR',
            'currencyexchange.codes' => $code
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [
            CurrencyExchangeRateServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }
}
