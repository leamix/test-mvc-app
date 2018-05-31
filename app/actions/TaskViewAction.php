<?php

namespace app\actions;

use app\core\View;
use app\repositories\TaskRepository;
use Aura\Router\Exception\RouteNotFound;
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
     * @var TaskRepository
     */
    private $taskRepository;

    public function __construct(View $view, TaskRepository $taskRepository)
    {
        $this->view = $view;
        $this->taskRepository = $taskRepository;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $taskId = $request->getAttribute('id');
        $task = $this->taskRepository->findById($taskId);

        if (!$task) {
            throw new RouteNotFound();
        }

        return new HtmlResponse($this->view->render('view', [
            'task' => $task,
        ]));
    }
}
