<?php

namespace app\actions;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use src\Authorization;
use Zend\Diactoros\Response\EmptyResponse;

final class LoginAction
{
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $autorization = new Authorization();

        if ($autorization->authorizeByRequest($request)) {
            return $this->authorized();
        }

        return $this->unAuthorized();
    }

    private function authorized(): EmptyResponse
    {
        return (new EmptyResponse())
            ->withStatus(302)
            ->withHeader('Location', '/');
    }

    private function unAuthorized(): EmptyResponse
    {
        return (new EmptyResponse())
            ->withStatus(401)
            ->withHeader('WWW-Authenticate', 'Basic realm=Restricted area');
    }
}
