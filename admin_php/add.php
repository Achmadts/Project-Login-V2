<?php
session_start();
require_once '../user_php/config.php';
require_once 'connect.php';
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");

if(!isset($_SESSION['admin_name'])){
   header('location: admin_login.php');
   exit();
}

if(isset($_POST['submit'])){
   $name = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['name']));
   $email = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['email']));
   $password = $_POST['password'];
   $cpassword = $_POST['cpassword'];
   $user_type = $_POST['user_type'];

   $select = " SELECT * FROM user_form WHERE email = '$email' || name = '$name' ";
   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){
      $error[] = 'Email atau pengguna sudah ada!';
   }else{
      if($password != $cpassword){
         $error[] = 'Password tidak sesuai!';
      }else{
         $hashed_password = password_hash($password, PASSWORD_DEFAULT);
         $insert = "INSERT INTO user_form(name, email, password, user_type) VALUES('$name','$email','$hashed_password','$user_type')";
         if(mysqli_query($conn, $insert)){
            echo '<script>alert("User berhasil ditambahkan."); window.location.href = "admin_page.php";</script>';
         } 
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Tambah User</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>Tambah User</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="text" name="name" required placeholder="Masukkan nama kamu" autocomplete="off">
      <input type="email" name="email" required placeholder="Masukkan email kamu" autocomplete="off">
      <input type="password" name="password" required placeholder="Masukkan password kamu">
      <input type="password" name="cpassword" required placeholder="Konfirmasi password kamu">
      <select name="user_type">
         <option value="user">Pengguna</option>
         <option value="admin">Admin</option>
      </select>
      <input type="submit" name="submit" value="Tambahkan" class="form-btn">
   </form>

</div>
<footer style="text-align: center;">
   <h5 style="font-size: 18px;">CopyRight &COPY; By <span style="color:red;">Achmad Tirto Sudiro</span></h5>
</footer>
</body>
</html>
