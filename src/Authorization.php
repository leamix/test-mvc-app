<?php

namespace src;

use app\models\User;
use Psr\Http\Message\ServerRequestInterface;

final class Authorization
{
    const COOKIENAME = 'TestAuth';

    /**
     * @var DbManager
     */
    private $db;
    /**
     * @var ApplicationUser
     */
    private $applicationUser;

    public function __construct(DbManager $db, ApplicationUser $applicationUser)
    {
        $this->db = $db;
        $this->applicationUser = $applicationUser;
    }

    public function authorize(ServerRequestInterface $request): bool
    {
        $username = $request->getServerParams()['PHP_AUTH_USER'] ?? '';
        $password = $request->getServerParams()['PHP_AUTH_PW'] ?? '';

        if ($user = $this->findUserByLoginAndPass($username, $password)) {
            $this->applicationUser->setInstance($user);

            return true;
        }

        return false;
    }

    public function isAuthorized(): bool
    {
        return !$this->applicationUser->isGuest();
    }

    /**
     * @param string $login
     * @param string $pass
     * @return User|false
     */
    private function findUserByLoginAndPass(string $login, string $pass)
    {
        if (empty($login) || empty($pass)) {
            return false;
        }

        $query = $this->db->prepare('SELECT * FROM user WHERE username = :login AND password = :pass');
        $query->execute([
            'login' => $login,
            'pass' => $pass,
        ]);

        return $query->fetchObject(User::class);
    }
}
