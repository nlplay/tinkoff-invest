<?php


namespace Nlplay\TinkoffInvest\Exceptions;

use Exception;

/**
 * Class TinkoffInvestWrongTokenException
 * @package Nlplay\TinkoffInvest\Exceptions
 */
class TinkoffInvestBadRequestException extends Exception
{
    protected $code = 400;
}
