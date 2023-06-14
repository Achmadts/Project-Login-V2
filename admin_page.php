<?php
session_start();
require_once 'connect.php';
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");
check_admin_login();

// PAGINATION
$limit = 3;
$page = isset($_GET['halaman']) ? (int) $_GET['halaman'] : 1;
if (!is_numeric($page)) {
   header("Location: " . $_SERVER['PHP_SELF'] . "?halaman=1");
   exit();
}
// Alihkan ke halaman 1 saat nomor halaman kurang dari 1
if($page < 1) {
   header("Location: " . $_SERVER['PHP_SELF'] . "?halaman=1");
   exit();
}

// SEARCH
if(isset($_POST['search'])){
   $search = $_POST['name'];
   $search_value = '%' . $search . '%';
   $sql = "SELECT COUNT(*) AS total FROM `user_form` WHERE `name` LIKE ? OR `id` LIKE ? OR `email` LIKE ?";
   $stmt = mysqli_prepare($con, $sql);
   mysqli_stmt_bind_param($stmt, "sss", $search_value, $search_value, $search_value);
   mysqli_stmt_execute($stmt);
   $result = mysqli_stmt_get_result($stmt);
   $row = mysqli_fetch_assoc($result);
   $total = $row['total'];

   if ($total > 0) {
      $last_page = ceil($total / $limit);
      $page = ($page > $last_page) ? $last_page : $page;

      $sql = "SELECT * FROM `user_form` WHERE `name` LIKE ? OR `id` LIKE ? OR `email` LIKE ? LIMIT " . ($page - 1) * $limit . ", " . $limit;
      $stmt = mysqli_prepare($con, $sql);
      mysqli_stmt_bind_param($stmt, "sss", $search_value, $search_value, $search_value);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

   } else {
      echo '<div class="error-message">Pengguna tidak ditemukan!</div>';
   }
} else {
   $sql = "SELECT COUNT(*) AS total FROM `user_form`";
   $result = mysqli_query($con, $sql);
   $row = mysqli_fetch_assoc($result);
   $total = $row['total'];

   $last_page = ceil($total / $limit);
   $page = ($page > $last_page) ? $last_page : $page;

   $sql = "SELECT * FROM `user_form` LIMIT " . ($page - 1) * $limit . ", " . $limit;
   $result = mysqli_query($con, $sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Halaman Admin</title>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
   <link rel="stylesheet" href="admin.css">
</head>
<body>
<style>
    .error-message {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 50px;
        color: red;
        font-size: 1.2rem;
        font-style: italic;
       font-weight: 500;
       background-color: black;
    }
</style>

<div class="container">
<div class="content">
      <h3>Hai, <span style="color: blue;">Admin</span></h3>
      <h1>Selamat Datang <span><?php echo $_SESSION['admin_name']; ?></span></h1>
      <button class="btn btn-primary"><a href="add.php" class="text-light"> Tambah User <i class="bi bi-person-plus"></i></a></button>
         <button class="btn btn-danger" onclick="return confirm(`Yakin banh mau logout?`)"><a href="admin_logout.php" class="text-light"> Logout <i class="bi bi-box-arrow-right"></i></a></button>
         <div class="container">
         <form method="POST">
            <div class="form-group">
               <label for="name">Cari Pengguna:</label>
               <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama atau id atau email" autocomplete="off">
            </div>
            <button type="submit" class="btn btn-primary" name="search"> Cari <i class="bi bi-search"></i></button>
         </form>
         <?php
         if(isset($_POST['submit'])) {
       
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $password);
    $stmt->execute();

   }
if(isset($_POST['login'])) {
// ...
if(password_verify($_POST['password'], $row['password'])) {
// Password benar, lakukan login
} else {
// Password salah, tampilkan pesan error
}
}
?>
<div class="table-responsive">
<table class="table-light table table-bordered table-hover">
<thead class="table-success">
<tr>
<th scope="col">No</th>
<th scope="col">ID</th>
<th scope="col">Nama</th>
<th scope="col">Email</th>
<th scope="col">User_type</th>
<th scope="col">Action</th>
</tr>
</thead>
<tbody>
         <?php
            $i = ($page - 1) * $limit;
               if($result){
                  while($row = mysqli_fetch_assoc($result)){
                     $i++;
                     $id = $row['id'];
                     if(is_numeric($id)){
                        $name = $row['name'];
                        $email = $row['email'];
                        $pass = $row['password'];
                        $user_type = $row['user_type'];
                        echo '<tr>
                        <td>'. $i.'</td>
                        <th scope="row">'.$id.'</th>
                        <td>'.$name.'</td>
                        <td>'.$email.'</td>
                        
                        <td>'.$user_type.'</td>
                        <td>
                        <button class="btn btn-primary"><a href="update.php?updateid='.$id.'" class="text-light"> Edit <i class="bi bi-pencil-square"></i></a></button>
                        <button class="btn btn-danger" onclick="return confirm(`Yakin mau hapus data ini?`)"><a href="delete.php?deleteid='.$id.'" class="text-light"> Delete <i class="bi bi-trash"></i></a></button>
                        </td>
                        </tr>';
                     }
                  }
               }
            ?>
</tbody>
</table>
<?php 
// Display pagination link
if(isset($_POST['search'])) {
    $search = $_POST['name'];
    $sql = "SELECT COUNT(*) FROM `user_form` WHERE `name` LIKE ? OR `id` LIKE ? OR `email` LIKE ?";
    $stmt = mysqli_prepare($con, $sql);
    $search_value = '%' . $search . '%';
    mysqli_stmt_bind_param($stmt, "sss", $search_value, $search_value, $search_value);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_row($result);
    $total_records = $row[0];
} else {
    $sql = "SELECT COUNT(*) FROM `user_form`";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_row($result);
    $total_records = $row[0];
}

$records_per_page = 3;
$total_pages = ceil($total_records / $records_per_page);

if(isset($_GET['halaman']) && is_numeric($_GET['halaman'])) {
    $page = $_GET['halaman'];
    if($page > $total_pages) {
        $page = $total_pages;
    }
} else {
    $page = 1;
}

$offset = ($page - 1) * $records_per_page;

$pagination_query = "SELECT * FROM `user_form`";

if(isset($_POST['search'])) {
    $search = $_POST['name'];
    $pagination_query .= " WHERE `name` LIKE ? OR `id` LIKE ? OR `email` LIKE ?";
}

$pagination_query .= " LIMIT ?, ?";

$stmt = mysqli_prepare($con, $pagination_query);

if(isset($_POST['search'])) {
    mysqli_stmt_bind_param($stmt, "sssss", $search_value, $search_value, $search_value, $offset, $records_per_page);
} else {
    mysqli_stmt_bind_param($stmt, "ss", $offset, $records_per_page);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <?php if($page > 1) { ?>
            <li class="page-item"><a class="page-link" href="?halaman=<?php echo $page-1 ?>">Previous &laquo;</a></li>
        <?php } ?>
        <?php for($i = 1; $i <= $total_pages; $i++) { ?>
            <li class="page-item <?php if($page == $i) { echo 'active'; } ?>"><a class="page-link" href="?halaman=<?php echo $i ?>"><?php echo $i ?></a></li>
        <?php } ?>
        <?php if($page < $total_pages) { ?>
            <li class="page-item"><a class="page-link" href="?halaman=<?php echo $page+1 ?>">Next &raquo;</a></li>
        <?php } ?>
    </ul>
</nav>
<center>
<footer style="margin-top: 11.5%;">
   <h5>COPYRIGHT &COPY; By 2023
      <span style="color: red;">Achmad Tirto Sudiro</span>
   </h5>
</footer>
</center>
  </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
      </body>
   </div>
</div>
      </body>
</html>