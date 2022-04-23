<?php

namespace App\Domain\Task\Service;

use App\Domain\Task\Data\TaskReadResult;
use App\Domain\Task\Repository\TaskRepo;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class TaskDelete
{
    /**
     * @var TaskRepo
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param TaskRepo $repository The repository
     */
    public function __construct(TaskRepo $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Delete task by the given task id.
     *
     * @param int $taskId The task id
     *
     * @throws ValidationException
     *
     * @return int Task Id
     */
    public function deleteTask(int $taskId): int
    {
        // Input validation
        if (empty($taskId)) {
            throw new ValidationException('Task Id required');
        }

        $result = $this->repository->deleteTaskById($taskId);

        return $result;
    }
}