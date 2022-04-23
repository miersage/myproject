<?php

namespace App\Action\TaskList;

use App\Domain\TaskList\Service\TaskListCreate;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class TaskListCreateAction
{
    /**
     * @var TaskListCreate
     */
    private $taskListCreate;

    /**
     * The constructor.
     *
     * @param TaskListCreate $taskListCreate The service
     */
    public function __construct(TaskListCreate $taskListCreate)
    {
        $this->taskListCreate = $taskListCreate;
    }

    /**
     * Invoke.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     *
     * @return ResponseInterface The response
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();
        // Invoke the Domain with inputs and retain the result
        $taskListId = $this->taskListCreate->createTaskList($data);

        // Transform the result into the JSON representation
        $result = [
            'taskListId' => $taskListId
        ];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }
}