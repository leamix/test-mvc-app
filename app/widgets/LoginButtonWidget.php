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
     * @return string
     */
    public function run(): string
    {
        if ($this->user->isGuest()) {
            return require APP_DIR . '/app/views/parts/login_btn.php';
        }

        return '';
    }
}
