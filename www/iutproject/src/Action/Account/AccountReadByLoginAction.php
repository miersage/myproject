<?php

namespace App\Action\Account;

use App\Domain\Account\Service\AccountRead;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class AccountReadByLoginAction
{
    /**
     * @var AccountRead
     */
    private $accountRead;

    /**
     * The constructor.
     *
     * @param AccountRead $accountRead The service
     */
    public function __construct(AccountRead $accountRead)
    {
        $this->accountRead = $accountRead;
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
        $accountPrm = [
            'accountId' => null,
            'login' => (string)$args['login'],
        ];

        // Invoke the Domain (application service) with inputs and keep the result
        $account = $this->accountRead->getAccountDetails($accountPrm);

        // Transform the result into the JSON representation
        $result = $account->jsonSerialize();

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
