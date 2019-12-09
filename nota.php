<!-- Berikut merupakan suatu fungsi dari total pesanan dan nota
 @author: Raisya Husna Agustin
-->

<?php
	session_start();
	$koneksi = new mysqli("localhost", "root", "", "mugon");
	if (isset($_SESSION['keranjang']) || (!empty($_SESSION['keranjang']))) {
		$banyak = count($_SESSION['keranjang']);
	}

	if(!isset($_SESSION['pembeli'])){
		echo "<script> alert('anda harus login .!');</script>";
		echo "<script>location='login.php';</script>";
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>MugOn | Nota</title>
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
			<h4>Detail Pembelian</h4>
			<div class="site-pagination">
				<a href="index.html">Home</a> /
				<a href="">Detail Pembelian</a>
			</div>
		</div>
	</div>
	<!-- akhir bagian info -->

	<br>
	<section class="konten">
		<div class="container">
			<!-- koneksi ke database  -->
			<?php
				$ambil = $koneksi->query("SELECT * FROM pembelian JOIN pembeli ON pembelian.id_pembeli=pembeli.id_pembeli WHERE pembelian.id_pembelian='$_GET[id]'");
				$detail = $ambil->fetch_assoc();
				if (!($_SESSION['pembeli']['id_pembeli'] == $detail['id_pembeli'])) {
					echo "<script> alert('Jangan Lihat nota orang lain.. :>'); </script>";
					echo "<script>location='riwayat.php' </script>";
				}

			?>

			<div class="row">
				<div class="col-md-4">
					<h3>Pembelian</h3>
					<strong>No. Pembelian: <?php echo $detail['id_pembelian']; ?></strong><br>
					<p>
						Tanggal:<?php echo $detail['tanggal_pembelian']; ?>	<br>
						Total:<?php echo $detail['total_pembelian']; ?>
					</p>
				</div>
				<div class="col-md-4">
					<h3>Pelanggan</h3>
					<strong>Nama: <?php echo $detail['nama_pembeli']; ?></strong> <br>
					<p>
						<?php echo $detail['no_hp_pembeli']; ?> <br>
						<?php echo $detail['email_pembeli']; ?>
					</p >
				</div>
				<div class="col-md-4">
					<h3>Pengiriman</h3>
					<strong>Alamat : <?php echo $detail['alamat_pengiriman']; ?></strong>
				</div>
			</div>

			<table class="table table-striped">
				<thead>
					<tr>
						<th>no</th>
						<th>gambar</th>
						<th>nama</th>
						<th>harga</th>
						<th>jumlah</th>
						<th>subtotal</th>
					</tr>
				</thead>
				<tbody>
					<?php $nomor=1; ?>

					<?php
						$ambil = $koneksi->query("SELECT * FROM pembelian_ikan JOIN ikan WHERE pembelian_ikan.id_pembelian = '$_GET[id]' AND ikan.id_ikan = pembelian_ikan.id_ikan ");

					?>
					<?php while($pecah = $ambil->fetch_assoc()){ ?>
					<tr>
						<td><?php echo $nomor; ?></td>
						<td style="width: 100px;"><img src="img/Ikan/<?php echo $pecah['gambar_ikan']; ?>" alt=""> </td>
						<td><?php echo $pecah['nama_ikan']; ?></td>
						<td>Rp. <?php echo number_format($pecah['harga_ikan']); ?></td>
						<td><?php echo $pecah['jumlah']; ?></td>
						<td>Rp. <?php echo number_format($pecah['harga_total']); ?></td>
					</tr>
					<?php $nomor++; ?>
					<?php } ?>
				</tbody>
			</table>

			<div class="row">
				<div class="col-md-7">
					<div class="alert alert-info">
						<p>
							<?php if ($detail['status'] == "selesai") {
								echo "Pesanan telah diantar..!";
							}else{ ?>
								Silahkan Tunggu pesanan anda diantar, pesanan akan segera diantarkan oleh mugee.
							<?php } ?>
						</p>
					</div>
				</div>
			</div>

		</div>
	</section>
	<br><br>

<!-- bagian bawah -->
	<section class="footer-section">
		<div class="container">
			<div class="footer-logo text-center">
				<a href="index.html"><img class="site-logo" src="./img/logo.png" alt=""></a>
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
