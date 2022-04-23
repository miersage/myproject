<?php

namespace App\Domain\TaskList\Service;

use App\Domain\TaskList\Data\TaskListReadResult;
use App\Domain\TaskList\Repository\TaskListRepo;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class TaskListUpdate
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
     * Update taskList by the given taskList id.
     *
     * @param int $taskListId The taskList id
     * @param array<mixed> $data The form data
     *
     * @throws ValidationException
     *
     * @return TaskListReadResult The taskList data
     */
    public function updateTaskListById(int $taskListId, array $data): int
    {
        // Input validation
        if (empty($taskListId)) {
            throw new ValidationException('TaskList Id required');
        }
        $this->validateNewTaskList($data);

        $result = $this->repository->updateTaskListById($taskListId, $data);

        return $result;
    }

    /**
     * Input validation.
     *
     * @param array<mixed> $data The form data
     *
     * @throws ValidationException
     *
     * @return void
     */
    private function validateNewTaskList(array $data): void
    {
        $errors = [];

        if (empty($data['accountId'])) {
            $errors['accountId'] = 'accountId required';
            $errMessage = 'accountId required';
        }

        if (empty($data['taskListName'])) {
            $errors['taskListName'] = 'taskListName required';
            $errMessage = 'taskListName required';
        }

        if ($errors) {
            throw new ValidationException($errMessage, $errors);
        }
    }
}