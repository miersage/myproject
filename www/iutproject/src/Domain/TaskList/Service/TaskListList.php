<?php

namespace App\Domain\TaskList\Service;

use App\Domain\TaskList\Data\TaskListReadResult;
use App\Domain\TaskList\Repository\TaskListRepo;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class TaskListList
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
     * List taskLists.
     *
     * @throws ValidationException
     *
     * @return array TaskListReadResult taskLists list
     */
    public function getTaskListList(array $taskListPrm): array
    {
        // Input validation
        $accountId = $taskListPrm['accountId'];
        if (isset($accountId) && !empty($accountId)) {
            $taskListRows = $this->repository->getTaskListByAccount($accountId);
        } else {
            $taskListRows = $this->repository->getTaskListList();
        }

        // Map array to data object
        $taskLists = Array();
        foreach ($taskListRows as $taskListRow) {
            $taskList = new TaskListReadResult();
            $taskList->taskListId = (int)$taskListRow['taskListId'];
            $taskList->accountId = (string)$taskListRow['accountId'];
            $taskList->taskListName = (string)$taskListRow['taskListName'];
            $taskList->status = (int)$taskListRow['status'];
    
            $taskLists[] = $taskList;
        };
        return $taskLists;
    }
}
