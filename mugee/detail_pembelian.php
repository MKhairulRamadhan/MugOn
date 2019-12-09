<?php
session_start();
$koneksi = new mysqli("localhost", "root", "", "mugon");

if (!isset($_SESSION['mugee'])) {
    echo "<script> alert('anda harus login .!');</script>";
    echo "<script>location='../login.php';</script>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>MugOn | Home</title>
    <meta charset="UTF-8">
    <meta name="description" content=" Divisima | eCommerce Template">
    <meta name="keywords" content="divisima, eCommerce, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link href="../img/logo.png" rel="shortcut icon" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,300i,400,400i,700,700i" rel="stylesheet">


    <!-- Stylesheets -->
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/font-awesome.min.css" />
    <link rel="stylesheet" href="../css/flaticon.css" />
    <link rel="stylesheet" href="../css/slicknav.min.css" />
    <link rel="stylesheet" href="../css/jquery-ui.min.css" />
    <link rel="stylesheet" href="../css/owl.carousel.min.css" />
    <link rel="stylesheet" href="../css/animate.css" />
    <link rel="stylesheet" href="../css/style.css" />

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
                            <img src="../img/logo.png" alt="">
                        </a>
                    </div>
                    <div class="col-xl-6 col-lg-5">
                    </div>
                    <div class="col-xl-4 col-lg-5">
                        <div class="user-panel">
                            <div class="up-item">
                                <i class="flaticon-profile"></i>
                                <a href="index.php"><?php echo $_SESSION['mugee']['nama_mugee']; ?></a>
                            </div>
                            <div class="up-item">
                                <?php 
                                    $ambil = $koneksi->query("SELECT * FROM pembelian WHERE status = 'proses'");
                                    $banyak = mysqli_num_rows($ambil);
                                ?>
                                <div class="shopping-card">
                                    <i class="flaticon-bag"></i>
                                    <span>
                                    <?php 
                                        if ($banyak > 0) {
                                            echo $banyak;
                                        }else{
                                            echo "0";
                                        }
                                    ?>
                                    </span>
                                </div>
                                <a href="pembelian.php">Pesanan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav class="main-navbar text-center">
            <div class="container">
                <!-- bagian menu/ navigasi -->
                <ul class="main-menu">
                    <li><a href="index.php">Profil</a></li>
                    <li><a href="ikan.php">Ikan</a></li>
                    <li><a href="pembelian.php">Pesanan</a></li>
                    <li><a href="pesan.php">Pesan</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- akhir bagian dari kepala/atas -->

    <!-- Bagian info -->
    <div class="page-top-info">
        <div class="container">
            <h4>Detail Pesanan</h4>
            <div class="site-pagination">
                <a href="pembelian.php">Back</a> /
                <a href="">Pemesanan</a>
            </div>
        </div>
    </div>
    <!-- akhir bagian info -->

    <br>

    <!-- Bagian awal Detail Pembelian -->
    <div class="container">

        <?php
        $ambil = $koneksi->query("SELECT * FROM pembelian JOIN pembeli ON pembelian.id_pembeli=pembeli.id_pembeli WHERE pembelian.id_pembelian='$_GET[id]'");
        $detail = $ambil->fetch_assoc();

        ?>
        <div class="row">

            <div class="col-md-6">
                <div class="checkout-cart">
                    <h3><?php echo $detail['nama_pembeli'] ?></h3>
                    <div class="checkout-cart-image">
                        <img src="../img/profil/<?php echo $detail['foto_pembeli']; ?>" alt="profil1">
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <strong>Nama: <?php echo $detail['nama_pembeli']; ?></strong><br>
                <p>
                    No Hp : <?php echo $detail['no_hp_pembeli']; ?> <br>
                    Email : <?php echo $detail['email_pembeli']; ?> <br>
                    Alamat : <?php echo $detail['alamat_pengiriman']; ?>

                </p>

                <p>
                    Tanggal : <?php echo $detail['tanggal_pembelian']; ?> <br>
                    Total Pembelian : <?php echo $detail['total_pembelian']; ?>
                </p>
            </div>

            <div class="col-md-3">
                <h3>Pembelian</h3>
                <strong>No. Pembelian: <?php echo $detail['id_pembelian']; ?></strong><br>
                <p>
                    Tanggal:<?php echo $detail['tanggal_pembelian']; ?> <br>
                    Total:<?php echo $detail['total_pembelian']; ?>
                </p>
            </div>
        </div>
        <br>


        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>no</th>
                    <th>Ikan</th>
                    <th>harga</th>
                    <th>jumlah</th>
                    <th>subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $nomor = 1; ?>
                <?php $ambil = $koneksi->query("SELECT * FROM pembelian_ikan JOIN pembelian ON pembelian_ikan.id_pembelian=pembelian.id_pembelian WHERE pembelian.id_pembelian='$_GET[id]'"); ?>
                <?php while ($pecah = $ambil->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $nomor; ?></td>
                        <td><?php echo $pecah['nama_ikan']; ?></td>
                        <td><?php echo $pecah['harga_ikan']; ?></td>
                        <td><?php echo $pecah['jumlah']; ?></td>
                        <td><?php echo $pecah['harga_total'] ?></td>
                    </tr>
                    <?php $nomor++; ?>
                <?php } ?>
            </tbody>
        </table>

        <form action="" method="post">
            <button name="konfirmasi" class="btn btn-success">Konfirmasi Telah Diantar</button>
        </form>
        <br><br>

        <?php
        if (isset($_POST['konfirmasi'])) {
            $koneksi->query("UPDATE pembelian SET status = 'selesai' WHERE id_pembelian = $_GET[id] ");
            echo "<script> alert('Konfirmasi anda sukses .!');</script>";
            echo "<script>location='pembelian.php' </script>";
        }
        ?>

    </div>
    <!-- Bagian awal Detail Pembelian -->

    <!-- bagian bawah -->
    <section class="footer-section">
        <div class="container">
            <div class="footer-logo text-center">
                <a href="index.php"><img class="site-logo" src="../img/logo.png" alt=""></a>
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
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.slicknav.min.js"></script>
    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/jquery.nicescroll.min.js"></script>
    <script src="../js/jquery.zoom.min.js"></script>
    <script src="../js/jquery-ui.min.js"></script>
    <script src="../js/main.js"></script>

</body>

</html>