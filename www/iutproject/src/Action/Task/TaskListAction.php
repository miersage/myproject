<?php

namespace App\Action\Task;

use App\Domain\Task\Service\TaskList;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class TaskListAction
{
    /**
     * @var TaskList
     */
    private $taskList;

    /**
     * The constructor.
     *
     * @param TaskList $taskList The service
     */
    public function __construct(TaskList $taskList)
    {
        $this->taskList = $taskList;
    }

    /**
     * Invoke.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     * @param array<mixed> $args The route arguments
     *
     * @return ResponseInterface The response
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args = []
    ): ResponseInterface {
        // Collect input from the HTTP request
        $taskPrm = [
            'accountId' => null,
            'taskListId' => null,
        ];

        // Invoke the Domain (application service) with inputs and keep the result
        $tasks = $this->taskList->getTaskList($taskPrm);

        // Transform the result into the JSON representation
        $result = Array();
        foreach ($tasks as $task) {
            $result[] = $task->jsonSerialize();
        };

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
