<?php

namespace app\widgets;

use app\actions\TaskCreateAction;
use app\core\Application;
use app\core\WidgetInterface;

final class CreateButtonWidget implements WidgetInterface
{
    /**
     * @var Application
     */
    private $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * @inheritdoc
     */
    public function run(array $params = []): string
    {
        if (!$this->application->getAction() instanceof TaskCreateAction) {
            return require APP_DIR . '/app/views/parts/createBtn.php';
        }

        return '';
    }
}
