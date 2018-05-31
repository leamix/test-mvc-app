<?php

namespace app\actions;


use app\core\Application;
use app\core\View;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;

final class ErrorAction
{
    /**
     * @var View
     */
    private $view;
    /**
     * @var Application
     */
    private $application;

    public function __construct(View $view, Application $application)
    {
        $this->view = $view;
        $this->application = $application;
    }

    public function __invoke(
        \Throwable $e,
        string $message = 'Site error',
        int $status = 500
    ): ResponseInterface {
        $response = new HtmlResponse($this->view->render('error', [
            'message' => $message,
            'info' => $this->application->isDebug() ? print_r($e, true) : null,
        ]));

        return $response->withStatus($status);
    }
}
