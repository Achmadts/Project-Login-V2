<?php
session_start();
require_once 'config.php';
require_once 'connect.php';
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");

if(!isset($_SESSION['admin_name'])){
    header('location: admin_login.php');
    exit();
}

if(isset($_GET['deleteid'])){
    $id = $_GET['deleteid'];

    $sql = "DELETE FROM `user_form` WHERE id=$id";
    $result = mysqli_query($con, $sql);
    if($result){
        header('location: admin_page.php');
    }else{
        die(mysqli_error($con));
    }
}

?>