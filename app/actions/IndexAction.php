<?php

namespace app\actions;

use app\core\Application;
use app\core\exceptions\PageNotFoundException;
use app\core\Pagination;
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
    /**
     * @var Application
     */
    private $application;

    public function __construct(
        View $view,
        TaskRepository $taskRepository,
        Application $application
    ) {
        $this->view = $view;
        $this->taskRepository = $taskRepository;
        $this->application = $application;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $pagination = new Pagination(
            $this->application->getContainer()->get('config')['pageSize'],
            $this->taskRepository->countAll(),
            $request->getAttribute('page', 1)
        );

        $tasks = $this->taskRepository->findAll(
            $pagination->getPageSize(),
            $pagination->getOffset()
        );

        if (!$tasks) {
            throw new PageNotFoundException();
        }

        return new HtmlResponse($this->view->render('list', [
            'pagination' => $pagination,
            'tasks' => $tasks,
        ]));
    }
}
