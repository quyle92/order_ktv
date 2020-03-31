<?php 
require('lib/db.php');
@session_start();
$id=$_SESSION['MaNV'];
$tennv = $_SESSION['TenKTV'];
$stt = $_SESSION['Stt'];
//
//	lay giá trị từ evaluate_admin truyền qua
//
if(isset($_POST['question1']))
{
	$question1=$_POST['question1'];
	//
	//	insert đánh giá
	//
	$sql="INSERT INTO tblBangDanhGia(Ngay,TenNV,MaCauHoi)  VALUES (GETDATE(),'$tennv','$question1')";
	$rs=sqlsrv_query($conn,$sql);
	//
	//	update kết quả đánh giá
	//
	$sql = "Update tblTheoDoiPhucVuSpa_ChiTiet set KhachDanhGia = '$question1' Where Stt = '$stt'";
	$rs1=sqlsrv_query($conn,$sql);
}

if(isset($_POST['question2']))
{
	$question2=$_POST['question2'];
	//
	//	insert đánh giá
	//
	$sql="INSERT INTO tblBangDanhGia(Ngay,TenNV,MaCauHoi)  VALUES (GETDATE(),'$tennv','$question2')";
	$rs=sqlsrv_query($conn,$sql);
	//
	//	update kết quả đánh giá
	//
	$sql = "Update tblTheoDoiPhucVuSpa_ChiTiet set KhachDanhGia = '$question2' Where Stt = '$stt'";
	$rs1=sqlsrv_query($conn,$sql);
}

if(isset($_POST['question3']))
{
	$question3=$_POST['question3'];
	//
	//	insert đánh giá
	//
	$sql="INSERT INTO tblBangDanhGia(Ngay,TenNV,MaCauHoi)  VALUES (GETDATE(),'$tennv','$question3')";
	$rs=sqlsrv_query($conn,$sql);
	//
	//	update kết quả đánh giá
	//
	$sql = "Update tblTheoDoiPhucVuSpa_ChiTiet set KhachDanhGia = '$question3' Where Stt = '$stt'";
	$rs1=sqlsrv_query($conn,$sql);
?>
<script>
	setTimeout('window.location="evaluate_admin2.php"',0);
</script>	
<?php
}

if(isset($_POST['question4']))
{
	$question4=$_POST['question4'];
	//
	//	insert đánh giá
	//
	$sql="INSERT INTO tblBangDanhGia(Ngay,TenNV,MaCauHoi)  VALUES (GETDATE(),'$tennv','$question4')";
	$rs=sqlsrv_query($conn,$sql);
	//
	//	update kết quả đánh giá
	//
	$sql = "Update tblTheoDoiPhucVuSpa_ChiTiet set KhachDanhGia = '$question4' Where Stt = '$stt'";
	$rs1=sqlsrv_query($conn,$sql);
?>
<script>
	setTimeout('window.location="evaluate_admin2.php"',0);
</script>	
<?php	
}
		
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CÔNG TY TNHH GIẢI PHÁP CÔNG NGHỆ ZINTECH</title>
</head>

<body style="background-color:#e6f0fc">
<div style="margin: 20%">
 <h1 style="text-align:center; color:#4c64ea; font-family:Arial, Helvetica, sans-serif">CHÂN THÀNH CẢM ƠN QUÝ KHÁCH !</h1>
 </div>
</body>
</html>

<script>
	setTimeout('window.location="home_admin.php"',2000);
</script>