<?php

namespace App\Domain\TaskList\Service;

use App\Domain\TaskList\Repository\TaskListRepo;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class TaskListCreate
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
     * Create a new taskList.
     *
     * @param array<mixed> $data The form data
     *
     * @return int The new taskList Id
     */
    public function createTaskList(array $data): int
    {
        // Input validation
        $this->validateNewTaskList($data);

        // Insert taskList
        $taskListId = $this->repository->insertTaskList($data);

        // Logging here: TaskList created successfully
        //$this->logger->info(sprintf('TaskList created successfully: %s', $taskListId));

        return $taskListId;
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