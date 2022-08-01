<?php

namespace Petshop\CurrencyExchangeRate\Rule;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class CurrencyRule implements Rule
{
    protected $currency = [];

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->currency = config('currencyexchange.codes');
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $value = Str::upper($value);

        return in_array($value, $this->currency, true);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute value must be one of '. implode(', ', $this->currency) . '.';
    }
}
