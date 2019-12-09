<!-- /**
  * Tampilan login , sebagai interface untuk login dari pengguna dan juga mugee
  * @author M.Khairul Ramadhan
**/ -->
<?php 
  //memulai session yang berguna untuk menyimpan data sementara
  session_start();
  $koneksi = new mysqli("localhost", "root", "", "mugon");
  if (isset($_SESSION['keranjang']) || (!empty($_SESSION['keranjang']))) {
    $banyak = count($_SESSION['keranjang']);
  }

  if(isset($_SESSION['pembeli'])){
    echo "<script>location='profil.php';</script>";
  }

?>

<!DOCTYPE html>
<html>
<head>
  <title>MugOn | Login</title>
  <meta charset="UTF-8">
  <meta name="description" content=" Divisima | eCommerce Template">
  <meta name="keywords" content="divisima, eCommerce, creative, html">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Favicon -->
  <link href="img/logo.png" rel="shortcut icon"/>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,300i,400,400i,700,700i" rel="stylesheet">


  <!-- Stylesheets -->
  <link rel="stylesheet" href="css/bootstrap.min.css"/>
  <link rel="stylesheet" href="css/font-awesome.min.css"/>
  <link rel="stylesheet" href="css/flaticon.css"/>
  <link rel="stylesheet" href="css/slicknav.min.css"/>
  <link rel="stylesheet" href="css/jquery-ui.min.css"/>
  <link rel="stylesheet" href="css/owl.carousel.min.css"/>
  <link rel="stylesheet" href="css/animate.css"/>
  <link rel="stylesheet" href="css/style.css"/>
  <link rel="stylesheet" href="css/login.css"/>

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
                <i class="flaticon-profile"></i>
                <?php if (isset($_SESSION['pembeli'])) { ?>
                  <a href="profil.php"><?php echo $_SESSION['pembeli']['nama_pembeli']; ?></a>
                <?php }else{ ?>
                  <a href="login.php">Login</a> atau <a href="daftar.php">Daftar</a>
                <?php } ?>
              </div>
              <div class="up-item">
                <div class="shopping-card">
                  <i class="flaticon-bag"></i>
                  <span>
                  <?php if (isset($_SESSION['keranjang']) || (!empty($_SESSION['keranjang']))) {
                    echo $banyak; 
                  }else{
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

          <!-- fungsi search ikan untuk mencari ikan -->
          <?php 
            if (isset($_POST['cari'])) {
              $koneksi = new mysqli("localhost", "root", "", "mugon");
              $ambil = $koneksi->query("SELECT id_ikan FROM ikan WHERE nama_ikan LIKE '%$_POST[cari]%' ");
              $pecah = $ambil->fetch_assoc(); 
              if (!empty($pecah)) {
                echo "<script>location='detail_ikan.php?id=".$pecah['id_ikan']."'</script>";  
              }else{
                echo "<script>alert('Ikan yang anda cari tidak ada !!');</script>";
                echo "<script>location='index.php'</script>";
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


  <div class="form">
      
      <ul class="tab-group">
        <li class="tab-pembeli tab active"><a href="#pembeli">Pembeli</a></li>
        <li class="tab-mugee tab"><a href="#mugee">Mugee</a></li>
      </ul>
      
      <div class="tab-content">
        <div id="pembeli">   
          <h1>Login Pembeli</h1>
          
          <!-- /**
                * Fungsi untuk login dan mengecek akun di database
                ***/ -->
          <?php 
            // jika tombol login ditekan
            if (isset($_POST['login_pembeli'])){
              // lakukan query cek akun dari tabel pelanggan

              $ambil = $koneksi->query("SELECT * FROM pembeli WHERE email_pembeli = '$_POST[email]' AND  password_pembeli = '$_POST[password]' ");

              // ngitung akun yang terambil
              $akunYangCocok = $ambil->num_rows;

              if($akunYangCocok == 1){
                // anda sudah login
                // mendapatkan akun dalam bentuk array
                $akun = $ambil->fetch_assoc();

                // simpan di session pelanggan
                $_SESSION['pembeli'] = $akun;
                echo "<div class='alert alert-info'>Login sukses</div>";
                echo "<meta http-equiv='refresh' content='1;url=index.php'>";
              }else{
              // }anda gagal login
                echo "<div class='alert alert-danger'>Login gagal</div>";
              }
            }
          ?>

          <form action="" method="post">
          
            <div class="field-wrap">
            <label>
              Alamat Email<span class="req">*</span>
            </label>
            <input type="email" name="email" required autocomplete="off"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Password<span class="req">*</span>
            </label>
            <input type="password" name="password" required autocomplete="off"/>
          </div>
          
          <p class="forgot"><a href="daftar.php">Belum Punya Akun?</a></p>
          
          <button class="button button-block" name="login_pembeli">Log In</button>
          
          </form>

        </div>
        
        <div id="mugee">   
          <h1>Login Mugee</h1>

          <?php 
            // jika tombol login ditekan
            if (isset($_POST['login_mugee'])){
              // lakukan query cek akun dari tabel pelanggan

              $ambil = $koneksi->query("SELECT * FROM mugee WHERE email_mugee = '$_POST[email]' AND  password_mugee = '$_POST[password]' ");

              // ngitung akun yang terambil
              $akunYangCocok = $ambil->num_rows;

              if($akunYangCocok == 1){
                // anda sudah login
                // mendapatkan akun dalam bentuk array
                $akun = $ambil->fetch_assoc();

                // simpan di session pelanggan
                $_SESSION['mugee'] = $akun;
                echo "<div class='alert alert-info'>Login sukses</div>";
                echo "<script>location = 'mugee/pembelian.php';</script>";
              }else{
              // }anda gagal login
                echo "<div class='alert alert-danger'>Login gagal</div>";
              }
            }
          ?>
          
          <form action="" method="post">
          
            <div class="field-wrap">
            <label>
              Alamat Email<span class="req">*</span>
            </label>
            <input type="email" name="email" required autocomplete="off"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Password<span class="req">*</span>
            </label>
            <input type="password" name="password" required autocomplete="off"/>
          </div>
          
          <button class="button button-block" name="login_mugee" />Log In</button>
          
          </form>

        </div>
        
      </div><!-- tab-content -->
      
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

<p class="text-white text-center mt-5">Copyright &copy;<script>document.write(new Date().getFullYear());</script> MugeeOnline <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">MugOn</a></p>

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
  <script src="js/login.js"></script>




</body>

</html>
