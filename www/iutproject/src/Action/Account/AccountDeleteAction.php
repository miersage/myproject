<?php

namespace App\Action\Account;

use App\Domain\Account\Service\AccountDelete;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class AccountDeleteAction
{
    /**
     * @var AccountDelete
     */
    private $accountDelete;

    /**
     * The constructor.
     *
     * @param AccountDelete $accountDelete The service
     */
    public function __construct(AccountDelete $accountDelete)
    {
        $this->accountDelete = $accountDelete;
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

        // Invoke the Domain (application service) with inputs and keep the result
        $result = $this->accountDelete->deleteAccount($accountId);

        // Transform the result into the JSON representation
        $result = ['message'=>'Account '. $accountId . ' deleted'];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
