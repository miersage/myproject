<?php

namespace App\Action\Account;

use App\Domain\Account\Service\AccountUpdate;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class AccountUpdateAction
{
    /**
     * @var AccountUpdate
     */
    private $accountUpdate;

    /**
     * The constructor.
     *
     * @param AccountUpdate $accountUpdate The service
     */
    public function __construct(AccountUpdate $accountUpdate)
    {
        $this->accountUpdate = $accountUpdate;
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
        $accountId = (int)$args['accountId'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain (application service) with inputs and keep the result
        $result = $this->accountUpdate->updateAccountById($accountId, $data);

        // Transform the result into the JSON representation
        $result = ['message'=>'Account '. $accountId . ' updated'];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
