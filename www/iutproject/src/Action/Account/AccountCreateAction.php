<?php

namespace App\Action\Account;

use App\Domain\Account\Service\AccountCreate;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class AccountCreateAction
{
    /**
     * @var AccountCreate
     */
    private $accountCreate;

    /**
     * The constructor.
     *
     * @param AccountCreate $accountCreate The service
     */
    public function __construct(AccountCreate $accountCreate)
    {
        $this->accountCreate = $accountCreate;
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
        $accountId = $this->accountCreate->createAccount($data);

        // Transform the result into the JSON representation
        $result = [
            'accountId' => $accountId
        ];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response
                 ->withHeader('Content-Type', 'application/json')
                 ->withStatus(201);
    }
}