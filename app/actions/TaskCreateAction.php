<?php

namespace app\actions;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

final class TaskCreateAction
{
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse('Task create page' . PHP_EOL);
    }
}
