<?php

namespace App\Action\UI;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Action
 */
final class UIAction
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * The constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
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
        global $config;
        if (isset($args['action'])) {
            $action = (string)$args['action'];
        } else {
            $action = $config['default_action'];
        }

        global $routes;
        if (!isset($routes[$action])) {
            $result = render("404");
            // Build the HTTP response
            $response->getBody()->write((string)$result);
            return $response;
        }
        
        // Get the controller definition from the routes.
        $controller = $routes[$action];
        // => User@processLogin

        // The controller definition use the form 'Class@method', so we split the
        // definition around the '@' to have the two parts, and use the list()
        // structure to retrieve the elements of the resulting array into separate
        // variables.
        list($class, $method) = explode('@', $controller);
        // $class => "User"
        // $method => "processLogin"

        // Instanciate the controller class. We use the $class variable directly, this
        // is allowed by PHP. Not my favorite feature, but... it works.
        $instance = new $class();
        // $instance = new User();

        // Call the controller method on the instance.
        $result = $instance->$method();
        // $instance->processLogin()

        // Build the HTTP response
        $response->getBody()->write((string)$result);

        return $response;
    }
}
