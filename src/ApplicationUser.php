<?php

namespace src;

use app\models\User;

final class ApplicationUser
{
    /**
     * @var User
     */
    private $instance;

    public function getInstance(): User
    {
        return $this->instance;
    }

    /**
     * @param User $instance
     */
    public function setInstance(User $instance)
    {
        \assert($instance->username !== null);

        $this->instance = $instance;
    }
}
