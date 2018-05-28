<?php

namespace app\core;

use app\models\User;
use app\repositories\UserRepository;
use Psr\Http\Message\ServerRequestInterface;

final class Authorization
{
    const COOKIENAME = 'TestAuth';

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ApplicationUser
     */
    private $applicationUser;

    public function __construct(UserRepository $userRepository, ApplicationUser $applicationUser)
    {
        $this->userRepository = $userRepository;
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

        return $this->userRepository->findByLoginAndPass($login, $pass);
    }

    public function isAuthorized(): bool
    {
        return !$this->applicationUser->isGuest();
    }
}
