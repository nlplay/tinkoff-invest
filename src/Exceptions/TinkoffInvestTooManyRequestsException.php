<?php


namespace Nlplay\TinkoffInvest\Exceptions;

use Exception;

/**
 * Class TinkoffInvestTooManyRequestsException
 * @package Nlplay\TinkoffInvest\Exceptions
 */
class TinkoffInvestTooManyRequestsException extends Exception
{
    protected $message = 'Tinkoff Invest API: too many requests';
    protected $code = 429;
}
