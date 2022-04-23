<?php

namespace App\Domain\Task\Service;

use App\Domain\Task\Data\TaskReadResult;
use App\Domain\Task\Repository\TaskRepo;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class TaskList
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
     * List tasks.
     *
     * @throws ValidationException
     *
     * @return array TaskReadResult tasks list
     */
    public function getTaskList(array $taskPrm): array
    {
        // Input validation
        $accountId = $taskPrm['accountId'];
        $taskListId = $taskPrm['taskListId'];
        if (isset($accountId) && !empty($accountId)) {
            if (isset($taskListId) && !empty($taskListId)) {
                $taskRows = $this->repository->getTaskByTaskList($accountId, $taskListId);
            } else {
                $taskRows = $this->repository->getTaskByAccount($accountId);
            }
        } else {
            $taskRows = $this->repository->getTaskList();
        }

        // Map array to data object
        $tasks = Array();
        foreach ($taskRows as $taskRow) {
            $task = new TaskReadResult();
            $task->taskId = (int)$taskRow['taskId'];
            $task->accountId = (int)$taskRow['accountId'];
            $task->taskListId = (int)$taskRow['taskListId'];
            $task->taskName = (string)$taskRow['taskName'];
            $task->status = (int)$taskRow['status'];
            $task->dueDate = (string)$taskRow['dueDate'];
            $task->note = (string)$taskRow['note'];
        
            $tasks[] = $task;
        };
        return $tasks;
    }
}
