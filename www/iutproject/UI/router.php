<?php
/* commented
session_start();
commented */

// Retrieve the configuration from the config.php file. This file use a naked
// return directly to avoid having the variable name in the file, avoiding
// mistakes while modifying it.
$config = require(__DIR__."/config.php");

// Retrieve the routes from the routes.php file. Same convention as the
// configuration, with the added benefit that someone can't try to play with
// the URL to require arbitrary files like with the direct require we had
// earlier.
$routes = require(__DIR__."/routes.php");

// Include the utilities and controllers. We're starting to use classes here
// for the controllers, and will configure the autoloader later so avoid having
// to do this by hand.
require(__DIR__."/flash.php");
require(__DIR__."/database.php");
require(__DIR__."/controllers/Home.php");
require(__DIR__."/controllers/User.php");

// route returns the URL to use in links to point to a sepcific action.
function route($action) {
	//return "router.php?action=$action";
	return "/ui/$action";
}

// redirect to a specific action using a HTTP Location header, then stops the
// execution of the script.
function redirect($action) {
	header("Location: ".route($action));
	exit();
}

// logIn set the current logged user given in parameter.
function logIn($user) {
	$_SESSION["logged_user"] = $user;
}

// loggedIn retuns true if the session contains an user.
function loggedIn() {
	return isset($_SESSION["logged_user"]);
}

// user from the session, only valid if loggedIn returns true.
function user() {
	return $_SESSION["logged_user"];
}

// render a view. The result will then be passed to the views/layout.php file
// as the $content variable.
function render($view, $data = []) {
	// extract takes an array as parameter, and will create one variable
	// per key with the corresponding value. For example, given an array
	// ['foo' => 'bar'], it will create $foo = 'bar'. This is used here so
	// the controller can pass variables to the views without having to
	// worry about naming conflicts, etc.
	extract($data);

	// Start output buffering. This will make PHP write all output in a
	// buffer instead of sending it right away, so we can retrieve it
	// later.
	ob_start();
	// Require the wanted view.
	require(__DIR__."/views/$view.php");
	// Retrieve the content of the output buffer and clean it.
	$content = ob_get_clean();

	// Require the layout view.
	ob_start();
	require(__DIR__."/views/layout.php");
	return ob_get_clean();
}

/* commented

// Ensure that we have an action defined, and set a default one (from the
// configuration, this is the "default page", generally the home page) if there
// is none.
if (isset($_GET["action"])) {
	$action = $_GET["action"];
} else {
	$action = $config['default_action'];
}

// Ensure that the requested page exists, and display a specific view if it
// doesn't. In combination with the routes array, this is what prevents anyone
// from requesting an arbitrary class, which could be very dangerous from a
// security point of view.
if (!isset($routes[$action])) {
	render("404");
	exit;
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
$instance->$method();
// $instance->processLogin()

commented */
