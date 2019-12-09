<?php

session_start();

// pengkoneksian ke database
$koneksi = new mysqli("localhost", "root", "", "mugon");


if (empty($_SESSION['keranjang']) || !isset($_SESSION['keranjang'])) {
	echo "<script>alert('keranjang kosong !, silahkan berbelanja  .!');</script>";
	echo "<script>location = 'index.php';</script>";
}

if (isset($_SESSION['keranjang']) || (!empty($_SESSION['keranjang']))) {
	$banyak = count($_SESSION['keranjang']);
}
?>

<style>
	.quantity .pro-qty-test {
		width: 94px;
		height: 36px;
		border: 1px solid #ddd;
		padding: 0 15px;
		border-radius: 40px;
		float: left;
	}

	.quantity .pro-qty-test input {
		width: 28px;
		float: left;
		border: none;
		height: 36px;
		line-height: 40px;
		padding: 0;
		font-size: 14px;
		text-align: center;
		background-color: transparent;
	}

	.cart-table .quantity .pro-qty-test {
		width: 85px;
		background: #fff;
		border-color: #fff;
	}
</style>
<!DOCTYPE html>
<html lang="zxx">

<head>
	<title>MugOn | Keranjang</title>
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
					<!-- akhir fungsi search -->
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
			<h4>Keranjang Anda</h4>
			<div class="site-pagination">
				<a href="index.html">Home</a> /
				<a href="">Keranjang Anda</a>
			</div>
		</div>
	</div>
	<!-- Page info end -->


	<!-- cart section end -->
	<section class="cart-section spad">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<div class="cart-table">
						<h3>Pembelian Anda</h3>
						<div class="cart-table-warp">
							<table>
								<thead>
									<tr>
										<th class="product-th">Ikan</th>
										<th class="quy-th">Berat/kg</th>
										<th class="size-th">subTotal</th>
										<th class="total-th">Aksi</th>
									</tr>
								</thead>
								<tbody>

									<?php $total = 0; ?>
									<?php if (isset($_SESSION['keranjang'])) { ?>
										<?php foreach ($_SESSION["keranjang"] as $id_ikan => $jumlah) : ?>
											<!-- menampilkan produk -->
											<?php
											$ambil = $koneksi->query("SELECT * FROM ikan WHERE id_ikan = '$id_ikan' ");
											$pecah = $ambil->fetch_assoc();
											?>

											<tr>
												<td class="product-col">
													<img src="img/Ikan/<?php echo $pecah['gambar_ikan']; ?>" alt="">
													<div class="pc-title">
														<h4><?php echo $pecah['nama_ikan'] ?></h4>
														<p>Rp. <?php echo number_format($pecah['harga_ikan'],0,',','.')  ?> / kg</p>
													</div>
												</td>
												<td class="quy-col">
													<div class="quantity">
														<div class="pro-qty-test">
															<input type="text" value="<?php echo $jumlah ?>" readonly>
														</div>
													</div>
												</td>
												<td class="total-col">
													<h4>Rp.<?php echo number_format($pecah['harga_ikan'] * $jumlah,0,',','.'); ?></h4>
												</td>
												<td class="">
													<h4><a href="hapus_keranjang.php?id=<?php echo "$id_ikan"; ?>" class="btn btn-danger btn-xs">Hapus</a></h4>
												</td>
											</tr>

											<?php $total += $pecah['harga_ikan'] * $jumlah ?>
										<?php endforeach ?>
									<?php } ?>

								</tbody>
							</table>
						</div>
						<div class="total-cost">
							<h6>Total <span>Rp. <?php echo number_format($total,0,',','.'); ?></span></h6>
						</div>
					</div>
				</div>
				<div class="col-lg-4 card-right">
					<a href="checkout.php" class="site-btn" name="lakukan">Lakukan Pemesanan</a>
					<a href="index.php" class="site-btn sb-dark">Lanjut Belanja</a>
				</div>
			</div>
		</div>
	</section>
	<!-- cart section end -->

	<!-- Bagian produk lainnya -->
	<section class="product-filter-section">
		<div class="container">
			<div class="section-title">
				<h2>Lanjutkan Belanja</h2>
			</div>
			<div class="row">
				<?php
				$sql = "SELECT * FROM ikan";
				$tampilIkan = mysqli_query($koneksi, $sql);
				// untuk membatasi
				$batas = mysqli_num_rows($tampilIkan);
				while ($variabel = mysqli_fetch_assoc($tampilIkan)) { ?>
					<?php if (!($batas > 4)) { ?>
						<div class="col-lg-3 c0l-sm-6">
							<div class="product-item">
								<div class="pi-pic">
									<?php if ($variabel['stok_ikan'] <= 0) { ?>
										<div class="tag-sale">HABIS</div>
									<?php } else { ?>
										<div class="tag-sale">STOK: <?php echo $variabel['stok_ikan']; ?>kg</div>
									<?php } ?>
									<a href="detail_ikan.php?id=<?php echo $variabel['id_ikan'] ?>"><img src="img/Ikan/<?php echo $variabel['gambar_ikan']; ?>" alt="tampil"></a>
									<div class="pi-links">
										<a href="beli.php?id=<?php echo $variabel['id_ikan'] ?>" class="add-card"><i class="flaticon-bag"></i><span>Beli Sekarang</span></a>
									</div>
								</div>
								<div class="pi-text">
									<?php echo "<h6>Rp. " . number_format($variabel['harga_ikan'],0,',','.') . "/kg</h6>" ?>
									<?php echo "<p>" . $variabel['nama_ikan'] . "</p>" ?>
								</div>
							</div>
						</div>
					<?php } ?>
					<?php $batas--;
				} ?>
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