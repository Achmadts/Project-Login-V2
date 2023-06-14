<?php
require_once 'config.php';
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");

if(isset($_POST['submit'])){
   $error = array();

   // prepared statement untuk mencegah SQL injection
   $select = $conn->prepare("SELECT * FROM user_form WHERE email = ? OR name = ?");
   $select->bind_param("ss", $email, $name);

   $name = htmlspecialchars(trim($_POST['name']));
   $email = htmlspecialchars(trim($_POST['email']));

   $select->execute();
   $result = $select->get_result();

   if($result->num_rows > 0){
      $error[] = 'Pengguna sudah ada!';
   }else{
      $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $cpass = password_hash($_POST['cpassword'], PASSWORD_DEFAULT);
      $user_type = $_POST['user_type'];

      if(!password_verify($_POST['cpassword'], $pass)){
         $error[] = 'Password tidak sesuai!';
      }else{
         // Menggunakan prepared statement untuk mencegah SQL injection
         $insert = $conn->prepare("INSERT INTO user_form(name, email, password, user_type) VALUES(?, ?, ?, ?)");
         $insert->bind_param("ssss", $name, $email, $pass, $user_type);
         $insert->execute();
         echo '<script>alert("Registrasi berhasil"); window.location.href = "login_form.php";</script>';
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
   <link rel="stylesheet" href="style.css">
   <title>Halaman Registrasi User</title>
</head>
<body>
   
<div class="form-container">

   <form action="" method="post" style="max-width: 85%;">
      <h3 style="font-size: 150%;">Halaman Daftar</h3>
      <?php
      if(isset($error)){
         foreach($error as $err){
            echo '<span class="error-msg">'.$err.'</span>';
         };
      };
      ?>
         <input type="text" name="name" required placeholder="Masukkan nama kamu" autocomplete="off" style="width: 95%; font-size: 95%;">
         <input type="email" name="email" required placeholder="Masukkan email kamu" autocomplete="off" style="width: 95%; font-size: 95%;">
         <input type="password" name="password" required placeholder="Masukkan password" style="width: 95%; font-size: 95%;">
         <input type="password" name="cpassword" required placeholder="Konfirmasi password" style="width: 95%; font-size: 95%;">
         <select name="user_type" style="width: 95%; font-size: 95%;">
            <option value="user" style="font-size: 90%;">Pengguna</option>
      </select>
      <input type="submit" name="submit" value="Daftar sekarang!" class="form-btn" style="font-size: 95%; width: 95%;">
      <p style="font-size: 100%;">Sudah memiliki akun? <a href="login_form.php">Login sekarang!</a></p>
   </form>
</div>
<footer style="text-align: center;">
   <h5 style="font-size: 18px;">CopyRight &COPY; By <span style="color:red;">Achmad Tirto Sudiro</span></h5>
</footer>
</body>
</html>