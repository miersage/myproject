<?php

use Monolog\Logger;

// Error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Error reporting for production
//error_reporting(0);
//ini_set('display_errors', '0');

// Settings
$settings = [];

// Path settings
$settings['root'] = dirname(__DIR__);

    // Error Handling Middleware settings
$settings['error'] = [
    // Should be set to false in production
    'display_error_details' => true,

    // Parameter is passed to the default ErrorHandler
    // View in rendered output by enabling the "displayErrorDetails" setting.
    // For the console and unit tests we also disable it
    'log_errors' => true,

    // Display error details in error log
    'log_error_details' => true,
];

$settings['logger'] = [
    'name' => 'slim-app',
    'path' => __DIR__ . '/../logs/app.log',
    'level' => Logger::DEBUG,
];

// Database settings
$settings['dbSqlite'] = [
    'driver' => 'sqlite',
    'database' => './../database/iutproject.sqlite',
    'username' => '',
    'password' => '',
    'flags' => [
        // Turn off persistent connections
        PDO::ATTR_PERSISTENT => false,
        // Enable exceptions
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // Emulate prepared statements
        PDO::ATTR_EMULATE_PREPARES => true,
        // Set default fetch mode to array
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ],
];

// Database settings
$settings['dbMysql'] = [
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'iutproject',
    'username' => 'iutproject',
    'password' => 'iutproject',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'flags' => [
        // Turn off persistent connections
        PDO::ATTR_PERSISTENT => false,
        // Enable exceptions
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // Emulate prepared statements
        PDO::ATTR_EMULATE_PREPARES => true,
        // Set default fetch mode to array
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // Set character set
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci'
    ],
];

return $settings;