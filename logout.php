<?php
	session_start();
	unset($_SESSION['MaNV']);	
	unset($_SESSION['TenNV']);
	unset($_SESSION['TenTrungTam']);
	header('location:login.php');
?>