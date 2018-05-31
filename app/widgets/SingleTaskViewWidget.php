<?php

namespace app\widgets;

use app\core\ApplicationUser;
use app\core\WidgetInterface;

final class SingleTaskViewWidget implements WidgetInterface
{
    /**
     * @var ApplicationUser
     */
    private $user;

    public function __construct(ApplicationUser $user)
    {
        $this->user = $user;
    }

    /**
     * @inheritdoc
     */
    public function run(array $params = []): string
    {
        \extract($params, EXTR_OVERWRITE);

        $showEditBtn = $this->user->isAdmin();

        return require APP_DIR . '/app/views/parts/task.php';
    }
}
