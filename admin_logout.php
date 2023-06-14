<?php

require_once 'config.php';
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");

session_start();
session_unset();
session_destroy();

header('location:admin_login.php');

?>