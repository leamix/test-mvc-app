<?php

namespace app\core;

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

    /**
     * @return bool
     */
    public function isGuest(): bool
    {
        return null === $this->instance;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->instance ? (bool)$this->instance->is_admin : false;
    }
}
