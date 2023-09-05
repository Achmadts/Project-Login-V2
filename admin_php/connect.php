<?php
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");
//merupakan data config untuk semua admin page

$host = 'localhost';
$user = 'rot';
$password = '';
$database = 'user_db';

$con = mysqli_connect($host, $user, $password, $database);

if(!$con){
    echo "connection sucessfull";
    die(mysqli_error($con));
}
function check_admin_login()
{
    if (!isset($_SESSION['admin_name'])) {
        header('Location: admin_login.php');
        exit();
    }
}
?> 
