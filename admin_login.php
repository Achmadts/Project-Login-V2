<?php
session_start();
require_once 'connect.php';
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");

if(isset($_SESSION["admin_name"])){
   header('Location: admin_page.php');
   exit;
}

// Jika tombol submit di klik
if(isset($_POST['submit'])){
   $error = array();

   // Mengecek apakah form login diisi dengan benar
   $email = mysqli_real_escape_string($con, $_POST['email']);
   $password = $_POST['password'];

   if(!empty($email) && !empty($password)){
      $email = filter_var($email, FILTER_SANITIZE_EMAIL); // Filter email
      $password = filter_var($password, FILTER_SANITIZE_STRING); // Filter password

      $select = "SELECT * FROM user_form WHERE email = '$email' ";
      $result = mysqli_query($con, $select);

      if(mysqli_num_rows($result) > 0){
         $row = mysqli_fetch_array($result);

         if(password_verify($password, $row['password'])){
            if($row['user_type'] == 'admin'){
               $_SESSION["admin_name"] = $row['name'];

               // Jika checkbox remember me di-check, set cookie
               if(isset($_POST['remember']) && $_POST['remember'] == 'on'){
                  $email_cookie = mysqli_real_escape_string($con, $email);
                  $password_cookie = mysqli_real_escape_string($con, $password);

                  setcookie('email', $email_cookie, time() + (86400 * 30), "/");
                  setcookie('password', $password_cookie, time() + (86400 * 30), "/");
               }else{
               // Menghapus cookie jika remember me tidak diaktifkan atau tidak ada session remember
               if (!isset($_SESSION["remember"]) || $_SESSION["remember"] !== true) {
                  setcookie('password', '', time() - 3600, "/");
                  setcookie('email', '', time() - 3600, "/");
               }
            }
            
               header('location:admin_page.php');
               exit();
            }
            $error[] = 'Email belum terdaftar!';
         } else {
            $error[] = 'Password salah!';
         }
      } else {
         $error[] = 'Email salah atau belum terdaftar!';
      }
   } else {
      $error[] = 'Email dan password harus diisi!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
   <title>Halaman Login Admin</title>

   <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
   <form action="" method="post" style="max-width: 85%;">
      <h3 style="font-size: 150%;">Admin Login</h3>
      <?php
      if(isset($error)){
         foreach($error as $err){
            echo '<span class="error-msg">'.$err.'</span>';
         }
      }
      ?>
      <input type="email" name="email" required placeholder="Masukkan email kamu" autocomplete="off" value="<?php if(isset($_COOKIE['email'])) { echo htmlspecialchars($_COOKIE['email']); } ?>" style="font-size: 80%;">
      <input type="password" name="password" required placeholder="Masukkan password kamu" autocomplete="off" value="<?php if(isset($_COOKIE['password'])) { echo htmlspecialchars($_COOKIE['password']); } ?>" style="font-size: 80%;">
      <div style="text-align: left;">
         <label style="user-select: none; font-size: 90%;"><input type="checkbox" id="show-password" style="align-items: left; width: auto;"> Show Password</label>
      </div>
      <div style="text-align: left;">
         <label style="font-size: 100%; user-select: none; font-size: 90%;"><input type="checkbox" name="remember" value="on" style="align-items: left; width: auto; margin-top: auto;" <?php if(isset($_COOKIE['email'])) { echo "checked"; } ?>> Remember me</label>
      </div>
      <input type="submit" name="submit" value="Login!" class="form-btn" style="font-size: 100%; margin-top: 10px;">
      </p>
      <p style="font-size: 100%; margin-top: -10px;">Belum punya akun? <a href="admin_register.php">Daftar Sekarang!</a></p>
   </form>
</div>
<footer style="text-align: center;">
   <h5 style="font-size: 18px;">CopyRight &COPY; By <span style="color:red;">Achmad Tirto Sudiro</span></h5>
</footer>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script>
const showPasswordCheckbox = document.getElementById('show-password');
const passwordInput = document.getElementsByName('password')[0];

showPasswordCheckbox.addEventListener('click', () => {
   if (showPasswordCheckbox.checked) {
      passwordInput.type = 'text';
   } else {
      passwordInput.type = 'password';
   }
});
</script>
</body>
</html>