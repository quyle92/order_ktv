<?php 
require('lib/db.php');
@session_start();
$id=$_SESSION['MaNV'];
$tennv = $_SESSION['TenKTV'];
$stt = $_SESSION['Stt'];
//
//	 lay gia tri tu question_admin2.php
//
$dienthoai = $_POST['dienthoai'];
$ghichu = $_POST['ghichu'];

if($stt != "" && $stt != null)
{
	//
	//	update kết quả đánh giá
	//
	$sql = "Update tblTheoDoiPhucVuSpa_ChiTiet set DienThoaiKH = '$dienthoai', GhiChu = N'$ghichu' Where Stt = '$stt'";
	$rs1=sqlsrv_query($conn,$sql);
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Giải pháp quản lý SPA toàn diện - ZinSPA</title>
</head>

<body style="background-color:#e6f0fc">
<div style="margin: 20%">
 <h1 style="text-align:center; color:#4c64ea; font-family:Arial, Helvetica, sans-serif">CHÂN THÀNH CẢM ƠN QUÝ KHÁCH !</h1>
 </div>
</body>
</html>

<script>
		setTimeout('window.location="home_admin_history.php"',2000);
</script>