<?php
session_start();
require_once 'config.php';
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");

// Jika tombol submit di klik
if(isset($_POST['submit'])) {
   // Mengecek apakah form login diisi dengan benar
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $password = $_POST['password'];

   if(!empty($email) && !empty($password)) {
      $email = filter_var($email, FILTER_SANITIZE_EMAIL); // Filter email
      $password = filter_var($password, FILTER_SANITIZE_STRING); // Filter password

      $select = "SELECT * FROM user_form WHERE email = '$email' ";
      $result = mysqli_query($conn, $select);

      if(mysqli_num_rows($result) > 0) {
         $row = mysqli_fetch_array($result);

         if(password_verify($password, $row['password'])) {
            if($row['user_type'] == 'user') {
               $_SESSION["user_name"] = $row['name'];

               // Jika checkbox remember me di-check, set cookie
               if(isset($_POST['remember']) && $_POST['remember'] == 'on') {
                  $email_cookie = mysqli_real_escape_string($conn, $email);
                  $password_cookie = mysqli_real_escape_string($conn, $password);

                  setcookie('email', $email_cookie, time() + (86400 * 30), "/");
                  setcookie('password', $password_cookie, time() + (86400 * 30), "/");
               }else{
               // Menghapus cookie jika remember me tidak diaktifkan atau tidak ada session remember
               if (!isset($_SESSION["remember"]) || $_SESSION["remember"] !== true) {
                  setcookie('password', '', time() - 3600, "/");
                  setcookie('email', '', time() - 3600, "/");
            }
               }

               header('location:user_page.php');
               exit();
            }
            $error = 'Email belum terdaftar!';
         } else {
            $error = 'Password salah!';
         }
      } else {
         $error = 'Email salah atau belum terdaftar!';
      }
   } else {
      $error = 'Email dan password harus diisi!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Halaman Login User</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-container">

   <form action="" method="post" style="max-width: 85%;">
      <h3 style="font-size: 150%;">User Login</h3>
      <?php
      if(isset($error)){
         echo '<span class="error-msg">'.$error.'</span>';
      }
      ?>
      <input type="email" name="email" required placeholder="Masukkan email kamu" autocomplete="off" value="<?php if(isset($_COOKIE['email'])) { echo htmlspecialchars($_COOKIE['email']); } ?>" style="font-size: 80%;">
      <input type="password" name="password" required placeholder="Masukkan password kamu" autocomplete="off" value="<?php if(isset($_COOKIE['password'])) { echo htmlspecialchars($_COOKIE['password']); } ?>" style="font-size: 80%;">
      <div style="text-align: left;">
         <label style="user-select: none;"><input type="checkbox" id="show-password" style="align-items: left; width: auto;"> Show Password</label>
      </div>
      <div style="text-align: left;">
         <label style="font-size: 100%; user-select: none;"><input type="checkbox" name="remember" value="on" style="align-items: left; width: auto; margin-top: auto;" <?php if(isset($_COOKIE['email'])) { echo "checked"; } ?>> Remember me</label>
      </div>
      <input type="submit" name="submit" value="Login!" class="form-btn" style="font-size: 100%; margin-top: 10px;">
      </p>
      <p style="font-size: 100%; margin-top: -10px;">Belum punya akun? <a href="register_form.php">Daftar Sekarang!</a></p>
   </form>
</div>
<footer style="text-align: center;">
   <h5 style="font-size: 18px;">CopyRight &COPY; By <span style="color:red;">Achmad Tirto Sudiro</span></h5>
</footer>
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