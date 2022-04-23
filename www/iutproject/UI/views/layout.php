<!DOCTYPE html>
<ul>
	<li><a href="<?= route("index") ?>">index</a></li>
<?php if (loggedIn()) { ?>
	<li>Logged as: <?= user()["login"] ?></li>
	<li><a href="<?= route("process_logout") ?>">logout</a></li>
<?php } else { ?>
	<li><a href="<?= route("login") ?>">login</a></li>
	<li><a href="<?= route("register") ?>">register</a></li>
<?php } ?>
</ul>
<?= $content ?>

