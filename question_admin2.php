<?php 
require('lib/db.php');
@session_start();
$id=$_SESSION['MaNV'];
$tennv = $_SESSION['TenKTV'];
$stt = $_SESSION['Stt'];
//
//	lay giá trị từ evaluate_admin truyền qua
//
if(isset($_POST['question5']))
{
	$question5=$_POST['question5'];
	//
	//	insert đánh giá
	//
	$sql="INSERT INTO tblBangDanhGia(Ngay,TenNV,MaCauHoi)  VALUES (GETDATE(),'$tennv','$question5')";
	$rs=sqlsrv_query($conn,$sql);
	//
	//	update kết quả đánh giá
	//
	$sql = "Update tblTheoDoiPhucVuSpa_ChiTiet set KhachDanhGia = '$question5' Where Stt = '$stt'";
	$rs1=sqlsrv_query($conn,$sql);
}

if(isset($_POST['question6']))
{
	$question6=$_POST['question6'];
	//
	//	insert đánh giá
	//
	$sql="INSERT INTO tblBangDanhGia(Ngay,TenNV,MaCauHoi)  VALUES (GETDATE(),'$tennv','$question6')";
	$rs=sqlsrv_query($conn,$sql);
	//
	//	update kết quả đánh giá
	//
	$sql = "Update tblTheoDoiPhucVuSpa_ChiTiet set KhachDanhGia = '$question6' Where Stt = '$stt'";
	$rs1=sqlsrv_query($conn,$sql);
}

if(isset($_POST['question7']))
{
	$question7=$_POST['question7'];
	//
	//	insert đánh giá
	//
	$sql="INSERT INTO tblBangDanhGia(Ngay,TenNV,MaCauHoi)  VALUES (GETDATE(),'$tennv','$question7')";
	$rs=sqlsrv_query($conn,$sql);
	//
	//	update kết quả đánh giá
	//
	$sql = "Update tblTheoDoiPhucVuSpa_ChiTiet set KhachDanhGia = '$question7' Where Stt = '$stt'";
	$rs1=sqlsrv_query($conn,$sql);
}

if(isset($_POST['question8']))
{
	$question8=$_POST['question8'];
	//
	//	insert đánh giá
	//
	$sql="INSERT INTO tblBangDanhGia(Ngay,TenNV,MaCauHoi)  VALUES (GETDATE(),'$tennv','$question8')";
	$rs=sqlsrv_query($conn,$sql);
	//
	//	update kết quả đánh giá
	//
	$sql = "Update tblTheoDoiPhucVuSpa_ChiTiet set KhachDanhGia = '$question8' Where Stt = '$stt'";
	$rs1=sqlsrv_query($conn,$sql);
}
		
?>
<!doctype html>
<html>
<head>
<title>Giải pháp quản lý SPA toàn diện - ZinSPA</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Phần mềm quản lý SPA ZinSpa" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/evaluate.css">
<!-- jQuery -->
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
</head>
<body>
<div class="wrapper relative wrap_header">
	<div class="row fixbox">
		<div class="col-md-12"> 
    		<h2 style="font-size:3vw; color:#fff; text-align:center">MỜI QUÝ KHÁCH ĐÁNH GIÁ DỊCH VỤ</h2> 
		</div>
	</div>
</div>
<div class="row fixbox">
 	<div class="col-md-12">
 		<div class="bs-example4" data-example-id="contextual-table">
    		<div class="table-responsive">
     			<form action="thankyou.php" method="post">
      				<table class="table">
          				<tr>
            				<td width="7%"></td>
            				<td width="11%"></td>
             				<th width="19%" scope="row">Ghi chú:</th>
            				<td width="22%"><input name="ghichu" type="text" size="35" value=""></td>
            				<td width="27%"></td>
            				<td width="14%"></td>
          				</tr>
          				<tr>
            				<td width="7%"></td>
            				<td width="11%"></td>
             				<th width="19%" scope="row">Số điện thoại:</th>
            				<td width="22%"><input name="dienthoai" type="text" size="35" value=""></td>
            				<td width="27%"></td>
            				<td width="14%"></td>
          				</tr>
          				<tr>
            				<td></td>
            				<td></td>
            				<td></td>
            				<td><input name="submit" type="submit" value="Xác nhận"></td>
            				<td></td>
            				<td></td>
          				</tr>
                	</table>
      			</form>
    		</div><!-- /.table-responsive -->
    	</div>	
	</div>
 </div>
<div class="clear20"></div>
</body>
</html>