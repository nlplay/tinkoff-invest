<?php

namespace Nlplay\TinkoffInvest;

use Carbon\Carbon;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Nlplay\TinkoffInvest\Exceptions\TinkoffInvestBadRequestException;
use Nlplay\TinkoffInvest\Exceptions\TinkoffInvestTooManyRequestsException;
use Nlplay\TinkoffInvest\Exceptions\TinkoffInvestWrongTokenException;

class TinkoffInvest
{
    /**
     * Tinkoff base url
     *
     * @var string
     */
    protected $baseUrl = 'https://api-invest.tinkoff.ru/openapi/';

    /**
     * Get list of all active orders
     * Default Tinkoff broker account ID
     *
     * @param string|null $brokerAccountId
     * @return array|PendingRequest|mixed
     * @throws TinkoffInvestTooManyRequestsException|TinkoffInvestWrongTokenException|TinkoffInvestBadRequestException
     */
    public function orders(string $brokerAccountId = null)
    {
        $data = [];

        if ($brokerAccountId) {
            $data['brokerAccountId'] = $brokerAccountId;
        }

        return $this->getRequest('orders', $data);
    }

    /**
     * Create a limited order
     * Default Tinkoff broker account ID
     *
     * @param string $figi
     * @param string|null $brokerAccountId
     * @return array|PendingRequest|mixed
     * @throws TinkoffInvestTooManyRequestsException|TinkoffInvestWrongTokenException|TinkoffInvestBadRequestException
     */
    public function ordersLimitOrder(string $figi, string $brokerAccountId = null)
    {
        $data = ['figi' => $figi];

        if ($brokerAccountId) {
            $data['brokerAccountId'] = $brokerAccountId;
        }

        return $this->postRequest('orders/limit-order', $data);
    }

    /**
     * Create a market order
     * Default Tinkoff broker account ID
     *
     * @param string $figi
     * @param string|null $brokerAccountId
     * @return array|PendingRequest|mixed
     * @throws TinkoffInvestTooManyRequestsException|TinkoffInvestWrongTokenException|TinkoffInvestBadRequestException
     */
    public function ordersMarketOrder(string $figi, string $brokerAccountId = null)
    {
        $data = ['figi' => $figi];

        if ($brokerAccountId) {
            $data['brokerAccountId'] = $brokerAccountId;
        }

        return $this->postRequest('orders/market-order', $data);
    }

    /**
     * Cancel an order by its ID
     * Default Tinkoff broker account ID
     *
     * @param string $orderId
     * @param string|null $brokerAccountId
     * @return array|PendingRequest|mixed
     * @throws TinkoffInvestTooManyRequestsException|TinkoffInvestWrongTokenException|TinkoffInvestBadRequestException
     */
    public function ordersCancel(string $orderId, string $brokerAccountId = null)
    {
        $data = ['orderId' => $orderId];

        if ($brokerAccountId) {
            $data['brokerAccountId'] = $brokerAccountId;
        }

        return $this->postRequest('orders/market-order', $data);
    }

    /**
     * Get a client's portfolio
     * Default Tinkoff broker account ID
     *
     * @param string|null $brokerAccountId
     * @return array|PendingRequest|mixed
     * @throws TinkoffInvestTooManyRequestsException|TinkoffInvestWrongTokenException|TinkoffInvestBadRequestException
     */
    public function portfolio(string $brokerAccountId = null)
    {
        $data = [];

        if ($brokerAccountId) {
            $data['brokerAccountId'] = $brokerAccountId;
        }

        return $this->getRequest('portfolio', $data);
    }

    /**
     * Get a client's currency accounts
     * Default Tinkoff broker account ID
     *
     * @param string|null $brokerAccountId
     * @return array|PendingRequest|mixed
     * @throws TinkoffInvestTooManyRequestsException|TinkoffInvestWrongTokenException|TinkoffInvestBadRequestException
     */
    public function portfolioCurrencies(string $brokerAccountId = null)
    {
        $data = [];

        if ($brokerAccountId) {
            $data['brokerAccountId'] = $brokerAccountId;
        }

        return $this->getRequest('portfolio/currencies', $data);
    }

