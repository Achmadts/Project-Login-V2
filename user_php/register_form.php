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
         echo '<script>alert("Registrasi berhasil"); window.location.href = "index.php";</script>';
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
   <link rel="stylesheet" href="../css/style.css">
   <title>Halaman Registrasi</title>
</head>
<body>
   
<div class="form-container" style="user-select: none">

   <form action="" method="post" style="max-width: 100%;">
      <h3 style="font-size: 130%;">Halaman Daftar</h3>
      <?php
      if(isset($error)){
         foreach($error as $err){
            echo '<span class="error-msg" style="font-size: 90%;">'.$err.'</span>';
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
      <input type="submit" name="submit" value="Daftar sekarang!" class="form-btn" style="font-size: 90%; width: 95%;">
      <!-- <div style="text-align: center;">
         <hr style="display: inline-block; margin: -1px 10px 5px; width: 37%; border-top: 1px solid black;">
         <span style="display: inline-block;">OR</span>
         <hr style="display: inline-block; margin: -1px 10px 5px; width: 37%; border-top: 1px solid black;">
  </div>
      <div style="height: 50px; text-align: center;">
    <img src="../images/search.png" width="20" height="20" style="vertical-align: -7px; margin-right: 150px; margin-bottom: -16px;">
   <button onclick="window.location = '<?php echo $login_url; ?>'" type="button" class="form-btn" style="padding: 10px 30px; color: blue; border: 1px solid lightblue; float: left; margin-top: -14px; background-color: transparent; font-size: 70%; width: 100%; border-radius: 5px;">Login dengan Google</button>
  </div> -->
      <p style="font-size: 90%;">Sudah memiliki akun? <a href="index.php">Login sekarang!</a></p>
   </form>
</div>
<footer style="text-align: center;">
   <h5 style="font-size: 18px;">CopyRight &COPY; By <span style="color:red;">Achmad Tirto Sudiro</span></h5>
</footer>
</body>
</html>