<?php

// User is the controller for any user-related action: login, logout, register,
// profile, etc.
class User {
	public function login() {
		return render("login");
	}

	public function processLogin() {
		// Get the form data in variables so it's easier to read later.
		$login = $_POST['login'];
		$password = $_POST['password'];

		// Retrieve the database connection and prepare a statement for
		// retrieving the user row for the given login.
		$stmt = db()->prepare("select * from users where login = ? limit 1");

		// Execute the statement. execute returns a boolean indicating
		// if the request errored out, which can happen if your syntax
		// is wrong, etc. Proper error handling here is mandatory to
		// avoid displaying an ugly error message to the user, or
		// worse, a blank page.
		$res = $stmt->execute([$login]);
		if ($res === false) {
			setFlash("err", "internal_error");
			redirect("login");
		}

		// Fetch the user row. A null result indicates that there is no
		// user with the wanted login, which should display an error on
		// the login form.
		$user = $stmt->fetch();
		if ($user == null) {
			setFlash("err", "unknown_user");
			redirect("login");
		}

		// Check the password from the form against the hash stored in
		// the database.
		if (!password_verify($_POST['password'], $user["password"])) {
			setFlash("err", "wrong_password");
			redirect("login");
		}

		// If everything's dandy, store the user in the session to
		// indicate that the user is loggedIn.
		logIn($user);
		redirect("index");
	}

	public function processLogout() {
		logIn(null);
		redirect("login");
	}

	public function register() {
		return render("register");
	}

	public function processRegister() {
		$login = $_POST['login'];
		$password = $_POST['password'];

		// We hash the password so the password is never stored in
		// plaintext in the database. The default hashing function used
		// by PHP is BCrypt, which is a solid cryptographic algorithm.
		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
		// => $2y$12$salt.hash

		$stmt = db()->prepare("insert into users (id, login, password) values (null, ?, ?)");
		$res = $stmt->execute([$login, $hashedPassword]);
		if ($res === false) {
			setFlash("err", "internal_error");
			redirect('register');
		}

		redirect('login');
	}
}
