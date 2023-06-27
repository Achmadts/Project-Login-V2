<?php
session_start();
require_once 'config.php';
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");

if(isset($_SESSION['admin_name'])){
   header('Location: ../admin_php/admin_login.php');
   exit;
}

if(isset($_SESSION["user_name"])){
   header('Location: user_page.php');
   exit;
}

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
               if(isset($_POST['remember-me']) && $_POST['remember-me'] == 'on') {
                  $email_cookie = mysqli_real_escape_string($conn, $email);
                  $password_cookie = mysqli_real_escape_string($conn, $password);

                  setcookie('email', $email_cookie, time() + (86400 * 30), "/");
                  setcookie('password', $password_cookie, time() + (86400 * 30), "/");
               }else{
               // Menghapus cookie jika remember me tidak diaktifkan atau tidak ada session remember
               if (!isset($_SESSION["remember-me"]) || $_SESSION["remember-me"] !== true) {
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
   <link rel="stylesheet" href=" ../css/style.css">
   <title>Login Form</title>
</head>
<body>

<div class="form-container" style="user-select: none">

   <form action="" method="post" style="max-width: 100%;">
      <h3 style="font-size: 130%;">Login Form</h3>
      <?php
      if(isset($error)){
         echo '<span class="error-msg" style="font-size: 90%;">'.$error.'</span>';
      }
      ?>
      <input type="email" name="email" required placeholder="Masukkan email kamu" autocomplete="off" value="<?php if(isset($_COOKIE['email'])) { echo htmlspecialchars($_COOKIE['email']); } ?>" style="font-size: 80%;">
      <input type="password" name="password" required placeholder="Masukkan password kamu" autocomplete="off" value="<?php if(isset($_COOKIE['password'])) { echo htmlspecialchars($_COOKIE['password']); } ?>" style="font-size: 80%;">
      <div style="text-align: left; justify-content: space-between; display: flex;">
         <label style="user-select: none; font-size: 85%;"><input type="checkbox" id="show-password" style="align-items: left; width: auto;"> Show Password</label>
         <a href="user_lupa_password.php" style="font-size: 80%; text-decoration: none; color: #ff4d05;">Lupa Password?</a>
      </div>
      <div style="text-align: left;">
         <label style="font-size: 85%; user-select: none;"><input type="checkbox" name="remember-me" value="on" style="align-items: left; width: auto; margin-top: auto;" <?php if(isset($_COOKIE['email'])) { echo "checked"; } ?>> Remember me</label>
      </div>
      <input type="submit" name="submit" value="Login!" class="form-btn" style="font-size: 90%; margin-top: 10px;">
      </p>
      <!-- <div style="text-align: center;">
         <hr style="display: inline-block; margin: -1px 10px 5px; width: 37%; border-top: 1px solid black;">
         <span style="display: inline-block;">OR</span>
         <hr style="display: inline-block; margin: -1px 10px 5px; width: 37%; border-top: 1px solid black;">
  </div>
      <br>
   <div style="height: 50px; text-align: center;">
      <img src="../images/search.png" width="20" height="20" style="vertical-align: -7px; margin-right: 150px; margin-bottom: -16px;">
      <button onclick="window.location = '<?php echo $login_url; ?>'" type="button" class="form-btn" style="padding: 10px 30px; color: blue; border: 1px solid lightblue; float: left; margin-top: -14px; background-color: transparent; font-size: 70%; width: 100%; border-radius: 5px;">Login dengan Google</button>
  </div> -->
      <p style="font-size: 90%; margin-top: -5px;">Belum punya akun? <a href="register_form.php">Daftar Sekarang!</a></p>
   </form>
</div>
<footer style="text-align: center;">
   <h5 style="font-size: 80%;">CopyRight &COPY; By <span style="color:red;">Achmad Tirto Sudiro</span></h5>
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