<?php 
	session_start();
	// pengkoneksian database
	$koneksi = new mysqli("localhost", "root", "", "mugon");

	//mendapatkan id dari url
	$id_ikan = $_GET['id'];
	$ambil = $koneksi->query("SELECT * FROM ikan WHERE id_ikan = '$id_ikan' ");
	$pecah = $ambil->fetch_assoc();

	// pengkondisian dalam pembelian
	if ($pecah['stok_ikan'] <= 0) {
		echo "<script>alert('Ikan Habis..!');</script>";
		echo "<script>location='index.php'</script>";
	}else if (isset($_GET['cek'])) {
		if ($_GET['banyak'] > $pecah['stok_ikan']) {
			echo "<script>alert('stok tidak mencukupi');</script>";
			echo "<script>location='detail_ikan.php?id=".$id_ikan."'</script>";
		}else{
			$_SESSION['keranjang'][$id_ikan] = $_GET['banyak'];
		}
	}else if (isset($_SESSION['keranjang'][$id_ikan])) {
		$_SESSION['keranjang'][$id_ikan]+=1;
	}else{
		$_SESSION['keranjang'][$id_ikan] = 1;
	}

	if ($_SESSION['keranjang'][$id_ikan] > $pecah['stok_ikan']) {
		echo "<script>alert('stok tidak mencukupi');</script>";
		$_SESSION['keranjang'][$id_ikan]-=1;
		echo "<script>location='detail_ikan.php?id=".$id_ikan."'</script>";
	}

	echo "<script>location='keranjang.php'</script>";
