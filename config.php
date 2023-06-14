<?php
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");
// merupakan database yang digunakan untuk semua user page
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'user_db';

$conn = mysqli_connect($host, $user, $password, $database);

if(!$conn){
    echo "connection sucessfull";
    die(mysqli_error($con));
}

function check_user_login()
{
    if (!isset($_SESSION['user_name'])) {
        header('Location: login_form.php');
        exit();
    }
}
?> 