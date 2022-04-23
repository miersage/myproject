<?php

namespace App\Action\Task;

use App\Domain\Task\Service\TaskUpdate;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class TaskUpdateAction
{
    /**
     * @var TaskUpdate
     */
    private $taskUpdate;

    /**
     * The constructor.
     *
     * @param TaskUpdate $taskUpdate The service
     */
    public function __construct(TaskUpdate $taskUpdate)
    {
        $this->taskUpdate = $taskUpdate;
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
        $taskId = (int)$args['taskId'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain (application service) with inputs and keep the result
        $result = $this->taskUpdate->updateTaskById($taskId, $data);

        // Transform the result into the JSON representation
        $result = ['message'=>'Task '. $taskId . ' updated'];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