    /**
     * Get stocks list
     *
     * @return array|mixed
     * @throws TinkoffInvestTooManyRequestsException|TinkoffInvestWrongTokenException|TinkoffInvestBadRequestException
     */
    public function marketStocks()
    {
        return $this->getRequest('market/stocks');
    }

    /**
     * Get bonds list
     *
     * @return array|mixed
     * @throws TinkoffInvestTooManyRequestsException|TinkoffInvestWrongTokenException|TinkoffInvestBadRequestException
     */
    public function marketBonds()
    {
        return $this->getRequest('market/bonds');
    }

    /**
     * Get etfs list
     *
     * @return array|mixed
     * @throws TinkoffInvestTooManyRequestsException|TinkoffInvestWrongTokenException|TinkoffInvestBadRequestException
     */
    public function marketEtfs()
    {
        return $this->getRequest('market/etfs');
    }

    /**
     * Get currency pairs list
     *
     * @return array|PendingRequest|mixed
     * @throws TinkoffInvestTooManyRequestsException|TinkoffInvestWrongTokenException|TinkoffInvestBadRequestException
     */
    public function marketCurrencies()
    {
        return $this->getRequest('market/currencies');
    }

    /**
     * Get order book
     *
     * @param string $figi
     * @param int $depth
     * @return array|mixed
     * @throws TinkoffInvestTooManyRequestsException|TinkoffInvestWrongTokenException|TinkoffInvestBadRequestException
     */
    public function marketOrderBook(string $figi, int $depth)
    {
        return $this->getRequest('market/orderbook', [
            'figi' => $figi,
            'depth' => $depth,
        ]);
    }

    /**
     * Get candles histories by figi
     *
     * @param string $figi
     * @param string $from
     * @param string $to
     * @param string $interval
     * @return array|mixed
     * @throws TinkoffInvestTooManyRequestsException|TinkoffInvestWrongTokenException|TinkoffInvestBadRequestException
     */
    public function marketCandles(string $figi, string $from, string $to, string $interval)
    {
        return $this->getRequest('market/candles', [
            'figi' => $figi,
            'from' => $this->normalizeTime($from),
            'to' => $this->normalizeTime($to),
            'interval' => $interval
        ]);
    }

    /**
     * Get a tool by a figi
     *
     * @param string $figi
     * @return array|mixed
     * @throws TinkoffInvestTooManyRequestsException|TinkoffInvestWrongTokenException|TinkoffInvestBadRequestException
     */
    public function marketSearchByFigi(string $figi)
    {
        return $this->getRequest('market/search/by-figi', ['figi' => $figi]);
    }

    /**
     * Get get a tool by a ticker
     *
     * @param string $ticker
     * @return array|mixed
     * @throws TinkoffInvestTooManyRequestsException|TinkoffInvestWrongTokenException|TinkoffInvestBadRequestException
     */
    public function marketSearchByTicker(string $ticker)
    {
        return $this->getRequest('market/search/by-ticker', ['ticker' => $ticker]);
    }

    /**
     * Get operatins list
     *
     * @param string $from
     * @param string $to
     * @param string|null $brokerAccountId
     * @param string|null $figi
     * @return array|PendingRequest|mixed
     * @throws TinkoffInvestTooManyRequestsException|TinkoffInvestWrongTokenException|TinkoffInvestBadRequestException
     */
    public function operations(string $from, string $to, string $brokerAccountId = null, string $figi = null)
    {
        $data = [
            'from' => $this->normalizeTime($from),
            'to' => $this->normalizeTime($to),
        ];

        if ($brokerAccountId) {
            $data['brokerAccountId'] = $brokerAccountId;
        }

        if ($figi) {
            $data['figi'] = $figi;
        }

        return $this->getRequest('operations', $data);
    }

    /**
     * Get a client's user accounts
     *
     * @return array|PendingRequest|mixed
     * @throws TinkoffInvestTooManyRequestsException|TinkoffInvestWrongTokenException|TinkoffInvestBadRequestException
     */
    public function userAccounts()
    {
        return $this->getRequest('user/accounts');
    }

