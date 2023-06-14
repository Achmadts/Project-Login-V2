<?php 
session_start();
require_once 'config.php';
require_once 'connect.php';
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");

if(!isset($_SESSION['login'])){
    header('location: login_form.php');   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achmad Tirto Sudiro</title>
    <!-- custom css link -->
    <link rel="stylesheet" type="text/css" href="styleek.css">

    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

</head>
<body>

    <!-- header design -->
    <header>
        <a href="#" class="logo" style="font-size: 150%; user-select: none;">Cod<span>e</span>r.</a>

        <ul class="navlist" style="user-select: none;">
        <li><a href="#home" class="active">Home</a></li>
        <li><a href="#about">About Me</a></li>
        <li><a href="#services">Skills</a></li>
        <li><a href="#portofolio">Portofolio</a></li>
        <li><a href="#contact">Contact Me</a></li>
    </ul>

    <div class="bx bx-menu" id="menu-icon">

    </div>
    </header>

    <!-- home section design -->
    <section class="home" id="home" style="user-select: none;">
        <div class="home-text">
            <div class="slide">
                <span class="one" style="margin-top: 100px; font-size: 80%;">Halo</span>
                <span class="two" style="font-size: 100%;">Nama saya</span>
            </div>
            <h1 style="font-size: 180%;">Achmad Tirto Sudiro</h1>
            <h3 style="font-size: 180%">Software<span> Engineering</span></h3>
            <p style="font-size: 100%;">Perkenalkan namaku Achmad Tirto Sudiro, biasa dipanggil Achmad, <br> kelas 10 jurusan Pengembangan Perangkat Lunak dan Gim (PPLG) di SMK Negeri 1 Karawang.</p>
            <div class="button">
                <!-- <a href="#" class="btn">Ucapkan Halo</a> -->
                <!-- <a href="https://youtu.be/jGyYuQf-GeE" class="btn2"><span><i class='bx bx-play'></i></span>Lihat Tips Program</a> -->
            </div>
        </div>
    </section>

        <!-- about section design -->
        <section class="about" id="about" style="user-select: none;">
            <div class="about-img">
                <img src="./images/img.fbachmad..jpg" style="width: 90%;">
            </div>

            <div class="about-text">
                <h2 style="font-size: 200%;">About<span> Me</span></h2>
                <h4 style="font-size: 100%;">Calon full stack <span style="color: #ff4d05;">Developer!</span></h4>
                <p style="font-size: 95%;">Namaku Achmad Tirto Sudiro, biasa dipanggil Achmad, aku lahir di kota Karawang pada tanggal 09 September 2006, saat ini aku menduduki bangku kelas 10 di SMKN 1 KARAWANG dan mengambil jurusan Pengembangan Perangkat Lunak dan Gim (PPLG), hobiku adalah bermain game dan coding. Aku menempuuh pendidikan dasar di SD Negeri Pancawati 2, selanjutnya aku melanjutkan pendidikan di SMP Negeri 3 Klari yang masih berada di wilayah Kabupaten Karawang, kemudian aku melanjutkan pendidikan selanjutnya di SMK Negeri 1 Karawang. Itulah sedikit kisah tentang saya. Terimakasih!</p>
                <!-- <a href="#" class="btn" style="font-size: 80%;"> More About</a> -->
            </div>
        </section>

    <!-- service section design -->
    <section class="services" id="services" style="user-select: none;">
        <div class="main-text">
            <p style="font-size: 80%;">What I am Expert In</p>
            <h2 style="font-size: 200%;"><span>Basic</span> Skills</h2>
        </div>

        <div class="services-content" style="text-align: center;">
            <div class="box" style="width: 80%; margin: 0 auto; height: 100%;">
                <div class="s-icons">
                    <i class='bx bx-mobile-alt'></i>
                </div>
                <h3>Web <span style="color: #ff4d05;">Design</span></h3>
                <p>Saya memiliki skill-skill dasar dalam mendesain sebuah website. Tetapi mungkin hasilnya tidak seperti Web Designer Profesional</p>
                <br><br>
                <!-- <a href="#" class="read">Read More</a> -->
            </div>

            <div class="box" style="width: 80%; margin: 0 auto; height: 100%;">
                <div class="s-icons">
                    <i class='bx bx-code-alt'></i>
                </div>
                <h3>Web <span style="color: #ff4d05;">Development</span></h3>
                <p>Saya juga adalah seorang Web Developer pemula, saya juga sudah membuat beberapa Web Application dan satu Desktop Application yang sedang saya kerjakan.</p>
                <!-- <a href="#" class="read">Read More</a> -->
            </div>

            <div class="box" style="width: 80%; margin: 0 auto; height: 100%;">
                <div class="s-icons">
                    <i class='bx bx-edit-alt'></i>
                </div>
                <h3>Creative <span style="color: #ff4d05;">Design</span></h3>
                <p>Saya juga sedang berusaha agar menjadi Designer yang adaptif, kreatif dan inovatif agar suatu saat bisa menjadi Designer yang Propesional.</p>
                <br><br>
                <!-- <a href="#" class="read">Read More</a> -->
            </div>        
        </div>
    </section>

    <!-- portofolio section design -->
    <section class="portofolio" id="portofolio" style="user-select: none;">
        <div class="main-text">
            <p style="font-size: 80%;">Portofolio</p>
            <h2 style="font-size: 200%;">Latest <span>Project</span></h2>
        </div>

        <div class="portofolio-content">
            <div class="row" style="width: 80%; margin: 0 auto;">
                <img src="images/portfolio/portofolio1.png" style="width: 300px; height: 200px;">
                <div class="layer">
                    <h5 style="font-size: 85%;">Halaman Registrasi</h5>
                    <p style="font-size: 75%;">Halaman Registrasi ini dibuat dengan bahasa pemrograman PHP dengan Database MySQL</p>
                    <a href="#"><i class='bx bx-link-external'></i></a>
                </div>
            </div>

            <div class="row" style="width: 80%; margin: 0 auto;">
                <img src="images/portfolio/portofolio2.png" style="width: 300px; height: 200px;">
                <div class="layer">
                    <h5 style="font-size: 85%;">Halaman Login</h5>
                    <p style="font-size: 75%;">Halaman Login ini dibuat dengan bahasa pemrograman PHP dengan Database MySQL</p>
                    <a href="#"><i class='bx bx-link-external'></i></a>
                </div>
            </div>

            <div class="row" style="width: 80%; margin: 0 auto;">
                <img src="images/portfolio/portofolio3.png" style="width: 300px; height: 200px;">
                <div class="layer">
                    <h5 style="font-size: 85%;">Movie Database</h5>
                    <p style="font-size: 75%;">Web ini dibuat dengan JavaScript dan menggunakan API dari OMDb API</p>
                    <a href="#"><i class='bx bx-link-external'></i></a>
                </div>
            </div>

            <div class="row" style="width: 80%; margin: 0 auto;">
                <img src="images/portfolio/portofolio4.png" style="width: 300px; height: 200px;">
                <div class="layer">
                    <h5 style="font-size: 85%;">To Do List</h5>
                    <p style="font-size: 75%;">Web To Do List ini dibuat dengan bahasa Pemrograman JavaScript. Ini project iseng.</p>
                    <a href="#"><i class='bx bx-link-external'></i></a>
                </div>
            </div>

            <div class="row" style="width: 80%; margin: 0 auto;">
                <img src="images/portfolio/portofolio5.png" style="width: 300px; height: 200px;">
                <div class="layer">
                    <h5 style="font-size: 85%;">Aplikasi kasir</h5>
                    <p style="font-size: 75%;">Desktop App Cashier 1.0 ini dibuat dengan bahasa Pemrograman JavaScript</p>
                    <a href="#"><i class='bx bx-link-external'></i></a>
                </div>
            </div>

            <div class="row" style="width: 80%; margin: 0 auto;">
                <img src="images/portfolio/portofolio6.png" style="width: 300px; height: 200px;">
                <div class="layer">
                    <h5 style="font-size: 85%;">Web Edukasi</h5>
                    <p style="font-size: 75%;">Web Edukasi ini dibuat dengan HTML, CSS, dan JavaScript. Ini adalah project akhir kelas 10</p>
                    <a href="#"><i class='bx bx-link-external'></i></a>
                </div>
            </div>

        </div>
    </section>

    <!-- contact section design -->
    <section class="contact" id="contact" style="user-select: none;">
        <div class="contact-text">
            <h2 style="font-size: 200%;">Contact<span> Me!</span></h2>
            <h4 style="font-size: 80%;">Jika anda ingin menghubungi saya silahkan pilih metode untuk menghubungi saya dibawah ini.</h4>
            <p style="font-size: small;">Saya adalah seorang siswa kelas 10 jurusan RPL (Rekayasa Perangkat Lunak).</p>
            <div class="list">
                <li><a href="https://api.whatsapp.com/send?phone=62895320316384">0895320316384</a></li>
                <li><a href="mailto:achmadtirtosudirosudiro@gmail.com">achmadtirtosudirosudiro@gmail.com</a></li>
                <li><a href="https://youtube.com/@gamersuka_suka">Like Share & Subscribe</a></li>
            </div>

            <div class="contact-icons">
                <a href="https://www.facebook.com/achmadtirto.sudiro?mibextid=ZbWKwL"><i class='bx bxl-facebook'></i></a>
                <a href="https://www.instagram.com/achmadtirtosudiro"><i class='bx bxl-instagram-alt'></i></a>
                <a href="https://api.whatsapp.com/send?phone=62895320316384"><i class='bx bxl-whatsapp'></i></a>
                <a href="https://youtube.com/@gamersuka_suka"><i class='bx bxl-youtube'></i></a>
            </div>
        </div>

        <div class="contact-form" style="width: 90%;">
            <form action="">
                <input type="name" placeholder="Nama kamu" required>
                <input type="email" placeholder="Alamat Email kamu" required>
                <input type="" placeholder="Nomor telepon kamu" required>
                <textarea name="" id="" cols="35" rows="10" placeholder="Apa yang bisa saya bantu" required></textarea>
                <a href="mailto:achmadtirtosudirosudiro@gmail.com"><input type="submit" value="Comming soon!" class="submit" required style="font-size: 80%; max-width: fit-content;"></a>
            </form>
        </div>
    </section>

    <!-- end section design -->
    <section class="end" style="user-select: none;">
        <div class="last-text">
            <h4>Copyright &COPY; 2023 by <span style="color: red;">Achmad Tirto Sudiro</span></h4>
        </div>
        <div class="top">
            <a href="#home"><i class='bx bx-up-arrow-alt'></i></a>
            <a href="logout.php" onclick="return confirm(`Yakin mau logout?`)"><i class='bx bx-log-out'></i></a>
        </div>
    </section>

    <!-- custom js link -->
    <script type="text/javascript" src="script.js"></script>
</body>
</html>