<!--Fungsi sudah terjadi Logout pada pembeli
@author : Raisya Husna Agustin
-->

<?php
	session_start(); // untuk menghapus session 
	session_destroy();
	unset($_SESSION["user"]);
	echo "<script>alert('anda telah logout');</script>";
	echo "<script>location='login.php'</script>";
?>
