<?php

namespace App\Domain\Task\Service;

use App\Domain\Task\Repository\TaskRepo;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class TaskCreate
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
     * Create a new task.
     *
     * @param array<mixed> $data The form data
     *
     * @return int The new task Id
     */
    public function createTask(array $data): int
    {
        // Input validation
        $this->validateNewTask($data);

        // Insert task
        $taskId = $this->repository->insertTask($data);

        // Logging here: Task created successfully
        //$this->logger->info(sprintf('Task created successfully: %s', $taskId));

        return $taskId;
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