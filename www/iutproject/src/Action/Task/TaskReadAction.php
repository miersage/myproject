<?php

namespace App\Action\Task;

use App\Domain\Task\Service\TaskRead;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class TaskReadAction
{
    /**
     * @var TaskRead
     */
    private $taskRead;

    /**
     * The constructor.
     *
     * @param TaskRead $taskRead The service
     */
    public function __construct(TaskRead $taskRead)
    {
        $this->taskRead = $taskRead;
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

        // Invoke the Domain (application service) with inputs and keep the result
        $task = $this->taskRead->getTaskDetails($taskId);

        // Transform the result into the JSON representation
        $result = $task->jsonSerialize();

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
