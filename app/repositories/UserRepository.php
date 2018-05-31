<?php

namespace app\repositories;

use app\models\User;
use RedBeanPHP\R;
use samdark\hydrator\Hydrator;

final class UserRepository
{
    /**
     * @var Hydrator
     */
    private $hydrator;

    public function __construct(Hydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * @param string $login
     * @param string $pass
     * @return User|null
     */
    public function findByLoginAndPass(string $login, string $pass)
    {
        $user = R::findOne('user', 'username = :login AND pass_hash = :hash', [
            'login' => $login,
            'hash' => md5($pass),
        ]);

        return $user ? $this->hydrator->hydrate($user->export(), User::class) : null;
    }
}
