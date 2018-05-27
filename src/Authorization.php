<?php

namespace src;

use app\models\User;
use PDO;
use Psr\Http\Message\ServerRequestInterface;

final class Authorization
{
    const COOKIENAME = 'TestAuth';

    /**
     * @var PDO
     */
    private $db;
    /**
     * @var ApplicationUser
     */
    private $applicationUser;

    public function __construct(PDO $db, ApplicationUser $applicationUser)
    {
        $this->db = $db;
        $this->applicationUser = $applicationUser;
    }

    public function authorizeByRequest(ServerRequestInterface $request): bool
    {
        if ($this->isAuthorized($request)) {
            return true;
        }

        $username = $request->getServerParams()['PHP_AUTH_USER'] ?? '';
        $password = $request->getServerParams()['PHP_AUTH_PW'] ?? '';

        if ($user = $this->findUser($username, $password)) {
            $this->applicationUser->setInstance($user);

            setcookie(self::COOKIENAME, $username, 0);

            return true;
        }

        return false;
    }

    public function isAuthorized(ServerRequestInterface $request): bool
    {
        $cookieParams = $request->getCookieParams();

        return array_key_exists(self::COOKIENAME, $cookieParams);
    }

    /**
     * @param string $login
     * @param string $pass
     * @return User|false
     */
    private function findUser(string $login, string $pass)
    {
        if (empty($login) || empty($pass)) {
            return false;
        }

        $query = $this->db->prepare('SELECT * FROM users WHERE username = :login AND password = :pass');
        $query->execute([
            'login' => $login,
            'pass' => $pass,
        ]);

        return $query->fetchObject(User::class);
    }
}
