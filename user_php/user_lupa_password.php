<?php
require_once 'config.php';
require_once '../mail.php';
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");
session_start();

if (!isset($_SESSION['timer'])) {
   unset($_SESSION['timer']);
}

$error = array();
   $mode = "enter_email";
   if(isset($_GET['mode'])){
      $mode = $_GET['mode'];
   }

   if(count($_POST) > 0 ){

      switch ($mode) {
         case 'enter_email':
            # code...
            $email = $_POST['email'];
            // validasi email
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
               $error[] = "Tolong Masukkan email yang valid!";
            }elseif(!valid_email($email)){
               $error[] = "Email tidak ditemukan!";
            }else{
               $_SESSION['forgot']['email'] = $email;
               send_email($email);
               header("Location: user_lupa_password.php?mode=enter_code");
               die;
            }
            break;
         
         case 'enter_code':
            # code...
            $code = $_POST['code'];
            $result = is_code_correct($code);

            if($result == "Kode benar!"){
               $_SESSION['forgot']['code'] = $code;
               $_SESSION['timer'] = time() + 58; // Menambahkan timer 1 menit (60 detik)
               header('Location: user_lupa_password.php?mode=enter_password');
               die;
            }else{
               $error[] = $result;
            }
            break;
         
         case 'enter_password':
            # code...
            $pass = $_POST['password'];
            $cpass = $_POST['cpassword'];
            // echo "disini";
            if($pass !== $cpass){
               $error[] = "Password dan Konfirmasi Password tidak sesuai!";
            }elseif(!isset($_SESSION['forgot']['email']) && !isset($_SESSION['forgot']['code'])){
               header('Location: user_lupa_password.php');
               die;
            }else{
               save_password($pass);
               if(isset($_SESSION['forgot'])){
                  unset($_SESSION['forgot']);
               }
               echo '<script>alert("Password berhasil diubah!"); window.location.href = "index.php";</script>';
               die;
            }
            break;
         
         default:
            # code...
            break;
      }
   }
// Memeriksa apakah timer telah habis atau belum
if (isset($_SESSION['timer']) && $_SESSION['timer'] <= time()) {
   unset($_SESSION['timer']); // Menghapus timer dari session jika waktu sudah habis
   // $error[] = "Waktu telah habis! Silakan kirim ulang kode verifikasi.";
} elseif (!isset($_SESSION['timer'])) {
   $_SESSION['timer'] = time() + 58; // Menambahkan timer 1 menit (60 detik)
}
   function send_email($email){
      global $conn;
      $expire = time() + (60 * 1);
      $code = rand(10000,99999);
      $email = addslashes($email);

      $query = "INSERT INTO codes (email,code,expire) VALUE ('$email','$code','$expire')";
      mysqli_query($conn,$query);

      // kirim email disini
      send_mail($email,'Reset Password', "Kode kamu adalah " . $code);
   }
   function save_password($pass){
      global $conn;
      $pass = password_hash($pass, PASSWORD_DEFAULT);
      $email = addslashes($_SESSION['forgot']['email']);

      $query = "UPDATE user_form SET password = '$pass' WHERE email = '$email' LIMIT 1";
      mysqli_query($conn,$query);
   }
   function valid_email($email){
      global $conn;
      $email = addslashes($email);

      $query = "SELECT * FROM user_form WHERE email = '$email' LIMIT 1";
      $result = mysqli_query($conn,$query);
      if($result){
         if(mysqli_num_rows($result) > 0)
         {
            return true;
         }
      }
   return false;
}

   function is_code_correct($code){
      global $conn;
      $code = addslashes($code);
      $expire = time();
      $email = addslashes($_SESSION['forgot']['email']);

      $query = "SELECT * FROM codes WHERE code = '$code' && email = '$email' ORDER BY 1";
      $result = mysqli_query($conn,$query);
      if($result){
         if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            if($row['expire'] > $expire){
               return 'Kode benar!';
         }else{
            return "Kode sudah kadaluarsa!";
         }
      }else{
         return "Kode salah!";
      }
   }
      return "Kode salah!";
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Reset Password</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="form-container" style="user-select: none">

<script>
// Fungsi untuk memulai timer 1 menit
function startTimer() {
    var countdown = <?php echo isset($_SESSION['timer']) ? $_SESSION['timer'] - time() : 58; ?>;
    var timerDisplay = document.getElementById("timer");

    var timer = setInterval(function() {
        if (countdown <= 0) {
            clearInterval(timer);
            // Lakukan sesuatu ketika timer habis
            timerDisplay.textContent = "Waktu Habis";
        } else {
            timerDisplay.textContent = countdown + " detik";
            countdown--;
        }
    }, 1000);
}
// Memanggil fungsi startTimer saat halaman dimuat
window.onload = startTimer;
</script>

