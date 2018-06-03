<?php

namespace app\actions;


use app\core\Settings;
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
     * @var Settings
     */
    private $settings;

    public function __construct(View $view, Settings $settings)
    {
        $this->view = $view;
        $this->settings = $settings;
    }

    public function __invoke(
        \Throwable $e,
        string $message = 'Site error',
        int $status = 500
    ): ResponseInterface {
        $response = new HtmlResponse($this->view->render('error', [
            'message' => $message,
            'info' => $this->settings->isDebug ? print_r($e, true) : null,
        ]));

        return $response->withStatus($status);
    }
}
