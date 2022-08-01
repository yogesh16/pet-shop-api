<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Exchange URL
    |--------------------------------------------------------------------------
    |
    | This value is URL of bank exchange end point.
    | This is need to fetch Current exchange rate from the bank.
    |
    */

    'url' => 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml',

    /*
    |--------------------------------------------------------------------------
    | Covert From
    |--------------------------------------------------------------------------
    |
    | Currency convert from this this value
    | This is default convert from currency supported.
    */

    'from' => 'EUR',

    /*
    |--------------------------------------------------------------------------
    | Currency codes
    |--------------------------------------------------------------------------
    |
    | This are list of currency code support by the plugin.
    | Pass one of the code to API to convert currency exchange rate.
    |
    */

    'codes' => [
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
    ],
];
