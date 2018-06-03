<?php

namespace app\services;


use app\core\exceptions\PageNotFoundException;
use app\core\Hydrator;
use app\models\Task;
use app\repositories\TaskRepository;

final class TaskService
{
    /**
     * @var TaskRepository
     */
    private $taskRepository;
    /**
     * @var Hydrator
     */
    private $hydrator;

    public function __construct(TaskRepository $taskRepository, Hydrator $hydrator)
    {
        $this->taskRepository = $taskRepository;
        $this->hydrator = $hydrator;
    }

    /**
     * @param int $id
     * @return Task
     * @throws PageNotFoundException
     */
    public function find(int $id): Task
    {
        $task = $this->taskRepository->findById($id);

        if (!$task) {
            throw new PageNotFoundException();
        }

        return $task;
    }

    /**
     * @param array $data
     * @return Task
     */
    public function create(array $data): Task
    {
        $task = new Task();

        $this->hydrator->hydrateObject(array_filter($data), $task);
        $task->date = time();

        $task->id = $this->taskRepository->create($task);

        return $task;
    }

    /**
     * @param Task $task
     * @param array $data
     * @return Task
     */
    public function update(Task $task, array $data): Task
    {
        $this->hydrator->hydrateObject(array_filter($data), $task);

        $this->taskRepository->update($task);

        return $task;
    }

}
