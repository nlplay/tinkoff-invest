# Tinkoff Invest API Facade for laravel applications

### Description
Official API documentation can be found here:
https://tinkoffcreditsystems.github.io/invest-openapi/
https://tinkoffcreditsystems.github.io/invest-openapi/swagger-ui/

The package was build upon Illuminate\Support\Facades\Http.

## Installation

##### 1. Download the extension via composer:
```
composer require nlplay/tinkoff-invest
```
##### 2. Publish the config file:
```
php artisan vendor:publish --tag=tinkoff-invest
```

##### 3. Add you tinkoff key as described here https://tinkoffcreditsystems.github.io/invest-openapi/auth/ to .env:
```
TINKOFF_INVEST_TOKEN=
```
## Usage

In order to make requests just use the Facade:
```php
use Nlplay\TinkoffInvest\Facades\TinkoffInvest;
```

List of available methods (sb - sandbox):
```
orders(string $brokerAccountId = null)
ordersLimitOrder(string $figi, string $brokerAccountId = null)
ordersMarketOrder(string $figi, string $brokerAccountId = null)
ordersCancel(string $orderId, string $brokerAccountId = null)
portfolio(string $brokerAccountId = null)
portfolioCurrencies(string $brokerAccountId = null)
marketStocks()
marketBonds()
marketEtfs()
marketCurrencies()
marketOrderBook(string $figi, int $depth)
marketCandles(string $figi, string $from, string $to, string $interval)
marketSearchByFigi(string $figi)
marketSearchByTicker(string $ticker)
operations(string $from, string $to, string $brokerAccountId = null, string $figi = null)
userAccounts()
sbRegister()
sbCurrenciesBalance(string $brokerAccountId = null)
sbPositionsBalance(string $brokerAccountId = null)
sbRemove()
sbClear()
```

### Example
```php
use Nlplay\TinkoffInvest\Facades\TinkoffInvest;

$currencies = TinkoffInvest::marketCurrencies();
```
