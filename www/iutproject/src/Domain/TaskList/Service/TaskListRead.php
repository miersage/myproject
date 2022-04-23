<?php

namespace App\Domain\TaskList\Service;

use App\Domain\TaskList\Data\TaskListReadResult;
use App\Domain\TaskList\Repository\TaskListRepo;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class TaskListRead
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
     * Read taskList according to parameters.
     * @param array<mixed> $taskListPrm
     * @throws ValidationException
     * @return TaskListReadResult The taskList data
     */
    public function getTaskListDetails(int $taskListId): TaskListReadResult
    {
        // Input validation
        if (empty($taskListId)) {
            throw new ValidationException('TaskList key required');
        }

        $taskListRow = $this->repository->getTaskListById($taskListId);

        // Map array to data object
        $taskList = new TaskListReadResult();
        $taskList->taskListId = (int)$taskListRow['taskListId'];
        $taskList->accountId = (string)$taskListRow['accountId'];
        $taskList->taskListName = (string)$taskListRow['taskListName'];
        $taskList->status = (int)$taskListRow['status'];

        return $taskList;
    }
}