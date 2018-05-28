<?php

namespace app\repositories;

use app\core\DbManager;
use app\models\User;
use samdark\hydrator\Hydrator;

final class UserRepository
{
    /**
     * @var DbManager
     */
    private $db;
    /**
     * @var Hydrator
     */
    private $hydrator;

    public function __construct(DbManager $db, Hydrator $hydrator)
    {
        $this->db = $db;
        $this->hydrator = $hydrator;
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function findById(int $id)
    {
        $sql = 'SELECT * FROM user WHERE id = :id';

        $data = $this->db->queryWithParams($sql, [
            'id' => $id,
        ]);

        if (!$data) {
            return null;
        }

        return $this->hydrator->hydrate($data, User::class);
    }

    /**
     * @param string $login
     * @param string $pass
     * @return User|null
     */
    public function findByLoginAndPass(string $login, string $pass)
    {
        $sql = 'SELECT * FROM user WHERE username = :login AND password = :pass';

        $data = $this->db->queryWithParams($sql, [
            'login' => $login,
            'pass' => $pass,
        ]);

        if (!$data) {
            return null;
        }

        return $this->hydrator->hydrate($data, User::class);
    }
}
