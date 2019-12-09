<!--Fungsi sudah terjadi Logout
@author : Raisya Husna Agustin
-->

<?php
	session_start();
	session_destroy(); // untuk menghapus session
	unset($_SESSION["mugee"]);
	echo "<script>alert('anda telah logout');</script>";
	echo "<script>location='../login.php'</script>";
?>
