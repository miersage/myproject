<?php

namespace App\Action\Task;

use App\Domain\Task\Service\TaskDelete;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class TaskDeleteAction
{
    /**
     * @var TaskDelete
     */
    private $taskDelete;

    /**
     * The constructor.
     *
     * @param TaskDelete $taskDelete The service
     */
    public function __construct(TaskDelete $taskDelete)
    {
        $this->taskDelete = $taskDelete;
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
        $result = $this->taskDelete->deleteTask($taskId);

        // Transform the result into the JSON representation
        $result = ['message'=>'Task '. $taskId . ' deleted'];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