<?php
      
      switch ($mode) {
         case 'enter_email':
            # code...
            ?>
               <form action="user_lupa_password.php?mode=enter_email" method="post" style="max-width: 100%;">
                  <h3 style="font-size: 130%;">Reset Password</h3>
                  <h5>Masukkan Email kamu</h5>
                  <?php
                  foreach ($error as $err) {
                     # code...
                     echo '<span style="margin: 10px auto; display: block; overflow: hidden; background: #ff4d05; color: #fff; border-radius: 5px; font-size: 15px; padding: 10px;">';
                     echo $err . "<br>";
                  }
                  ?>
                  </span>
                  <input type="email" name="email" required placeholder="Masukkan email kamu" autocomplete="off" value="<?php if(isset($_COOKIE['email'])) { echo htmlspecialchars($_COOKIE['email']); } ?>" style="font-size: 80%;">
                  <input type="submit" name="submit" value="Next" class="form-btn" style="font-size: 90%; margin-top: 10px;">
                  </p>
                  <p style="font-size: 90%; margin-top: -10px;">Login <a href="index.php">Sekarang!</a></p>
               </form>
            <?php
            break;
         
         case 'enter_code':
            # code...
            ?>
            <form action="user_lupa_password.php?mode=enter_code" method="post" style="max-width: 100%;">
               <h3 style="font-size: 130%;">Reset Password</h3>
               <h5>Masukkan kode OTP 5 digit yang sudah dikirimkan ke <?php echo $_SESSION['forgot']['email']; ?></h5>
                  <?php
                  foreach ($error as $err) {
                     # code...
                     echo '<span style="margin: 10px auto; display: block; overflow: hidden; background: #ff4d05; color: #fff; border-radius: 5px; font-size: 90%; padding: 10px;">';
                     echo $err . "<br>";
                  }
                  ?>
                  </span>

               <input type="text" name="code" required placeholder="Masukkan kode verivikasi" autocomplete="off" style="font-size: 80%;">

            <div style="text-align: right; display: block; margin-top: -5px; margin-bottom: -5px;">
               <span id="timer" style="font-size: 90%;"></span>
            </div>

               <input type="submit" name="submit" value="Next" class="form-btn" style="font-size: 90%; margin-top: 10px;">
               <a href="user_lupa_password.php">
                  <input type="button" name="submit" value="Mulai lagi" class="form-btn" style="font-size: 90%; margin-top: 10px;">
               </a>
               </p>
               <p style="font-size: 90%; margin-top: -10px;">Login <a href="index.php">Sekarang!</a></p>
            </form>
         <?php
            break;
         
         case 'enter_password':
            # code...
            ?>
            <form action="user_lupa_password.php?mode=enter_password" method="post" style="max-width: 100%;">
               <h3 style="font-size: 130%;">Reset Password</h3>
               <h5>Masukkan Password baru</h5>
                  <?php
                  foreach ($error as $err) {
                     # code...
                     echo '<span style="margin: 10px auto; display: block; overflow: hidden; background: #ff4d05; color: #fff; border-radius: 5px; font-size: 90%; padding: 10px;">';
                     echo $err . "<br>";
                  }
                  ?>
                  </span>

               <input type="password" name="password" required placeholder="Masukkan Password baru" autocomplete="off" style="font-size: 80%;">
               <input type="password" name="cpassword" required placeholder="Konfirmasi Password baru" autocomplete="off" style="font-size: 80%;">
            <div style="text-align: left; justify-content: space-between; display: flex;">
               <label style="user-select: none; font-size: 90%;"><input type="checkbox" id="show-password" style="align-items: left; width: auto;"> Show Password</label>
            </div>
               <input type="submit" name="submit" value="Next" class="form-btn" style="font-size: 90%; margin-top: 10px;">
               <a href="user_lupa_password.php">
                  <input type="button" name="submit" value="Mulai lagi" class="form-btn" style="font-size: 90%; margin-top: 10px;">
               </a>
               </p>
               <p style="font-size: 90%; margin-top: -10px;">Login <a href="index.php">Sekarang!</a></p>
            </form>
         <?php
            break;
         
         default:
            # code...
            break;
      }
      
   ?>
</div>
<footer style="text-align: center;">
   <h5 style="font-size: 18px;">CopyRight &COPY; By <span style="color:red;">Achmad Tirto Sudiro</span></h5>
</footer>
<script>
const showPasswordCheckbox = document.getElementById('show-password');
const passwordInputs = document.querySelectorAll('input[type="password"]');

   showPasswordCheckbox.addEventListener('click', () => {
      passwordInputs.forEach(input => {
         if (showPasswordCheckbox.checked) {
            input.type = 'text';
         } else {
            input.type = 'password';
         }
      });
   });
</script>
</body>
</html>