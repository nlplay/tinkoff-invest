<?php


namespace Nlplay\TinkoffInvest\Exceptions;

use Exception;

/**
 * Class TinkoffInvestWrongTokenException
 * @package Nlplay\TinkoffInvest\Exceptions
 */
class TinkoffInvestWrongTokenException extends Exception
{
    protected $message = 'Tinkoff Invest API: wrong token';
    protected $code = 401;
}
