<?php
	
	$koneksi = new mysqli("localhost", "root", "", "mugon");

	$koneksi->query("DELETE FROM pesan WHERE id_pesan = '$_GET[id]'");

	echo "<script>alert('pesan dihapus');</script>";
	echo "<script>location='pesan.php'</script>";

?>