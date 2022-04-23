<?php

namespace App\Domain\Task\Service;

use App\Domain\Task\Data\TaskReadResult;
use App\Domain\Task\Repository\TaskRepo;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class TaskUpdate
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
     * Update task by the given task id.
     *
     * @param int $taskId The task id
     * @param array<mixed> $data The form data
     *
     * @throws ValidationException
     *
     * @return TaskReadResult The task data
     */
    public function updateTaskById(int $taskId, array $data): int
    {
        // Input validation
        if (empty($taskId)) {
            throw new ValidationException('Task Id required');
        }
        $this->validateNewTask($data);

        $result = $this->repository->updateTaskById($taskId, $data);

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
    private function validateNewTask(array $data): void
    {
        $errors = [];

        if (empty($data['accountId'])) {
            $errors['accountId'] = 'accountId required';
            $errMessage = 'accountId required';
        }

        if (empty($data['taskListId'])) {
            $errors['taskListId'] = 'taskListId required';
            $errMessage = 'taskListId required';
        }

        if (empty($data['taskName'])) {
            $errors['taskName'] = 'taskName required';
            $errMessage = 'taskName required';
        }

        if ($errors) {
            throw new ValidationException($errMessage, $errors);
        }
    }
}