<?php

namespace Petshop\CurrencyExchangeRate\Tests\Unit;

use Petshop\CurrencyExchangeRate\Currency;
use Petshop\CurrencyExchangeRate\Tests\TestCase;

class CurrencyTest extends TestCase
{
    /**
     * Test Currency convert
     *
     */
    public function test_currency_call()
    {
        $amount = Currency::convert('USD', 10);

        $this->assertTrue(isset($amount));
    }

    /**
     * Test Currency covert return 0 for not allowed currency code.
     *
     */
    public function test_currency_not_found()
    {
        $amount = Currency::convert('YAN', 10);

        $this->assertEquals($amount, '0.00');
    }
}
