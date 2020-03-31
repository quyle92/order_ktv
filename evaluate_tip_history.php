<?php
require('lib/db.php');
session_start();
if(!isset($_SESSION['MaNV'])) 
{
?>
<script>
		setTimeout('window.location="login.php"',0);
</script>
<?php
}

$id=$_SESSION['MaNV'];

$stt = $_POST['stt'];
$bill = $_POST['malichsuphieu'];
$magiuong = $_POST['magiuong'];
$makhach = $_POST['makhach'];
$tenkhach = $_POST['tenkhach'];
$dienthoai = $_POST['dienthoai'];
$manv = $_POST['manv'];
$tennv = $_POST['tennv'];
$mahangban = $_POST['mahangban'];
$tenhangban = "";
$thoigianlam = 0;
$khachdanhgia = $_POST['khachdanhgia'];

if(!isset($_POST['stt']) || $stt == null || $stt == "") //khong phu thuoc ma phieu
{
?>
<script>
		window.onload=function(){
		alert("Chỉ có thể nhập đánh giá khi đã xử lý !");
			setTimeout('window.location="home_admin_history.php"',0);
		}
</script>
<?php
}//end check co ma giuong

if (isset($_POST['btn_update'])) 
{
	//echo "click update";
	if($mahangban != null && $mahangban != "")
	{
		$l_sql = "Select * from tblDMHangBan Where MaHangBan = '$mahangban'";
		try
		{
			$rs1=sqlsrv_query($conn,$l_sql);
			while($r1=sqlsrv_fetch_array($rs1))
			{
				$tenhangban = $r1['TenHangBan'];
				$thoigianlam = $r1['ThoiGianLam'];
			}
			sqlsrv_free_stmt( $rs1);
		}
		catch (Exception $e) {
			echo $e->getMessage();
		}
		if($thoigianlam == null || $thoigianlam == "")
		{
			$thoigianlam = 0;
		}
	}

	//if(isset($_POST['rad']))
	//{
	//	//echo "You have selected :".$_POST['rad'];  //  Displaying Selected Value
	//	$tientip = $_POST['rad'];
	//	if ($tientip == "khac")
	//		$tientip = $_POST['tientip'];
	
	//	if (!is_numeric($tientip))
		$tientip = 0;
	
		try
		{
			$sql = "Update tblTheoDoiPhucVuSpa_ChiTiet set KhachTip = '$tientip', KhachDanhGia = N'$khachdanhgia', MaBanPhong = '$magiuong',MaNV = '$manv', TenNV = N'$tennv',MaHangBan = '$mahangban', DienThoaiKH = '$dienthoai',TenHangBan = N'$tenhangban',MaKhachHang = '$makhach',TenKhachHang = N'$tenkhach',ThoiGianLam ='$thoigianlam', IsDaXuLy = 1 Where Stt = '$stt'";
				//echo $sql;
			
			$rs4=sqlsrv_query($conn,$sql);
		}
		catch (Exception $e) {
			echo $e->getMessage();
		}
	//}//end if check rad post
?>
<script>
		setTimeout('window.location="home_admin_history.php"',0);
</script>
<?php
}
else if (isset($_POST['btn_cancel'])) 
{
?>
<script>
		setTimeout('window.location="home_admin_history.php"',0);
</script>
<?php
}
?>
