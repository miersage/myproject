<?php

if (isset($_SESSION["flash"])) {
	$flash = $_SESSION["flash"];
	unset($_SESSION["flash"]);
}

function getFlash($key) {
	global $flash;
	return $flash[$key];
}

function hasFlash($key) {
	global $flash;
	return isset($flash[$key]);
}

function setFlash($key, $value) {
	$_SESSION["flash"][$key] = $value;
}
