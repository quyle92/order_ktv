<?php 
require('lib/db.php');
require('functions/lichsuphieu.php');
@session_start();
$id=$_SESSION['MaNV'];
$bill = $_SESSION['MaLichSuPhieu'];
$madichvu = $_SESSION['MaDichVu'];
$matrungtam = $_SESSION['MaTrungTam'];

if(!isset($_SESSION['MaLichSuPhieu'])) 
{
?>
<script>
		window.onload=function(){
		alert("Chỉ sử dụng chức năng này khi bạn có điều tour !");
			setTimeout('window.location="home_ktv.php"',0);
		}
</script>
<?php
}

$sql="SELECT a.*,b.Ten as NhomNhanVien FROM tblDMNHANVIEN a, tblDMNhomNhanVien b WHERE a.NhomNhanVien = b.Ma and a.MaNV = '$id'";
$rs=sqlsrv_query($conn,$sql);
$r=sqlsrv_fetch_array($rs);

$now = substr(date('Ymd'),2);
$pre_orderid = '03-'.$now;
//echo "Order id created :".$pre_orderid;

if(isset($_POST['rad']))
{
	//echo "You have selected :".$_POST['rad'];  //  Displaying Selected Value
	$tientip = $_POST['rad'];
	if ($tientip == "khac")
		$tientip = $_POST['tientip'];
	
	if (!is_numeric($tientip))
		$tientip = 0;
	
	$sql = "Update tblTheoDoiPhucVuSpa_ChiTiet set KhachTip = '".$tientip."', IsDaXuLy = 1 Where MaNV like '".$id."' and MaHangBan like '".$madichvu."' and MaPhieuDieuTour like '".$bill."'";
	$rs1=sqlsrv_query($conn,$sql);
	
	//$sql = "Update tblLichSuPhieu set TienGio = TienGio + '".$tientip."' Where DaTinhTien = 0 and LEFT(MaLichSuPhieu,2) like '".$matrungtam."' and MaLichSuPhieu in (Select ISNULL(MaLichSuPhieuTT,'".$bill."') from tblLichSuPhieu where MaLichSuPhieu like '".$bill."')";
	//$rs1=sqlsrv_query($conn,$sql);
?>
<script>
		setTimeout('window.location="home_ktv.php"',0);
</script>
<?php
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
    		<h2 style="font-size:3vw; color:#fff; text-align:center">MỜI QUÝ KHÁCH NHẬP TIỀN TIP</h2> 
		</div>
	</div>
</div>
<div class="row fixbox"> </div>
<div class="clear20"></div>
<form action="evaluate_tip.php" method="post" >
<div class="row" style="text-align:center;">
            <div class="col-md-2" style="text-align:center; padding-top:10px;"><input id="rad1" type="radio" value="100000" name="rad"/><label for="rad1">100,000 đ</label></div>
			<div class="col-md-2" style="text-align:center; padding-top:10px;"><input id="rad2" type="radio" value="200000" name="rad"/><label for="rad2">200,000 đ</label></div>
			<div class="col-md-2" style="text-align:center; padding-top:10px;"><input id="rad3" type="radio" value="300000" name="rad"/><label for="rad3">300,000 đ</label></div>
			<div class="col-md-2" style="text-align:center; padding-top:10px;"><input id="rad4" type="radio" value="500000" name="rad"/><label for="rad4">500,000 đ</label></div>
			<div class="col-md-2" style="text-align:center; padding-top:10px;"><input id="rad5" type="radio" value="0" name="rad"/><label for="rad5">Không TIP</label></div>
			<div class="col-md-2" style="text-align:center; padding-top:10px;"><input id="rad6" type="radio" value="khac" name="rad"/><label for="rad6">Số Khác:</label>
			<input type="text" name="tientip" value="<?php //echo @$denngay ?>" style="width:40%;"></div>
	<div class="col-md-12" style="text-align:center; padding-top:10px;">
	<button type="submit" style="margin-left:20px; padding-left:20px; padding-right:20px; background:#0073aa; color:#fff; line-height:34px; border: 2px solid transparent;">Đồng ý</button>
	</div>
</div>
</form>
</body>
</html>