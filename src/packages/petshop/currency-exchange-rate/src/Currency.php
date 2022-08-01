<?php

namespace Petshop\CurrencyExchangeRate;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class Currency
{
    //Get converted price
    public static function get(string $from, string $to, float $price): float
    {
        dd(Currency::getExchangeRate()->where('currency', 'JPY')->first());
        return $price;
    }

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
