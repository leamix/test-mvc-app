<?php

namespace app\actions;

use app\core\View;
use app\services\TaskService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;

final class TaskUpdateAction
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
        $task = $this->taskService->find($taskId);

        if ($request->getMethod() === 'POST') {
            $attributes = $request->getParsedBody();

            $this->taskService->update($task, $attributes);

            return new RedirectResponse('/tasks/view/' . $task->id);
        }

        return new HtmlResponse($this->view->render('update', [
            'task' => $task,
        ]));
    }
}
