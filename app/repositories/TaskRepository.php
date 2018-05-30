<?php

namespace app\repositories;

use app\core\DbManager;
use app\models\Task;
use samdark\hydrator\Hydrator;

final class TaskRepository
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
     * @return Task|null
     */
    public function findById(int $id)
    {
        $sql = 'SELECT * FROM task WHERE id = :id';

        $data = $this->db->fetchOne($sql, [
            'id' => $id,
        ]);

        if (!$data) {
            return null;
        }

        return $this->hydrator->hydrate($data, Task::class);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return Task[]
     */
    public function findAll(int $limit = null, int $offset = null): array
    {
        $sql = 'SELECT * FROM task';
        $params = [];

        if ($limit) {
            $sql .= ' LIMIT :limit';
            $params['limit'] = $limit;
        }

        if ($offset) {
            $sql .= ' OFFSET :offset';
            $params['offset'] = $offset;
        }

        $data = $this->db->fetchAll($sql, $params);

        if (!$data) {
            return [];
        }

        return array_map(function ($datum) {
            return $this->hydrator->hydrate($datum, Task::class);
        }, $data);
    }

    public function create(Task $task): int
    {
        $sql = '';
        $params = $this->hydrator->extract($task);
        $this->db->prepareWithParams($sql, $params);

        return (int)$this->db->lastInsertId();
    }
}
