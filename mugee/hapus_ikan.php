<!-- Bagian yang berfungsi untuk menghapus ikan bagi mugee -->
<?php


	
	$koneksi = new mysqli("localhost", "root", "", "mugon");    // untuk konek ke database //

	$ambil = $koneksi->query("SELECT * FROM ikan WHERE id_ikan = '$_GET[id]'");

	$pecah = $ambil->fetch_assoc();
	$gambarikan = $pecah['gambar_ikan'];
	if (file_exists("../img/Ikan/$gambarikan")) {
		unlink("../img/Ikan/$gambarikan");   // Untuk menghapus gambar // 
	}

	$koneksi->query("DELETE FROM ikan WHERE id_ikan = '$_GET[id]'");

	echo "<script>alert('produk terhapus');</script>";
	echo "<script>location='ikan.php'</script>";

?>