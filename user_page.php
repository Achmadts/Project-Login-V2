<?php
session_start();
require_once 'config.php';
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");
check_user_login();

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User Page</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">

</head>
<body>
   
<div class="container">

   <div class="content">
      <h3 style="font-size: 150%;">Hai, <span>Pengguna</span></h3>
      <h1 style="font-size: 150%;">Selamat Datang <span><?php echo $_SESSION['user_name']; ?></span></h1>
      <p style="font-size: 100%;">Ini adalah halman <span>pengguna</span></p>
      <a href="logout.php" class="btn" onclick="return confirm(`Yakin banh mau logout?`)" style="transition: .4s; font-size: medium;">logout</a>
      <a href="index.php" class="btn" style="transition: .4s; font-size: medium;">Next <span style="font-size: auto;">&raquo;</span></a>
   </div>
</div>
<footer style="text-align: center;">
   <h5 style="font-size: 18px;">CopyRight &COPY; By <span style="color:red;">Achmad Tirto Sudiro</span></h5>
</footer>
</body>
</html>