    /**
     * Register a client in the sandbox
     *
     * @return array|PendingRequest|mixed
     * @throws TinkoffInvestTooManyRequestsException|TinkoffInvestWrongTokenException|TinkoffInvestBadRequestException
     */
    public function sbRegister()
    {
        return $this->postRequest('sandbox/register');
    }

    /**
     * Set balance to currency positions
     * Default Tinkoff broker account ID
     *
     * @param string|null $brokerAccountId
     * @return array|PendingRequest|mixed
     * @throws TinkoffInvestTooManyRequestsException|TinkoffInvestWrongTokenException|TinkoffInvestBadRequestException
     */
    public function sbCurrenciesBalance(string $brokerAccountId = null)
    {
        $data = [];

        if ($brokerAccountId) {
            $data['brokerAccountId'] = $brokerAccountId;
        }

        return $this->postRequest('sandbox/register', $data);
    }

    /**
     * Set balance to tool positions
     * Default Tinkoff broker account ID
     *
     * @param string|null $brokerAccountId
     * @return array|PendingRequest|mixed
     * @throws TinkoffInvestTooManyRequestsException|TinkoffInvestWrongTokenException|TinkoffInvestBadRequestException
     */
    public function sbPositionsBalance(string $brokerAccountId = null)
    {
        $data = [];

        if ($brokerAccountId) {
            $data['brokerAccountId'] = $brokerAccountId;
        }

        return $this->postRequest('sandbox/register', $data);
    }

    /**
     * Remove a client's account
     *
     * @return array|PendingRequest|mixed
     * @throws TinkoffInvestTooManyRequestsException|TinkoffInvestWrongTokenException|TinkoffInvestBadRequestException
     */
    public function sbRemove()
    {
        return $this->postRequest('sandbox/remove');
    }

    /**
     * Remove all positions
     *
     * @return array|PendingRequest|mixed
     * @throws TinkoffInvestTooManyRequestsException|TinkoffInvestWrongTokenException|TinkoffInvestBadRequestException
     */
    public function sbClear()
    {
        return $this->postRequest('sandbox/clear');
    }

    /**
     * Get a pending request
     *
     * @param string $uri
     * @param array $query
     * @param string $method
     * @return PendingRequest
     * @throws TinkoffInvestTooManyRequestsException|TinkoffInvestWrongTokenException|TinkoffInvestBadRequestException
     */
    protected function buildRequest(string $uri, array $query = [], string $method = 'get')
    {
        $query = Http::withToken(config('tinkoff.token'))
            ->$method($this->baseUrl . ltrim($uri, '/'), $query);

        if ($query->status() === 400) {
            $response = $query->json();
            throw new TinkoffInvestBadRequestException($response['payload']['message'] ?? '');
        }

        if ($query->status() === 401) {
            throw new TinkoffInvestWrongTokenException('');
        }

        if ($query->status() === 429) {
            throw new TinkoffInvestTooManyRequestsException();
        }

        return $query->json();
    }

    /**
     * Basic get request
     *
     * @param string $uri
     * @param array $query
     * @return array|mixed
     * @throws TinkoffInvestTooManyRequestsException|TinkoffInvestWrongTokenException|TinkoffInvestBadRequestException
     */
    protected function getRequest(string $uri, array $query = [])
    {
        return $this->buildRequest($uri, $query);
    }

    /**
     * Basic post request
     *
     * @param string $uri
     * @param array $data
     * @return array|mixed
     * @throws TinkoffInvestTooManyRequestsException|TinkoffInvestWrongTokenException|TinkoffInvestBadRequestException
     */
    protected function postRequest(string $uri, array $data = [])
    {
        return $this->buildRequest($uri, $data, 'post');
    }

    /**
     * Normalize time to the API standard
     *
     * @param $time
     * @return string
     */
    protected function normalizeTime($time)
    {
        $carbon = $time instanceof Carbon ? $time : Carbon::parse($time);

        return $carbon->toDateTimeLocalString() . $carbon->getTimezone()->toOffsetName();
    }
}
