<?php

namespace app\actions;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

final class LoginAction
{
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse('Login page' . PHP_EOL);
    }
}
