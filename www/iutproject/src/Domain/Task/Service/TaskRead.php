<?php

namespace App\Domain\Task\Service;

use App\Domain\Task\Data\TaskReadResult;
use App\Domain\Task\Repository\TaskRepo;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class TaskRead
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
     * Read task according to parameters.
     * @param array<mixed> $taskPrm
     * @throws ValidationException
     * @return TaskReadResult The task data
     */
    public function getTaskDetails(int $taskId): TaskReadResult
    {
        // Input validation
        if (empty($taskId)) {
            throw new ValidationException('Task key required');
        }

        $taskRow = $this->repository->getTaskById($taskId);

        // Map array to data object
        $task = new TaskReadResult();
        $task->taskId = (int)$taskRow['taskId'];
        $task->accountId = (int)$taskRow['accountId'];
        $task->taskListId = (int)$taskRow['taskListId'];
        $task->taskName = (string)$taskRow['taskName'];
        $task->status = (int)$taskRow['status'];
        $task->dueDate = (string)$taskRow['dueDate'];
        $task->note = (string)$taskRow['note'];

        return $task;
    }
}