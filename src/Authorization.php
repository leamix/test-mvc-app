<?php

namespace src;

use PDO;
use Psr\Http\Message\ServerRequestInterface;

final class Authorization
{
    const COOKIENAME = 'TestAuth';

    /**
     * @var PDO
     */
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function authorizeByRequest(ServerRequestInterface $request): bool
    {
        if ($this->isAuthorized($request)) {
            return true;
        }

        $username = $request->getServerParams()['PHP_AUTH_USER'] ?? '';
        $password = $request->getServerParams()['PHP_AUTH_PW'] ?? '';

        if ($this->findUser($username, $password)) {
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
     * @return array|false
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

        return $query->fetch();
    }
}
