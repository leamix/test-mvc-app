<?php

namespace app\actions;

use app\core\exceptions\PageNotFoundException;
use app\core\Pagination;
use app\core\Settings;
use app\core\TaskSort;
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
     * @var Settings
     */
    private $settings;

    public function __construct(
        View $view,
        TaskRepository $taskRepository,
        Settings $settings
    ) {
        $this->view = $view;
        $this->taskRepository = $taskRepository;
        $this->settings = $settings;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $pagination = new Pagination(
            $this->settings->pageSize,
            $this->taskRepository->countAll(),
            $request->getAttribute('page', 1)
        );

        $queryParams = $request->getQueryParams();
        $sort = new TaskSort(
            $queryParams[TaskSort::QUERY_ORDER] ?? TaskSort::SORT_BY_DATE,
            $queryParams[TaskSort::QUERY_DIR] ?? TaskSort::SORT_DESC
        );

        $tasks = $this->taskRepository->findAll(
            $sort,
            $pagination->getPageSize(),
            $pagination->getOffset()
        );

        if (!$tasks) {
            throw new PageNotFoundException();
        }

        return new HtmlResponse($this->view->render('list', [
            'pagination' => $pagination,
            'tasks' => $tasks,
            'sort' => $sort,
        ]));
    }
}
