<?php

namespace app\repositories;

use app\core\Hydrator;
use app\models\Task;
use RedBeanPHP\OODBBean;
use RedBeanPHP\R;

final class TaskRepository
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
     * @param int $id
     * @return Task|null
     */
    public function findById(int $id)
    {
        $task = R::load('task', $id);

        return $task ? $this->hydrator->hydrate($task->export(), Task::class) : null;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return Task[]
     */
    public function findAll(int $limit = null, int $offset = null): array
    {
        $sql = '';
        $params = [];

        if ($limit) {
            $sql .= ' LIMIT :limit';
            $params[':limit'] = $limit;
        }

        if ($offset) {
            $sql .= ' OFFSET :offset';
            $params[':offset'] = $offset;
        }

        $tasks = R::findAll('task', $sql, $params);

        return array_map(function (OODBBean $datum) {
            return $this->hydrator->hydrate($datum->export(), Task::class);
        }, $tasks);
    }

    /**
     * @param Task $task
     * @return int
     */
    public function create(Task $task): int
    {
        $newTask = R::dispense('task');
        $newTask->import((array)$task);

        return (int)R::store($newTask);
    }
}
