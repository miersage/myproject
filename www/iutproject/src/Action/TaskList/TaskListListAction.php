<?php

namespace App\Action\TaskList;

use App\Domain\TaskList\Service\TaskListList;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class TaskListListAction
{
    /**
     * @var TaskListList
     */
    private $taskListList;

    /**
     * The constructor.
     *
     * @param TaskListList $taskListList The service
     */
    public function __construct(TaskListList $taskListList)
    {
        $this->taskListList = $taskListList;
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
        $taskListPrm = [
            'accountId' => null,
        ];

        // Invoke the Domain (application service) with inputs and keep the result
        $taskLists = $this->taskListList->getTaskListList($taskListPrm);

        // Transform the result into the JSON representation
        $result = Array();
        foreach ($taskLists as $taskList) {
            $result[] = $taskList->jsonSerialize();
        };

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
