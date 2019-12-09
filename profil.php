<!-- Berikut merupakan suatu profil dari halaman pembeli yang memiliki fiture update data diri pembeli
 @author: Raisya Husna Agustin
-->

<?php
  session_start();
  $koneksi = new mysqli("localhost", "root", "", "mugon"); //koneksi ke database
	if (isset($_SESSION['keranjang']) || (!empty($_SESSION['keranjang']))) {
		$banyak = count($_SESSION['keranjang']);
	}

    if(!isset($_SESSION['pembeli'])){
		echo "<script> alert('anda harus login .!');</script>";
		echo "<script>location='../login.php';</script>";
	}

  //ambil id dari session
  $id_pembeli = $_SESSION['pembeli']['id_pembeli'];

  $ambil = $koneksi->query("SELECT * FROM pembeli WHERE id_pembeli = '$id_pembeli' ");

  $pecah = $ambil->fetch_assoc();

?>

<!DOCTYPE html>
<html>
<head>
	<title>MugOn | Profil</title>
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

					<!-- fungsi search ikan -->
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


	<!-- Bagian info -->
	<div class="page-top-info">
		<div class="container">
			<h4>Informasi Anda</h4>
			<div class="site-pagination">
				<a href="index.html">Home</a> /
				<a href="">Profil</a>
			</div>
		</div>
	</div>
	<!-- akhir bagian info -->

	<!-- checkout section  -->
	<section class="checkout-section spad">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 order-2 order-lg-1">
					<form class="checkout-form" method="post" enctype="multipart/form-data">
						<div class="cf-title">Profil Anda</div>

						<div class="row address-inputs">
							<div class="col-md-6">
								<input type="text" name="nama" value="<?php echo $pecah['nama_pembeli'] ?>">
							</div>
							<div class="col-md-6">
								<input type="text" name="email" value="<?php echo $pecah['email_pembeli'] ?>" readonly>
							</div>
							<div class="col-md-12">
								<input type="text" name="alamat" value="<?php echo $pecah['alamat_pembeli'] ?>">
								<input type="text" name="no_hp" value="<?php echo $pecah['no_hp_pembeli'] ?>">
								<p> Upload Foto</p>
								<input type="file" name="foto" >
							</div>
						</div>

						<button class="site-btn submit-order-btn" name="ubah">Simpan Perubahan</button>
					</form>

					<?php
						if (isset($_POST['ubah'])) { // jika tombol simpan ditekan maka akan teruodate ke database
							$namafoto = $_FILES['foto']['name'];
							$lokasifoto = $_FILES['foto']['tmp_name'];
							//jika foto dirubah
							if (!empty($lokasifoto)) {
								move_uploaded_file($lokasifoto, "img/profil/".$namafoto);

								$koneksi->query("UPDATE pembeli SET nama_pembeli='$_POST[nama]', alamat_pembeli='$_POST[alamat]',
									no_hp_pembeli ='$_POST[no_hp]',
									foto_pembeli='$namafoto'
									WHERE id_pembeli='$id_pembeli'");
							}else{
								$koneksi->query("UPDATE pembeli SET nama_pembeli='$_POST[nama]', alamat_pembeli='$_POST[alamat]',
									no_hp_pembeli ='$_POST[no_hp]'
									WHERE id_pembeli='$id_pembeli'");
							}
							echo "<script>alert('profil telah diubah');</script>";
							echo "<script>location='profil.php';</script>";
						}
					?>

				</div>

				<div class="col-lg-4 order-1 order-lg-2">
					<div class="checkout-cart">
						<h3>Profil Anda</h3>
						<div class="checkout-cart-image">
							<img src="img/profil/<?php echo $pecah['foto_pembeli']; ?>" alt="profil1">
						</div>
					</div>
					<br>
					<a href="logout.php" class="btn btn-danger">LogOut</a>
				</div>
			</div>
		</div>
	</section>
	<!-- checkout section end -->

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

	</body>
</html>
