<?php

namespace app\actions;

use app\core\View;
use app\models\Task;
use app\repositories\TaskRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;

final class TaskCreateAction
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
        $task = new Task();

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();

            $task->username = $data['username'];
            $task->email = $data['email'];
            $task->text = $data['text'];
            $task->created_at = time();

            $id = $this->taskRepository->create($task);

            return new RedirectResponse('/tasks/view/' . $id);
        }

        return new HtmlResponse($this->view->render('create', [
            'model' => $task,
        ]));
    }
}
