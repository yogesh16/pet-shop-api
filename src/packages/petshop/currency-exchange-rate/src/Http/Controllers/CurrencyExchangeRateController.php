<?php

namespace Petshop\CurrencyExchangeRate\Http\Controllers;

use Illuminate\Routing\Controller;
use Petshop\CurrencyExchangeRate\Currency;
use Petshop\CurrencyExchangeRate\Http\Requests\RateRequest;

class CurrencyExchangeRateController extends Controller
{
    public function convert(RateRequest $request)
    {
        //Get validated data
        $data = $request->validated();

        $result['from_currency'] = config('currencyexchange.from');
        $result['from_amount'] = $data['amount'];
        $result['to_currency'] = $data['currency'];

        //Get converted amount
        $result['amount'] = Currency::convert($data['currency'], $data['amount']);

        return response()->json([
            'success' => 1,
            'data' => $result,
            'error' => null,
            'errors' => [],
            'extra' => [],
        ], 200);

        return response()->json(['status' => 'OK'], 200);
    }
}
