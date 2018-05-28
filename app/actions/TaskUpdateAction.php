<?php

namespace app\actions;

use app\core\View;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

final class TaskUpdateAction
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
        $taskId = $request->getAttribute('id');

        return new HtmlResponse($this->view->render('update', [
            'taskId' => $taskId,
        ]));
    }
}
