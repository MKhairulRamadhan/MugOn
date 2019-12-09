<!-- Berikut merupakan suatu profil dari halaman mugee yang memiliki fiture update profil mugee
 @outhor: Raisya Husna Agustin
-->

<?php
  session_start();
  $koneksi = new mysqli("localhost", "root", "", "mugon"); //koneksi ke database

    if(!isset($_SESSION['mugee'])){
		echo "<script> alert('anda harus login .!');</script>";
		echo "<script>location='../login.php';</script>";
	}

  //ambil id dari session
  $id_mugee = $_SESSION['mugee']['id_mugee'];

  $ambil = $koneksi->query("SELECT * FROM mugee WHERE id_mugee = '$id_mugee' ");

  $pecah = $ambil->fetch_assoc();
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
	<link href="../img/logo.png" rel="shortcut icon"/>

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,300i,400,400i,700,700i" rel="stylesheet">


	<!-- Stylesheets -->
	<link rel="stylesheet" href="../css/bootstrap.min.css"/>
	<link rel="stylesheet" href="../css/font-awesome.min.css"/>
	<link rel="stylesheet" href="../css/flaticon.css"/>
	<link rel="stylesheet" href="../css/slicknav.min.css"/>
	<link rel="stylesheet" href="../css/jquery-ui.min.css"/>
	<link rel="stylesheet" href="../css/owl.carousel.min.css"/>
	<link rel="stylesheet" href="../css/animate.css"/>
	<link rel="stylesheet" href="../css/style.css"/>

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


	<!-- checkout section  -->
	<section class="checkout-section spad">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 order-2 order-lg-1">
					<form class="checkout-form" method="post" enctype="multipart/form-data">
						<div class="cf-title">Profil Mugee</div>

						<div class="row address-inputs">
							<div class="col-md-6">
								<input type="text" name="nama" value="<?php echo $pecah['nama_mugee'] ?>">
							</div>
							<div class="col-md-6">
								<input type="text" name="email" value="<?php echo $pecah['email_mugee'] ?>" readonly>
							</div>
							<div class="col-md-12">
								<input type="text" name="alamat" value="<?php echo $pecah['alamat_mugee'] ?>">
								<input type="text" name="no_hp" value="<?php echo $pecah['no_hp_mugee'] ?>">
								<p> Upload Foto</p>
								<input type="file" name="foto" >
							</div>
						</div>

						<button class="site-btn submit-order-btn" name="kirim">Simpan Perubahan</button>
					</form>

					<?php

						if (isset($_POST['kirim'])) { // jika tombol simpan ditekan maka akan teruodate ke database
							$namafoto = $_FILES['foto']['name'];
							$lokasifoto = $_FILES['foto']['tmp_name'];
							//jika foto dirubah
							if (!empty($lokasifoto)) {
								move_uploaded_file($lokasifoto, "../img/profil/".$namafoto);

								$koneksi->query("UPDATE mugee SET nama_mugee='$_POST[nama]', alamat_mugee='$_POST[alamat]',
									no_hp_mugee ='$_POST[no_hp]',
									foto_mugee='$namafoto'
									WHERE id_mugee='$id_mugee'");
							}else{
								$koneksi->query("UPDATE mugee SET nama_mugee='$_POST[nama]', alamat_mugee='$_POST[alamat]',
									no_hp_mugee ='$_POST[no_hp]'
									WHERE id_mugee='$id_mugee'");
							}
							echo "<script>alert('data anda telah diubah');</script>";
							echo "<script>location='index.php';</script>";
						}

					?>


				</div>

				<div class="col-lg-4 order-1 order-lg-2">
					<div class="checkout-cart">
						<h3>Profil Anda</h3>
						<div class="checkout-cart-image">
							<img src="../img/profil/<?php echo $pecah['foto_mugee']; ?>" alt="profil1">
						</div>
						<div>
							<br>
							<a href="logout.php" class="btn btn-danger">LogOut</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- checkout section end -->

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

<p class="text-white text-center mt-5">Copyright &copy;<script>document.write(new Date().getFullYear());</script> MugeeOnline <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">MugOn</a></p>

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
