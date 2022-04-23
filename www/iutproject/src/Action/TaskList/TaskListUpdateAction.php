<?php

namespace App\Action\TaskList;

use App\Domain\TaskList\Service\TaskListUpdate;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class TaskListUpdateAction
{
    /**
     * @var TaskListUpdate
     */
    private $taskListUpdate;

    /**
     * The constructor.
     *
     * @param TaskListUpdate $taskListUpdate The service
     */
    public function __construct(TaskListUpdate $taskListUpdate)
    {
        $this->taskListUpdate = $taskListUpdate;
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
        $data = (array)$request->getParsedBody();

        // Invoke the Domain (application service) with inputs and keep the result
        $result = $this->taskListUpdate->updateTaskListById($taskListId, $data);

        // Transform the result into the JSON representation
        $result = ['message'=>'TaskList '. $taskListId . ' updated'];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
