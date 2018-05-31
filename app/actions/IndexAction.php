<?php

namespace app\actions;

use app\core\View;
use app\repositories\TaskRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

final class IndexAction
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
        $page = $request->getAttribute('page', 1) - 1;
        $pageSize = 3;

        $tasks = $this->taskRepository->findAll($pageSize, $pageSize * $page);

        return new HtmlResponse($this->view->render('list', [
            'page' => $page,
            'tasks' => $tasks,
        ]));
    }
}
