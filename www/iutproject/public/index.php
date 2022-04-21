<?php
session_start();

require (__DIR__ . '/../UI/router.php');
(require __DIR__ . '/../config/bootstrap.php')->run();