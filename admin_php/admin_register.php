<?php
require_once 'connect.php';
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");

if(isset($_POST['submit'])){

   $name = htmlspecialchars(mysqli_real_escape_string($con, $_POST['name']));
   $email = htmlspecialchars(mysqli_real_escape_string($con, $_POST['email']));
   $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
   $cpass = password_hash($_POST['cpassword'], PASSWORD_DEFAULT);
   $user_type = $_POST['user_type'];

   $select = " SELECT * FROM user_form WHERE email = '$email' || name = '$name' ";

   $result = mysqli_query($con, $select);

   if(mysqli_num_rows($result) > 0){

      $error[] = 'Pengguna sudah ada!';

   }else{

      if(!password_verify($_POST['password'], $cpass)){
         $error[] = 'Password tidak sesuai!';
      }else{
         $insert = "INSERT INTO user_form(name, email, password, user_type) VALUES('$name','$email','$pass','$user_type')";
         mysqli_query($con, $insert);
         echo '<script>alert("Registrasi berhasil"); window.location.href = "admin_login.php";</script>';
      }
   }

};
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Halaman Registrasi</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>
   
<div class="form-container" style="user-select: none">

   <form action="" method="post" style="max-width: 100%;">
      <h3 style="font-size: 130%;">Admin Register</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg" style="font-size: 90%;">'.$error.'</span>';
         };
      };
      ?>
      <input type="text" name="name" required placeholder="Masukkan nama kamu" autocomplete="off" style="width: 95%; font-size: 95%;">
      <input type="email" name="email" required placeholder="Masukkan email kamu" autocomplete="off" style="width: 95%; font-size: 95%;">
      <input type="password" name="password" required placeholder="Masukkan password" style="width: 95%; font-size: 95%;">
      <input type="password" name="cpassword" required placeholder="Konfirmasi password" style="width: 95%; font-size: 95%;">
      <select name="user_type" style="width: 95%; font-size: 95%;">
         <option value="admin" style="font-size: 90%;">Admin</option>
      </select>
      <input type="submit" name="submit" value="Daftar sekarang!" class="form-btn" style="font-size: 90%; width: 95%;">
      <p style="font-size: 90%;">Sudah memiliki akun? <a href="admin_login.php">Login sekarang!</a></p>
   </form>
</div>
<footer style="text-align: center;">
   <h5 style="font-size: 18px;">CopyRight &COPY; By <span style="color:red;">Achmad Tirto Sudiro</span></h5>
</footer>
</body>
</html>