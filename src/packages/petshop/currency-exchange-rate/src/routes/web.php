<?php

use Illuminate\Support\Facades\Route;
use Petshop\CurrencyExchangeRate\Http\Controllers\CurrencyExchangeRateController;

Route::get('/currency-exchange-rate/api/documentation', function(){
    return view('CurrencyExchange::documentation');
});
