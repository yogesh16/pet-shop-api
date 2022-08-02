<?php

namespace Petshop\CurrencyExchangeRate\Tests\Feature;

use Petshop\CurrencyExchangeRate\Tests\TestCase;

class CurrencyExchangeApiTest extends TestCase
{
    /**
     * API Test for Currency exchange rate
     *
     */
    public function test_can_call_exchange_rate_api()
    {
        $data = [
            'currency' => 'USD',
            'amount' => 100
        ];

        $this->json('GET', '/api/v1/currency-exchange', $data, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
                'error',
                'errors',
                'extra'
            ]);
    }

    /**
     * Validate amount parameter required
     *
     */
    public function test_exchange_rate_api_amount_required()
    {
        $data = [
            'currency' => 'USD'
        ];

        $this->json('GET', '/api/v1/currency-exchange', $data, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonStructure([
                'success',
                'data',
                'error',
                'errors' => [
                    'amount'
                ],
                'trace'
            ]);
    }

    /**
     * Validate currency parameter required
     *
     */
    public function test_exchange_rate_api_currency_required()
    {
        $data = [
            'amount' => 100
        ];

        $this->json('GET', '/api/v1/currency-exchange', $data, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonStructure([
                'success',
                'data',
                'error',
                'errors' => [
                    'currency'
                ],
                'trace'
            ]);
    }

    /**
     * Validate proper currency pass
     *
     */
    public function test_exchange_rate_api_valid_currency_required()
    {
        $data = [
            'amount' => 100,
            'currency' => 'test'
        ];

        $this->json('GET', '/api/v1/currency-exchange', $data, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonStructure([
                'success',
                'data',
                'error',
                'errors' => [
                    'currency'
                ],
                'trace'
            ]);
    }
}
