<?php

namespace app\core\exceptions;


use Throwable;

final class UnauthorizedException extends \Exception
{
    public function __construct(
        string $message = 'Not authorized',
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

}
