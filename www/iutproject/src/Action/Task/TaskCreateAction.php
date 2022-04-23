<?php

namespace App\Action\Task;

use App\Domain\Task\Service\TaskCreate;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class TaskCreateAction
{
    /**
     * @var TaskCreate
     */
    private $taskCreate;

    /**
     * The constructor.
     *
     * @param TaskCreate $taskCreate The service
     */
    public function __construct(TaskCreate $taskCreate)
    {
        $this->taskCreate = $taskCreate;
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
//rint_r($data);
        // Invoke the Domain with inputs and retain the result
        $taskId = $this->taskCreate->createTask($data);

        // Transform the result into the JSON representation
        $result = [
            'taskId' => $taskId
        ];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }
}