<?php

namespace App\Action\TaskList;

use App\Domain\TaskList\Service\TaskListDelete;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class TaskListDeleteAction
{
    /**
     * @var TaskListDelete
     */
    private $taskListDelete;

    /**
     * The constructor.
     *
     * @param TaskListDelete $taskListDelete The service
     */
    public function __construct(TaskListDelete $taskListDelete)
    {
        $this->taskListDelete = $taskListDelete;
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
        $taskListId = (int)$args['taskListId'];

        // Invoke the Domain (application service) with inputs and keep the result
        $result = $this->taskListDelete->deleteTaskList($taskListId);

        // Transform the result into the JSON representation
        $result = ['message'=>'TaskList '. $taskListId . ' deleted'];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
