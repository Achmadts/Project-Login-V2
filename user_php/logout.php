<?php
require_once 'config.php';
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");

session_start();
$_SESSION = [];
session_unset();
session_destroy();

setcookie('email', '', time() - 3600);
setcookie('password', '', time() - 3600);

header('location: index.php');
exit;
?>