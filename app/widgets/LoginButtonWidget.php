<?php

namespace app\widgets;

use app\core\ApplicationUser;
use app\core\WidgetInterface;

final class LoginButtonWidget implements WidgetInterface
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
        if ($this->user->isGuest()) {
            return require APP_DIR . '/app/views/parts/loginBtn.php';
        }

        return '';
    }
}
