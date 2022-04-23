<?php

namespace App\Action\Account;

use App\Domain\Account\Service\AccountMethod;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class AccountMethodAction
{
    /**
     * @var AccountMethod
     */
    private $accountMethod;

    /**
     * The constructor.
     *
     * @param AccountMethod $accountMethod The service
     */
    public function __construct(AccountMethod $accountMethod)
    {
        $this->accountMethod = $accountMethod;
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
        $params = explode('/', $args['params']);
        // Invoke the Domain (application service) with inputs and keep the result
        $result = $this->accountMethod->doAccountMethod($params);

        // Transform the result into the JSON representation
        $result = ['message'=>$params[0] . ' method done'];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
