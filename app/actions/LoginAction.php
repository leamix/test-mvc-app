<?php

namespace app\actions;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use src\Authorization;
use Zend\Diactoros\Response\EmptyResponse;

final class LoginAction
{
    /**
     * @var Authorization
     */
    private $autorization;

    public function __construct(Authorization $autorization)
    {
        $this->autorization = $autorization;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->autorization->authorizeByRequest($request)) {
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
