<h1>login</h1>
<form method="POST" action="<?= route("process_login") ?>">
<input type="text" name="login">
<input type="password" name="password">
<input type="submit">
</form>
<?php if (hasFlash("err")) { ?>
<p><?= getFlash("err") ?></p>
<?php } ?>

