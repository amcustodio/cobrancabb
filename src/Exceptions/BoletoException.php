<?php

namespace Ultrawave\CobrancaBB\Exceptions;

use Throwable;

class BoletoException extends \Exception
{
    /**
     * OAuthException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if(empty($message))
            $message = 'Desculpe, não foi possivel registrar boleto.';

        parent::__construct($message, $code, $previous);
    }
}
