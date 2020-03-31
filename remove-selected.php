<?php
require('lib/db.php');
require('functions/lichsuphieu.php');

@session_start();
$id_arr=$_POST['id_arr'];
$_SESSION['maphieu']=$_POST['maphieu'];
echo $_SESSION['magiuong']=$_POST['magiuong'];
( $id_arr );
 for ($i=0;$i<count($_POST['id_arr']);$i++) {
	  ($mahangban_xoa=$id_arr[$i]);
	 unset($_SESSION['TenHangBan'][$mahangban_xoa]);
	 unset($_SESSION['SoLuong'][$mahangban_xoa]);
	 unset($_SESSION['Gia'][$mahangban_xoa]);
 }
header('location:order.php');
?>
<button type="submit" class="btn" style="color:red"><a href="order.php">back</a></button>