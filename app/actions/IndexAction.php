<?php

namespace app\actions;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use src\View;
use Zend\Diactoros\Response\HtmlResponse;

final class IndexAction
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
        $page = $request->getAttribute('page', 1);

        return new HtmlResponse($this->view->render('list', [
            'page' => $page,
        ]));
    }
}
