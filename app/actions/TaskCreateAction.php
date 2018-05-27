<?php

namespace app\actions;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use src\View;
use Zend\Diactoros\Response\HtmlResponse;

final class TaskCreateAction
{
    /**
     * @var View
     */
    private $view;

    public function __construct(View $view)
    {
        $this->view = $view;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse($this->view->render('create'));
    }
}
