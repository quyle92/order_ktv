<?php 
require('lib/db.php');
@session_start();
$id=$_SESSION['MaNV'];
$bill = $_SESSION['MaLichSuPhieu'];
$madichvu = $_SESSION['MaDichVu'];
//
//	lay giá trị từ evaluate_admin truyền qua
//

if(isset($_POST['question1']))
{
	$question1=$_POST['question1'];
	$sql="INSERT INTO tblBangDanhGia(Ngay,MaNV,MaCauHoi)  VALUES (GETDATE(),'$id','$question1')";
	$rs=sqlsrv_query($conn,$sql);
	
		$sql = "Update tblTheoDoiPhucVuSpa_ChiTiet set KhachDanhGia = '".$question1."' Where TenNV like N'".$id."' and MaHangBan like '".$madichvu."' and MaPhieuDieuTour like '".$bill."'";
	$rs1=sqlsrv_query($conn,$sql);
	
}

if(isset($_POST['question2']))
{
	$question2=$_POST['question2'];
	$sql="INSERT INTO tblBangDanhGia(Ngay,MaNV,MaCauHoi)  VALUES (GETDATE(),'$id','$question2')";
	$rs=sqlsrv_query($conn,$sql);
	
	$sql = "Update tblTheoDoiPhucVuSpa_ChiTiet set KhachDanhGia = '".$question2."' Where TenNV like N'".$id."' and MaHangBan like '".$madichvu."' and MaPhieuDieuTour like '".$bill."'";
	$rs1=sqlsrv_query($conn,$sql);
}

if(isset($_POST['question3']))
{
	$question3=$_POST['question3'];
	$sql="INSERT INTO tblBangDanhGia(Ngay,MaNV,MaCauHoi)  VALUES (GETDATE(),'$id','$question3')";
	$rs=sqlsrv_query($conn,$sql);
	
	$sql = "Update tblTheoDoiPhucVuSpa_ChiTiet set KhachDanhGia = '".$question3."' Where MaNV like '".$id."' and MaHangBan like '".$madichvu."' and MaPhieuDieuTour like '".$bill."'";
	$rs1=sqlsrv_query($conn,$sql);
}

if(isset($_POST['question4']))
{
	$question4=$_POST['question4'];
	 $sql="INSERT INTO tblBangDanhGia(Ngay,MaNV,MaCauHoi)  VALUES (GETDATE(),'$id','$question4')";
	$rs=sqlsrv_query($conn,$sql);
	
	$sql = "Update tblTheoDoiPhucVuSpa_ChiTiet set KhachDanhGia = '".$question4."' Where MaNV like '".$id."' and MaHangBan like '".$madichvu."' and MaPhieuDieuTour like '".$bill."'";
	$rs1=sqlsrv_query($conn,$sql);
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