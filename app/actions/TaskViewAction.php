<?php

namespace app\actions;

use app\core\View;
use app\services\TaskService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

final class TaskViewAction
{
    /**
     * @var View
     */
    private $view;
    /**
     * @var TaskService
     */
    private $taskService;

    public function __construct(View $view, TaskService $taskService)
    {
        $this->view = $view;
        $this->taskService = $taskService;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $taskId = $request->getAttribute('id');

        return new HtmlResponse($this->view->render('view', [
            'task' => $this->taskService->find($taskId),
        ]));
    }
}
