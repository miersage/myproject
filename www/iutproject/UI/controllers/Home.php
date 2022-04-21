<?php

// Home is the controller class for the home page and associated pages.
// Generally, this is the "static" controller, it displays all of the mandatory
// pages that aren't really dynamic: legal mentions, about, etc.
class Home {
	// index will only render the index view, and that's fine. On a
	// non-trivial application, we might want to retrieve some data here,
	// for example a blog might want to get the last post to display it.
	public function index() {
		return render("index", ["motd" => "hello world"]);
	}
}
