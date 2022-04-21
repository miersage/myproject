<?php

namespace App\Action\Account;

use App\Domain\Account\Service\AccountList;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class AccountListAction
{
    /**
     * @var AccountList
     */
    private $accountList;

    /**
     * The constructor.
     *
     * @param AccountList $accountList The service
     */
    public function __construct(AccountList $accountList)
    {
        $this->accountList = $accountList;
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

        // Invoke the Domain (application service) with inputs and keep the result
        $accounts = $this->accountList->getAccountList();

        // Transform the result into the JSON representation
        $result = Array();
        foreach ($accounts as $account) {
            $result[] = $account->jsonSerialize();
        };

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
