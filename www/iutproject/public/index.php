<?php
session_start();

function read_cb($ch, $fp, $length) {
    return fread($fp, $length);
}

require (__DIR__ . '/../UI/router.php');
(require __DIR__ . '/../config/bootstrap.php')->run();