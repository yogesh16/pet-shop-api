
# Currency Exchange Rate

This package provides easy to use API to convert currency rate from Euro for Laravel Application.

This package uses [European Central Bank Reference rates](https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml) for rate conversion


## 🚀 Installation

This project can be installed via [Composer](https://getcomposer.org/). 
To install latest version, follow the steps
 - Create folder in your project root directory ```packages/petshop/currency-exchange-rate```
 - Download this package into this folder
 - Add the following line to the require block of your composer.json file.
```bash
{
    "repositories": {
        "currency-exchange-rate": {
            "type": "path",
            "url" : "packages/petshop/currency-exchange-rate",
            "options": {
                "symlink": true
            }
        }
    },
    "require": {
        "petshop/currency-exchange-rate": "@dev"
    }
}
```
  - Now run following command.
  
```bash
  composer update
```

    
## ✅ Setup for Laravel
⚡ **_NOTE_**   This package supports the auto-discovery feature of Laravel 5.5 and above, So skip these Setup instructions if you're using Laravel 5.5 and above.

In `app/config/app.php` add the following :

1- The ServiceProvider to the providers array :

```php
Petshop\CurrencyExchangeRate\Providers\CurrencyExchangeRateServiceProvider::class,
```

2- Publish the config file

```ssh
php artisan vendor:publish --provider="Petshop\CurrencyExchangeRate\Providers\CurrencyExchangeRateServiceProvider"
```
## 📚 Swagger

You can test API using Swagger.

Once package is configured with your laravel project

Goto following URL in your browser

```bash
  {project_url}/currency-exchange-rate/api/documentation
```

## 🚨 Running Tests

To run tests, run the following command

```bash
  composer test
```

## API Reference

#### Convert currency rate

```http
  GET /api/v1/currency-exchange
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `amount` | `float` | **Required**. Amount in Euro |
| `currency` | `string` | **Required**. Currency code to convert |

Supported currency codes

```
USD, JPY, BGN, CZK, DKK, GBP, HUF, PLN, RON, SEK, CHF, ISK, NOK, HRK, TRY, 
AUD, BRL, CAD, CNY, HKD, IDR, ILS, INR, KRW, MXN, NZD, PHP, SGD, THB, ZAR
```


## Usage/Examples

You can use it directly as well.

```php
use Petshop\CurrencyExchangeRate\Currency;

//Convert Euro to USD
public function EuroToUsd()
{
    $amoundInUsd = Currency::convert('USD', 100);

    return $amoundInUsd;
}
```

## 📝 TODO

- Add option to return currency symbol with converted amount
    
  for example 
```php
   Currency::convert('USD', 100, true); // return $ 102.11
```  
