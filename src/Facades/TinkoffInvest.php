<?php

namespace Nlplay\TinkoffInvest\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class TinkoffInvest
 * @package Nlplay\TinkoffInvest\Facades
 *
 * @method static array orders(string $brokerAccountId = null)
 * @method static array ordersLimitOrder(string $figi, string $brokerAccountId = null)
 * @method static array ordersMarketOrder(string $figi, string $brokerAccountId = null)
 * @method static array ordersCancel(string $orderId, string $brokerAccountId = null)
 * @method static array portfolio(string $brokerAccountId = null)
 * @method static array portfolioCurrencies(string $brokerAccountId = null)
 * @method static array marketStocks()
 * @method static array marketBonds()
 * @method static array marketEtfs()
 * @method static array marketCurrencies()
 * @method static array marketOrderBook(string $figi, int $depth)
 * @method static array marketCandles(string $figi, string $from, string $to, string $interval)
 * @method static array marketSearchByFigi(string $figi)
 * @method static array marketSearchByTicker(string $ticker)
 * @method static array operations(string $from, string $to, string $brokerAccountId = null, string $figi = null)
 * @method static array userAccounts()
 * @method static array sbRegister()
 * @method static array sbCurrenciesBalance(string $brokerAccountId = null)
 * @method static array sbPositionsBalance(string $brokerAccountId = null)
 * @method static array sbRemove()
 * @method static array sbClear()
 */
class TinkoffInvest extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tinkoff-invest';
    }
}
