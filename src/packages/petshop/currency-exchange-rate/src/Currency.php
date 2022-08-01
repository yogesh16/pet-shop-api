<?php

namespace Petshop\CurrencyExchangeRate;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Currency
{
    //Get converted price
    public static function convert(string $currency, float $amount): string
    {
        //Get today's rate
        $rates = Currency::getExchangeRate();

        $item = $rates->where('currency', Str::upper($currency))->first();

        $convertedAmount = isset($item) && is_array($item) ? $item['rate'] * $amount : 0;

        return number_format(floatval($convertedAmount), 2);
    }

    /**
     * Get Today's Currency Rate from Bank
     *
     * @return Collection
     */
    private static function getExchangeRate(): Collection
    {
        try {
            $client = new Client();
            $result = $client->request('GET', config('currencyexchange.url'));

            //Parse result to XML
            $xml = simplexml_load_string(
                $result->getBody(),
                'SimpleXMLElement',
                LIBXML_NOCDATA
            );

            $json = json_encode($xml);
            $array = json_decode($json, true);

            return Currency::parseResult($array);
        } catch (GuzzleException $exception) {
            Log::error('[Currency.getExchangeRate]', [
                $exception->getMessage(),
            ]);
        }

        return Collection::empty();
    }

    /**
     * Parse XML result
     *
     * @param array $data
     *
     * @return Collection
     */
    private static function parseResult(array $data): Collection
    {
        $result = [];

        if (! isset($data['Cube'])) {
            return $result;
        }

        $cube = $data['Cube']['Cube'] ?? [];

        $cube = $cube['Cube'] ?? [];

        foreach ($cube as $item) {
            $result[] = $item['@attributes'] ?? [];
        }

        return collect($result);
    }
}
