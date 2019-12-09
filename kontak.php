<!-- 
	Halaman berikut merupakan halaman kontak yang memberikan kontak dari mugee dan diberikan fitur untuk mengirimkan pesan kemugee
	@author : M.Khairul Ramadhan , 29-05-2019
 -->

<?php 
	// mulai session
	session_start();
	$koneksi = new mysqli("localhost", "root", "", "mugon");

	// jika belum login
	if(!isset($_SESSION['pembeli'])){
		echo "<script> alert('anda harus login .!');</script>";
		echo "<script>location='login.php';</script>";
	}

	if (isset($_SESSION['keranjang']) || (!empty($_SESSION['keranjang']))) {
		$banyak = count($_SESSION['keranjang']);
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>MugOn | Kontak</title>
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
								<?php } else { ?>
									<a href="login.php">Login</a> atau <a href="daftar.php">Daftar</a>
								<?php } ?>
							</div>
							<div class="up-item">
								<div class="shopping-card">
									<i class="flaticon-bag"></i>
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
					<!-- fungsi search ikan -->
					<?php 
						if (isset($_POST['cari'])) {
							if (!empty($_POST['cari'])) {
								$koneksi = new mysqli("localhost", "root", "", "mugon");
								$ambil = $koneksi->query("SELECT id_ikan FROM ikan WHERE nama_ikan LIKE '%$_POST[cari]%' ");
								$pecah = $ambil->fetch_assoc();	
								if (!empty($pecah)) {
									echo "<script>location='detail_ikan.php?id=".$pecah['id_ikan']."'</script>";	
								}else{
									echo "<script>alert('Ikan yang anda cari tidak ada !!');</script>";
									echo "<script>location='index.php'</script>";
								}
							}else{

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


	<!-- Page info -->
	<div class="page-top-info">
		<div class="container">
			<h4>Kontak</h4>
			<div class="site-pagination">
				<a href="index.html">Home</a> /
				<a href="">Kontak</a>
			</div>
		</div>
	</div>
	<!-- Page info end -->


	<!-- Contact section -->
	<section class="contact-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 contact-info">
					<h3>Hubungi kami</h3>
					<p>Lab terpadu Unsyiah, aceh</p>
					<p>+62 342 2153 1234</p>
					<p>MugOn@gmail.com</p>
					<div class="contact-social">
						<a href="#"><i class="fa fa-facebook"></i></a>
						<a href="#"><i class="fa fa-twitter"></i></a>
					</div>

					<?php 
						// fungsi untuk mengirimkan pesan kepada mugee
						if (isset($_POST['submit'])) {		//ketika tombol submit ditekan
							$id = $_SESSION['pembeli']['id_pembeli'];
							$tgl = date("Y-m-d");

							// query insert ke database
 							$koneksi->query("INSERT INTO pesan (id_pembeli, judul_pesan, isi_pesan, tanggal_pesan) VALUES ('$id', '$_POST[judul]', '$_POST[pesan]', '$tgl' ) ");

						}
					?>

					<form class="contact-form" method="post" action="">
						<input type="text" value="<?php echo $_SESSION['pembeli']['nama_pembeli'] ?>" readonly>
						<input type="text" value="<?php echo $_SESSION['pembeli']['email_pembeli'] ?>" readonly>
						<input type="text" name="judul" placeholder="Judul" required>
						<textarea placeholder="Pesan" name="pesan" required></textarea>
						<button class="site-btn" type="submit" name="submit">KIRIM SEKARANG</button>
					</form>
				</div>
			</div>
		</div>
		<div class="map"><iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d3970.9925821909014!2d95.36717964470519!3d5.56811236986276!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sid!2sid!4v1555478643052!5m2!1sid!2sid" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe></div>

	</section>
	<!-- Contact section end -->


	<!-- Related product section -->
	<section class="related-product-section spad">
		<div class="container">
			<div class="section-title">
				<h2>Belanja Lagi..!</h2>
			</div>
			<div class="row">
				<?php 	
				$sql = "SELECT * FROM ikan";
				$tampilIkan = mysqli_query($koneksi,$sql);
				$batas = mysqli_num_rows($tampilIkan);						//membatasi 
				while($variabel = mysqli_fetch_assoc($tampilIkan)){ ?>
				<?php if (!($batas > 4)) { ?>
				<div class="col-lg-3 c0l-sm-6">
				<div class="product-item">
					<div class="pi-pic">
						<?php if ($variabel['stok_ikan'] <= 0) { ?>
							<div class="tag-sale">HABIS</div>
						<?php }else{ ?>
						<div class="tag-sale">STOK: <?php echo $variabel['stok_ikan']; ?>kg</div>
						<?php } ?>	
						<a href="detail_ikan.php?id=<?php echo $variabel['id_ikan']?>"><img src="img/Ikan/<?php echo $variabel['gambar_ikan'];?>"alt="tampil"></a>
						<div class="pi-links">
							<a href="beli.php?id=<?php echo $variabel['id_ikan']?>" class="add-card"><i class="flaticon-bag"></i><span>Beli Sekarang</span></a>
						</div>
					</div>
					<div class="pi-text">
						<?php echo "<h6>Rp. ". number_format($variabel['harga_ikan'],0,',','.') ."/kg</h6>"?>
						<?php echo "<p>". $variabel['nama_ikan']."</p>"?>
					</div>
				</div>
				</div>
				<?php } ?>
			<?php $batas--; }?>
		</div>
	</section>
	<!-- Related product section end -->


		<!-- bagian bawah -->
	<section class="footer-section">
		<div class="container">
			<div class="footer-logo text-center">
				<a href="index.php"><img class="site-logo" src="./img/logo.png" alt=""></a>
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
