<?php

use Illuminate\Support\Facades\Route;

Route::get('/currency-exchange-rate/api/documentation', function () {
    return view('CurrencyExchange::documentation');
});
