<?php

use Illuminate\Support\Facades\Route;
use Petshop\CurrencyExchangeRate\Http\Controllers\CurrencyExchangeRateController;

Route::prefix('api/v1')
    ->middleware(['api'])
    ->group(function () {
        Route::get('/currency-exchange', [CurrencyExchangeRateController::class, 'convert']);
    });
