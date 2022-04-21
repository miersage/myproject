<?php

namespace App\Domain\TaskList\Service;

use App\Domain\TaskList\Data\TaskListReadResult;
use App\Domain\TaskList\Repository\TaskListRepo;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class TaskListDelete
{
    /**
     * @var TaskListRepo
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param TaskListRepo $repository The repository
     */
    public function __construct(TaskListRepo $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Delete taskList by the given taskList id.
     *
     * @param int $taskListId The taskList id
     *
     * @throws ValidationException
     *
     * @return int TaskList Id
     */
    public function deleteTaskList(int $taskListId): int
    {
        // Input validation
        if (empty($taskListId)) {
            throw new ValidationException('TaskList Id required');
        }

        $result = $this->repository->deleteTaskListById($taskListId);

        return $result;
    }
}