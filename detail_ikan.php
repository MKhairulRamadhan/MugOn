<!-- 
		halaman berikut merupakan halaman untuk menampilkan detail dari ikan,
		@author M.Khairul Ramadhan, 25-05-2019

 -->
<?php 
	session_start();	//mulai session

	// koneksi kedatabase mugon
	$koneksi = new mysqli("localhost", "root", "", "mugon");
	if (isset($_SESSION['keranjang']) || (!empty($_SESSION['keranjang']))) {
		$banyak = count($_SESSION['keranjang']);
	}

	// mendapatkan id ikan dari url
	$id_ikan = $_GET['id'];

	$ambil = $koneksi->query("SELECT * FROM ikan WHERE id_ikan = '$id_ikan' ");
	$pecah = $ambil->fetch_assoc();	
?>
<!DOCTYPE html>
<html>
<head>
	<title>MugOn | Detail</title>
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

	<style>
		.hilangkan{
			display: none;
		}	
	</style>

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
			<h4>Detail ikan</h4>
			<div class="site-pagination">
				<a href="index.html">Home</a> /
				<a href="">Beli</a>
			</div>
		</div>
	</div>
	<!-- Page info end -->


	<!-- product section -->
	<section class="product-section">
		<div class="container">
			<div class="back-link">
				<a href="index.php"> &lt;&lt; Kembali ke Home</a>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="product-pic-zoom">
						<img class="product-big-img" src="img/Ikan/<?php echo $pecah['gambar_ikan'] ?>" alt="">
					</div>

				</div>
				<div class="col-lg-6 product-details">

					<h2 class="p-title"><?php echo $pecah['nama_ikan'] ?></h2>
					<h3 class="p-price">Rp. <?php echo number_format($pecah['harga_ikan'],0,',','.') ?> / kg</h3>
					<h4 class="p-stock">Tersedia: <span>Stok : <?php echo $pecah['stok_ikan'] ?> kg</span></h4>
					<div class="p-review">
						<a href="">3 Pembeli</a>|<a href=""></a>
					</div>
						
					<form action="beli.php" method="get">

					<div class="quantity">
						<p>Jumlah / kg</p>
                        <div class="pro-qty">
                        	<input type="text" name="banyak" value="1" max="5">
                        </div>
                    </div>
                    <div class="hilangkan">
                    	<input type="number" name="id" value="<?php echo $id_ikan; ?>">
                    </div>

                    <input type="submit" name="cek" class="site-btn" value="beli sekarang">

					</form>

					<div id="accordion" class="accordion-area">
						<div class="panel">
							<div class="panel-header" id="headingOne">
								<button class="panel-link active" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">Informasi</button>
							</div>
							<div id="collapse1" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
								<div class="panel-body">
									<p><?php echo $pecah['keterangan'] ?></p>
								</div>
							</div>
						</div>
						<div class="panel">
							<div class="panel-header" id="headingTwo">
								<button class="panel-link" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">Metode pembayaran</button>
							</div>
							<div id="collapse2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
								<div class="panel-body">
									<p>Pembayaran dapat dilakukan dengan cara COD Cash On Delivery, yaitu pembeli dapat melakukan pembayaran ketika telah menerima pesanan ikan yang telah dibeli.</p>
								</div>
							</div>
						</div>
						<div class="panel">
							<div class="panel-header" id="headingThree">
								<button class="panel-link" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">Pengembalian Ikan</button>
							</div>
							<div id="collapse3" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
								<div class="panel-body">
									<h4>Pengembalian</h4>
									<p>Pembeli dibolehkan utuk komplain jika pesanan ataupun harga tidak sesuai dengan yang telah dipaparkan di aplikasi MugOn</p>
								</div>
							</div>
						</div>
					</div>
					<div class="social-sharing">
						<a href=""><i class="fa fa-google-plus"></i></a>
						<a href=""><i class="fa fa-pinterest"></i></a>
						<a href=""><i class="fa fa-facebook"></i></a>
						<a href=""><i class="fa fa-twitter"></i></a>
						<a href=""><i class="fa fa-youtube"></i></a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- product section end -->


	<!-- Bagian Produk Terbaru -->
	<section class="top-letest-product-section">
		<div class="container">
			<div class="section-title">
				<h2>Produk Terbaru</h2>
			</div>
			<div class="product-slider owl-carousel">

			<!-- menampilkan ikan yang dijual -->
			<?php 	
				$tampilIkan = $koneksi->query("SELECT * FROM ikan");
				$batas = mysqli_num_rows($tampilIkan);						//membatasi 
				while($variabel = mysqli_fetch_assoc($tampilIkan)){ ?>
				<?php if (!($batas > 6)) { ?>
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
						<?php echo "<h6>Rp. ". number_format($variabel['harga_ikan'],0,',','.')."/kg</h6>"?>
						<?php echo "<p>". $variabel['nama_ikan']."</p>"?>
					</div>
				</div>
				<?php } ?>
			<?php $batas--; }?>

			</div>
		</div>
	</section>
	<!-- akhir produk terbaru -->


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
