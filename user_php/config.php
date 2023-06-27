<?php
require_once('../vendor/autoload.php');
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
        header('Location: index.php');
        exit();
    }
}

//Login google
// $gClient = new Google_Client();
// $gClient->setClientId("1031071879416-r6d85aatskn327s2v3ktst485potkt1e.apps.googleusercontent.com");
// $gClient->setClientSecret("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");
// $gClient->setApplicationName("Login Page By Achmad");
// $gClient->setRedirectUri("http://localhost/phpdasar/newportofolio_edit/user_php/index.php");
// $gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");

// $login_url = $gClient->createAuthUrl();

?> 