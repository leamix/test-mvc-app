<?php

namespace app\actions;

use app\core\Authorization;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\RedirectResponse;

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

    public function __invoke(): ResponseInterface
    {
        if ($this->autorization->isAuthorized()) {
            return new RedirectResponse('/');
        }

        return (new EmptyResponse())
            ->withStatus(401)
            ->withHeader('WWW-Authenticate', 'Basic realm=Restricted area');
    }
}
