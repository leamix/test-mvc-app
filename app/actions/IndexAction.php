<?php

namespace app\actions;

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
     * @var Pagination
     */
    private $pagination;

    public function __construct(View $view, TaskRepository $taskRepository, Pagination $pagination)
    {
        $this->view = $view;
        $this->taskRepository = $taskRepository;
        $this->pagination = $pagination;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $this->pagination->setItemsTotal($this->taskRepository->countAll());

        $tasks = $this->taskRepository->findAll(
            $this->pagination->getPageSize(),
            $this->pagination->getOffset()
        );

        if (!$tasks) {
            throw new PageNotFoundException();
        }

        return new HtmlResponse($this->view->render('list', [
            'pagination' => $this->pagination,
            'tasks' => $tasks,
        ]));
    }
}
