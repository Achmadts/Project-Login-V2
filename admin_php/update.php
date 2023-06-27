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
$id = $_GET['updateid'];
if(!is_numeric($id)) {
   echo "Ngapain banh!!!";
   exit;
}
$sql = "SELECT * FROM `user_form` WHERE id=$id";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$name = $row['name'];
$email = $row['email'];
$user_type = $row['user_type'];
$pass = $row['password'];

if(isset($_POST['submit'])){
   $name = htmlspecialchars(mysqli_real_escape_string($con, $_POST['name']));
   $email = htmlspecialchars(mysqli_real_escape_string($con, $_POST['email']));
   $pass = $_POST['password'];
   $cpass = $_POST['cpassword'];
   $user_type = $_POST['user_type'];

   // Check if the entered email or name already exists in the database
   $check_sql = "SELECT * FROM `user_form` WHERE email='$email' OR name='$name'";
   $check_result = mysqli_query($con, $check_sql);
   $check_row = mysqli_fetch_assoc($check_result);

   if(mysqli_num_rows($check_result) > 0 && $check_row['id'] != $id){
      $error[] = 'Email atau nama sudah terdaftar!';
   } elseif($pass != $cpass){
      $error[] = 'Password dan konfirmasi password harus sama!';
   } else {
      $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
      $sql = "UPDATE `user_form` SET name='$name',email='$email',user_type='$user_type',password='$hashed_pass' WHERE id='$id'";

      $result = mysqli_query($con, $sql);
      if(mysqli_error($con)){
         echo mysqli_error($con);   
      } else {
         if ($result) {
            echo '<script>alert("Data user berhasil diperbarui."); window.location.href = "admin_page.php";</script>';
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
   <title>Halaman Update</title>
   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/update.css">
</head>
<body>
<div class="form-container">
   <form action="" method="post">
      <h3>Halaman Update</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="text" name="name" required placeholder="Masukkan nama kamu" autocomplete="off" value="<?php echo $name;?>">
      <input type="email" name="email" required placeholder="Masukkan email kamu" autocomplete="off" value="<?php echo $email;?>">
      <input type="password" name="password" required placeholder="Masukkan password kamu" value="<?php echo $pass;?>">
      <input type="password" name="cpassword" required placeholder="Konfirmasi password kamu" value="<?php echo $pass;?>">
      <select name="user_type">
         <option value="user">Pengguna</option>
         <option value="admin">Admin</option>
      </select>
      <input type="submit" name="submit" value="Update" class="form-btn">
   </form>
</div>
<footer style="text-align: center;">
   <h5 style="font-size: 18px;">CopyRight &COPY; By <span style="color:red;">Achmad Tirto Sudiro</span></h5>
</footer>
</body>
</html>