<?php

namespace Petshop\CurrencyExchangeRate\Http\Controllers;

use Illuminate\Routing\Controller;
use Petshop\CurrencyExchangeRate\Currency;
use Petshop\CurrencyExchangeRate\Http\Requests\RateRequest;

/**
 * @OA\Info(
 *     description="This is API Documentation for Currency Exchange rate.
 * This API uses [European Central Bank Reference rates](https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml) To convert Currency Exchange Rate.
 * This API Support currency conversion from EURO Only",
 *     title="Currency Exchange Rate API",
 *     version="1.0"
 * )
 *
 * @OA\Tag(
 *     name="Currency",
 *     description="Currency exchange rate endpoint"
 * )
 */

class CurrencyExchangeRateController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/currency-exchange",
     *     tags={"Currency"},
     *     summary="Convert currency rate from Euro",
     *     @OA\Parameter(
     *          in="query",
     *          name="amount",
     *          required=true,
     *          description="Amount in Euro",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Parameter(
     *          in="query",
     *          name="currency",
     *          required=true,
     *          description="Currency code to convert from Euro",
     *          @OA\Schema(
     *              type="string",
     *              enum={"USD", "JPY", "BGN", "CZK", "DKK", "GBP", "HUF", "PLN",
     *     "RON", "SEK", "CHF", "ISK", "NOK", "HRK", "TRY", "AUD", "BRL", "CAD",
     *     "CNY", "HKD", "IDR", "ILS", "INR", "KRW", "MXN", "NZD", "PHP", "SGD", "THB", "ZAR"},
     *          ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Page not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     ),
     * )
     */
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
