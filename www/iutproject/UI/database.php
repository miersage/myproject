<?php

// db will return a valid database connection, initializing it if necessary.
$db = null;
function db () {
	// PHP uses a weird scoping scheme, where the "out of function" code is
	// the "global" scope, and functions of any kind (function, class
	// methods, etc) is a "local" scope which doesn't have access to the
	// global scope by default. We use the global keyword to assert that
	// the $db and $config variables are the ones defined in the global
	// scope.
	global $db;
	global $config;

	if ($db !== null) {
		return $db;
	}
	// We initialize the database connection using the Data Source Name
	// (DSN) from the configuration.
	$db = new PDO($config['database_dsn'], "", "", []);
	return $db;
}
