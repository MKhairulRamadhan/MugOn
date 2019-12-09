<?php
// dimulainya sesi
session_start();
if (isset($_SESSION['keranjang']) || (!empty($_SESSION['keranjang']))) {
    $banyak = count($_SESSION['keranjang']);
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>MugOn | Metode</title>
    <meta charset="UTF-8">
    <meta name="description" content=" Divisima | eCommerce Template">
    <meta name="keywords" content="divisima, eCommerce, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link href="img/logo.png" rel="shortcut icon" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,300i,400,400i,700,700i" rel="stylesheet">


    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/flaticon.css" />
    <link rel="stylesheet" href="css/slicknav.min.css" />
    <link rel="stylesheet" href="css/jquery-ui.min.css" />
    <link rel="stylesheet" href="css/owl.carousel.min.css" />
    <link rel="stylesheet" href="css/animate.css" />
    <link rel="stylesheet" href="css/style.css" />

    <!-- Bagian CSS -->
    <style>
        /* Css untuk bagian pengenalan aplikasi */
        body {
            /* background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0. 6)), url(photo.jpg); */
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            color: orangered;
        }

        .service {
            margin: 90px auto;
            text-align: center;
        }

        h1 {
            font-family: sans-serif;
            letter-spacing: 1px;
        }

        h1:after {
            contain: '';
            background: blue;
            display: block;
            width: 150px;
            height: 3px;
            margin: 10px auto;
        }

        /* akhir Css untuk bagian pengenalan aplikasi */

        /* css untuk our team */
        * {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }

        .team-section {
            overflow: hidden;
            text-align: center;
            background: #34495e;
            padding: 60px;
        }

        .team-section {
            text-transform: uppercase;
            margin-bottom: 60px;
            color: white;
            font-size: 40px;
        }

        .border {
            display: block;
            margin: auto;
            width: 160px;
            height: 3px;
            background: #3498db;
            margin-bottom: 40px;
        }

        .ps {
            margin-bottom: 40px;
        }

        .ps a {
            display: inline-block;
            margin: 30px;
            width: 160px;
            height: 160px;
            overflow: hidden;
            border-radius: 50%;
        }

        .ps a img {
            width: 100%;
            filter: grayscale(100%);
            transition: 0.4s all;
        }

        .ps a:hover>img {
            filter: none;
        }

        .section {
            width: 600px;
            margin: auto;
            font-size: 20px;
            color: white;
            text-align: justify;
            height: 0;
            overflow: hidden;
        }

        .section:target {
            height: auto;

        }

        .name {
            display: block;
            margin-bottom: 30px;
            text-align: center;
            text-transform: uppercase;
            font-size: 22px;
        }

        .services h1 {
            color: burlywood;
        }

        /* Akhir css our team */
    </style>
    <!-- akhir css -->
</head>

<body>
    <!-- tampilan loading -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- bagian atas/kepala -->
    <header class="header-section">
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 text-center text-lg-left">
                        <!-- logo -->
                        <a href="index.php" class="site-logo">
                            <img src="img/logo.png" alt="">
                        </a>
                    </div>
                    <div class="col-lg-3">
                    </div>
                    <div class="col-lg-4">
                        <div class="user-panel">
                            <div class="up-item">
                                <i class="flaticon-profile" style="color:black;"></i>
                                <?php if (isset($_SESSION['pembeli'])) { ?>
                                    <a href="profil.php"><?php echo $_SESSION['pembeli']['nama_pembeli']; ?></a>
                                <?php } else { ?>
                                    <a href="login.php">Login</a><a href="#" style="color:black;"> atau </a><a href="daftar.php">Daftar</a>
                                <?php } ?>
                            </div>
                            <div class="up-item">
                                <div class="shopping-card">
                                    <i class="flaticon-bag" style="color:black;"></i>
                                    <span>
                                        <?php if (isset($_SESSION['keranjang']) || (!empty($_SESSION['keranjang']))) {
                                            echo $banyak;
                                        } else {
                                            echo '0';
                                        } ?>
                                    </span>

                                </div>
                                <a href="keranjang.php">Keranjang Belanja</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <form class="form-inline mr-auto" method="post" action="">
                            <input class="form-control mr-sm-2" name="cari" type="text" placeholder="Cari Ikan" aria-label="Search">
                            <button class="btn btn-outline-secondary btn-rounded my-0" name="search" type="submit">Cari</button>
                        </form>
                    </div>
                    <!-- ini fungsi untuk mencari ikan -->
                    <?php
                    if (isset($_POST['cari'])) {
                        $koneksi = new mysqli("localhost", "root", "", "mugon");
                        $ambil = $koneksi->query("SELECT id_ikan FROM ikan WHERE nama_ikan LIKE '%$_POST[cari]%' ");
                        $pecah = $ambil->fetch_assoc();
                        if (!empty($pecah)) {
                            echo "<script>location='detail_ikan.php?id=" . $pecah['id_ikan'] . "'</script>";
                        } else {
                            echo "<script>alert('Ikan yang anda cari tidak ada !!');</script>";
                        }
                    }
                    ?>

                </div>
            </div>
        </div>
        <nav class="main-navbar text-center">
            <div class="container">
                <!-- bagian menu/ navigasi -->
                <ul class="main-menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="riwayat.php">Riwayat</a></li>
                    <li><a href="tentang.php">MungOn?</a></li>
                    <li><a href="metode.php">Metode Transaksi</a></li>
                    <li><a href="kontak.php">Kontak</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- akhir bagian dari kepala/atas -->

    <div class="container text-center">
        <div class="services mt-5 mb-3">
            <h1>Metode Transaksi</h1>
        </div>
        <div class="row text-center">
            <div class="col-md-3 text-center">
                <h3>Masuk Aplikasi MugOn</h3>
                <p class="text-justify mt-2">User melakukan Login kedalam aplikasi untuk melihat ikan yang tersedia</p>
            </div>
            <div class="col-md-3 text-center">
                <h3>Memilih Ikan yang Tersedia</h3>
                <p class="text-justify mt-2">User memilih ikan yang tersedia untuk dibeli </p>
            </div>
            <div class="col-md-3 text-center">
                <h3>Melakukan checkout</h3>
                <p class="text-justify mt-2">Setelah memilih ikan yang dibeli maka User melakukan checkout</p>
            </div>
            <div class="col-md-3 text-center">
                <h3>Melakukan Pembayaran</h3>
                <p class="text-justify mt-2">Pembayaran dilakukan secara cash on delivery dimana ketika pembelian sudah diantar maka pembeli membayar kepada penjual</p>
            </div>
        </div>
    </div>


    <!-- bagian bawah -->
    <section class="footer-section">
        <div class="container">
            <div class="footer-logo text-center">
                <a href="index.php"><img class="site-logo" src="img/logo.png" alt=""></a>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="footer-widget about-widget">
                        <h2>About</h2>
                        <p>MugOn adalah aplikasi tempat menjual ikan-ikan segar yang akan langsung diantar kerumah pembeli, dan pembayaran dilakukan ditempat.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="footer-widget contact-widget">
                        <h2>Questions</h2>
                        <div class="con-info">
                            <span>C.</span>
                            <p>MugOn Company</p>
                        </div>
                        <div class="con-info">
                            <span>B.</span>
                            <p>Lab Terpadu Unsyiah</p>
                        </div>
                        <div class="con-info">
                            <span>T.</span>
                            <p>+62 923 2352 2342</p>
                        </div>
                        <div class="con-info">
                            <span>E.</span>
                            <p>MugOn@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="social-links-warp text-center">
            <div class="container">
                <div class="social-links">
                    <a href="" class="instagram"><i class="fa fa-instagram"></i><span>instagram</span></a>
                    <a href="" class="facebook"><i class="fa fa-facebook"></i><span>facebook</span></a>
                    <a href="" class="twitter"><i class="fa fa-twitter"></i><span>twitter</span></a>
                    <a href="" class="youtube"><i class="fa fa-youtube"></i><span>youtube</span></a>
                </div>

                <p class="text-white text-center mt-5">Copyright &copy;<script>
                        document.write(new Date().getFullYear());
                    </script> MugeeOnline <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">MugOn</a></p>

            </div>
        </div>
    </section>
    <!-- akhir bagian akhir-->



    <!--====== Javascripts & Jquery ======-->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.slicknav.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.nicescroll.min.js"></script>
    <script src="js/jquery.zoom.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/main.js"></script>


</body>

</html>