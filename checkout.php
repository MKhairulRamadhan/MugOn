<!-- 
	/**
	 * pada halaman ini akan mengkonfirmasi pesanan dari si
	 * pembeli dan akan dimasukan langsung ke database dan 
	 * ditampilkan ke admin.
	 * @author M.Khairul Ramadhan
	 */
 -->
<?php 
	session_start();	//memulai session

	// koneksi kedatabase
	$koneksi = new mysqli("localhost", "root", "", "mugon");

	// kondisi jika pembeli belum login
	if(!isset($_SESSION['pembeli'])){
		echo "<script> alert('anda harus login .!');</script>";
		echo "<script>location='login.php';</script>";
	}

	// jika keranjang kosong
	if (isset($_SESSION['keranjang']) || (!empty($_SESSION['keranjang']))) {
		$banyak = count($_SESSION['keranjang']);
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>MugOn | Checkout</title>
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
			<h4>Pemesanan</h4>
			<div class="site-pagination">
				<a href="index.php">Home</a> /
				<a href="">Pemesanan</a>
			</div>
		</div>
	</div>
	<!-- akhir bagian info -->


	<!-- checkout section  -->
	<section class="checkout-section spad">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 order-2 order-lg-1">
					<form class="checkout-form" method="post">
						<div class="cf-title">Alamat Pengiriman</div>
						<div class="row">
							<div class="col-md-7">
								<p>Informasi Pengiriman</p>
							</div>
							<div class="col-md-5">
								<div class="cf-radio-btns address-rb">
									<div class="cfr-item">
										<input type="radio" name="pilih" id="one" value="alamat_saya">
										<label for="one">pakai alamat Saya</label>
									</div>
									<div class="cfr-item">
										<input type="radio" name="pilih" id="two" value="alamat_lain">
										<label for="two">Pakai Alamat lain </label>
									</div>
								</div>
							</div>
						</div>

						<!-- mengambil identitas pembeli dan ditampilkan -->
						<?php 
							  //ambil id dari session
							  $id_pembeli = $_SESSION['pembeli']['id_pembeli'];

							  $ambil = $koneksi->query("SELECT * FROM pembeli WHERE id_pembeli = '$id_pembeli' ");
							   $pecah_pembeli = $ambil->fetch_assoc();

						?>

						<div class="row address-inputs">
							<div class="col-md-12">
								<label>Alamat Saya</label>
								<input type="text" name="alamat_saya" value="<?php echo $pecah_pembeli['alamat_pembeli']; ?>" readonly>
								<input type="text" name="alamat_lain" placeholder="Alamat Lainnya">
								<input type="text" name="kota" placeholder="Kota">
							</div>
							<div class="col-md-6">
								<input type="text" name="kd_pos" placeholder="Kode Pos">
							</div>
							<div class="col-md-6">
								<input type="text" name="no_hp" value="<?php echo $pecah_pembeli['no_hp_pembeli']; ?>" readonly>
							</div>
						</div>
						<div class="cf-title">Info Cara Pengiriman</div>
						<div class="row shipping-btns">
							<div class="col-12">
							<h4>Pengiriman Gratis</h4> <br>
							<h5>Pengiriman akan dilakukan secepatnya setelah anda melakukan checkout pemesanan anda</h5>
							</div>
						</div>
						<div class="cf-title">Pembayaran</div>
						<h6>Pembayaran dilakukan secara COD(Cast On Delivery), yaitu anda dapat melakukan pembayaran ketika pesanan ikan anda telah anda terima</h6>
						<button name="checkout" class="site-btn submit-order-btn">Lakukan Pemesanan</button>
					</form>
				</div>

				<div class="col-lg-4 order-1 order-lg-2">
					<div class="checkout-cart">
						<h3>Pesanan Anda</h3>
						<ul class="product-list">

							<!-- menampilkan semua pesanan dan harga total -->
							<?php $total = 0; ?>
							<?php if(isset($_SESSION['keranjang'])){ ?>
							<?php foreach ($_SESSION["keranjang"] as $id_ikan => $jumlah): ?>
								<!-- menampilkan produk -->
							<?php 
								$ambil = $koneksi->query("SELECT * FROM ikan WHERE id_ikan = '$id_ikan' ");
								$pecah = $ambil->fetch_assoc();
							 ?>	

							<li>
								<div class="pl-thumb"><img src="img/Ikan/<?php echo $pecah['gambar_ikan']; ?>" alt=""></div>
								<h6><?php echo $pecah['nama_ikan'] ?></h6>
								<p>Rp.<?php echo number_format($pecah['harga_ikan']*$jumlah,0,',','.') ?>/kg</p>
							</li>
							<?php $total += $pecah['harga_ikan']*$jumlah ?>
							<?php endforeach ?>
							<?php } ?>

						</ul>
						<ul class="price-list">
							<li>Total<span>Rp.<?php echo number_format($total,0,',','.') ?></span></li>
							<li>Pengiriman<span>Gratis</span></li>
							<li class="total">Total<span>Rp.<?php echo number_format($total,0,',','.') ?></span></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- checkout section end -->

	<!-- memasukan ke databse ketika buttom checkout ditekan -->
	<?php  
		if (isset($_POST['checkout'])) {
			$id_pembeli = $_SESSION['pembeli']['id_pembeli'];
			$tanggal_pembelian = date("Y-m-d");
			$alamat = $_POST['alamat_saya'];
			if($_POST['pilih'] == 'alamat_lain' && (!empty($_POST['alamat_lain']))){
				$alamat = $_POST['alamat_lain'].", ".$_POST['kota'].", ".$_POST['kd_pos'];
			}

			$koneksi->query("INSERT INTO pembelian (id_pembeli, tanggal_pembelian, total_pembelian, alamat_pengiriman, status) VALUES ('$id_pembeli', '$tanggal_pembelian', '$total', '$alamat', 'proses') ");

			//mendapatkan id_pembelian barusan terjadi
			$id_pembelian_barusan = $koneksi->insert_id;
			foreach ($_SESSION['keranjang'] as $id_ikan => $jumlah) {

				$koneksi->query("UPDATE ikan SET stok_ikan = stok_ikan - $jumlah WHERE id_ikan = '$id_ikan' ");

				$ambil = $koneksi->query("SELECT * FROM ikan WHERE id_ikan = '$id_ikan' ");

				$perikan = $ambil->fetch_assoc();
				$nama = $perikan['nama_ikan'];
				$harga = $perikan['harga_ikan'];
				$subHarga = $jumlah*$harga;

				// memasukan ke database pembelian_ikan
				$koneksi->query("INSERT INTO pembelian_ikan (id_pembelian, id_ikan, jumlah, nama_ikan, harga_ikan, harga_total) VALUES ('$id_pembelian_barusan', '$id_ikan', '$jumlah', '$nama', '$harga', '$subHarga')");

				if ($perikan['stok_ikan'] <= 0) {
					$koneksi->query("UPDATE ikan SET status_ikan = 'habis' where id_ikan = '$id_ikan' ");
				}


			}

			// 3. mengkosongkan keranjang belanja
			unset($_SESSION['keranjang']);

			// 4. tampilan dialihkan ke halaman nota
			echo "<script>alert('pembelian success');</script>";
			echo "<script>location='nota.php?id=$id_pembelian_barusan' </script>";
		}

	?>

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