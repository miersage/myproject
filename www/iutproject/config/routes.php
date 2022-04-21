<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {

    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    // REACT
        $app->get('/', function (Request $request, Response $response, array $args) {
        $homepage = file_get_contents('./react/index.html');
        $response->getBody()->write($homepage);
        return $response;
    });

    // UI
    $app->get('/ui[/{action}]', \App\Action\UI\UIAction::class);
    $app->post('/ui/{action}', \App\Action\UI\UIAction::class);

    // API
    $app->get('/api', \App\Action\Account\AccountListAction::class);
    $app->get('/api/account', \App\Action\Account\AccountListAction::class);
    $app->get('/api/account/{accountId}', \App\Action\Account\AccountReadAction::class);
    $app->get('/api/account1/{login}', \App\Action\Account\AccountReadByLoginAction::class);
    $app->post('/api/account', \App\Action\Account\AccountCreateAction::class);
    $app->put('/api/account/{accountId}', \App\Action\Account\AccountUpdateAction::class);
    $app->delete('/api/account/{accountId}', \App\Action\Account\AccountDeleteAction::class);

    $app->get('/api/tasklist', \App\Action\TaskList\TaskListListAction::class);
    $app->get('/api/tasklist/{taskListId}', \App\Action\TaskList\TaskListReadAction::class);
    $app->get('/api/tasklist1/{accountId}', \App\Action\TaskList\TaskListListByAccountAction::class);
    $app->post('/api/tasklist', \App\Action\TaskList\TaskListCreateAction::class);
    $app->put('/api/tasklist/{taskListId}', \App\Action\TaskList\TaskListUpdateAction::class);
    $app->delete('/api/tasklist/{taskListId}', \App\Action\TaskList\TaskListDeleteAction::class);

    $app->get('/api/task', \App\Action\Task\TaskListAction::class);
    $app->get('/api/task/{taskId}', \App\Action\Task\TaskReadAction::class);
    $app->get('/api/task1/{accountId}', \App\Action\Task\TaskListByAccountAction::class);
    $app->get('/api/task1/{accountId}/{taskListId}', \App\Action\Task\TaskListByTaskListAction::class);
    $app->post('/api/task', \App\Action\Task\TaskCreateAction::class);
    $app->put('/api/task/{taskId}', \App\Action\Task\TaskUpdateAction::class);
    $app->delete('/api/task/{taskId}', \App\Action\Task\TaskDeleteAction::class);
};
