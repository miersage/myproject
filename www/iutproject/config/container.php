<?php

use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\UidProcessor;
use Psr\Log\LoggerInterface;

return [
    'settings' => function () {
        return require __DIR__ . '/settings.php';
    },

    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);

        return AppFactory::create();
    },

    ErrorMiddleware::class => function (ContainerInterface $container) {
        $app = $container->get(App::class);
        $settings = $container->get('settings')['error'];

        return new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool)$settings['display_error_details'],
            (bool)$settings['log_errors'],
            (bool)$settings['log_error_details']
        );
    },

    LoggerInterface::class => function (ContainerInterface $container) {
        //$settings = $container->get(SettingsInterface::class);
        $settings = $container->get('settings')['logger'];

        $loggerSettings = $settings->get('logger');
        $logger = new Logger($loggerSettings['name']);

        $processor = new UidProcessor();
        $logger->pushProcessor($processor);

        $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
        $logger->pushHandler($handler);

        return $logger;
    },

    PDO::class => function (ContainerInterface $container) {
        $settings = $container->get('settings')['dbSqlite'];

        $dbname = $settings['database'];
        $username = $settings['username'];
        $password = $settings['password'];
        $flags = $settings['flags'];
        $dsn = "sqlite:$dbname";
        $db = new PDO($dsn, $username, $password, $flags);
        $db->exec('PRAGMA foreign_keys = ON;');

        return $db;
    },

    // PDO::class => function (ContainerInterface $container) {
    //     $settings = $container->get('settings')['dbMysql'];

    //     $host = $settings['host'];
    //     $dbname = $settings['database'];
    //     $username = $settings['username'];
    //     $password = $settings['password'];
    //     $charset = $settings['charset'];
    //     $flags = $settings['flags'];
    //     $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

    //     return new PDO($dsn, $username, $password, $flags);
    // },
];
