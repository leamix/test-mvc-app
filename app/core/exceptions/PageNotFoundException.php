<?php

namespace app\core\exceptions;

final class PageNotFoundException extends \Exception
{
    public function __construct(
        string $message = 'Page not found',
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
