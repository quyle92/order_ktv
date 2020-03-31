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
$id = $_SESSION['MaNV'];
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
$stt = 0;

if(!isset($_POST['magiuong']) || $magiuong == null || $magiuong == "" || $tennv == null || $tennv == "")  
{
?>
<script>
		window.onload=function(){
		alert("Chỉ có thể nhập tip, đánh giá khi có thông tin phòng/giường, nhân viên !");
			setTimeout('window.location="home_admin.php"',0);
		}
</script>
<?php
}//end check co ma giuong, ten nv

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
			//echo $e->getMessage();
		}
		if($thoigianlam == null || $thoigianlam == "")
		{
			$thoigianlam = 0;
		}
	}//end check ma hang ban
	//
	//	check chọn tiền tip
	//
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
		//
			//	check co dieu tour chua ? chua co thi insert, nguoc lai update
			//
			$dadieutour = 0;
			$l_sql = "Select * from tblTheoDoiPhucVuSpa_ChiTiet Where MaBanPhong = '$magiuong' and IsDaXuLy = 0";
			try
			{
				$rs2=sqlsrv_query($conn,$l_sql);
				while($r2=sqlsrv_fetch_array($rs2))
				{
					if($r2['MaPhieuDieuTour'] != null && $r2['MaPhieuDieuTour'] != "")
					{
						$dadieutour = 1;
					}
				}
				sqlsrv_free_stmt( $rs2);
			}
			catch (Exception $e) {
				//echo $e->getMessage();
			}
					
			if($dadieutour == 0)
			{
				$ngay = date('Y-m-d');
				$giothuchien = date('Y-m-d H:i:s');
				$sql = "Insert into tblTheoDoiPhucVuSpa_ChiTiet(Ngay,MaCaThucHien, GioThucHien,GioKetThuc, MaNV, TenNV, MaBanPhong, MaHangBan, TenHangBan, MaKhachHang, TenKhachHang, LuotPhucVu, SaoYeuCau,MaNVLapPhieu, MaPhieuDieuTour, GiaHangBan, SoLuongHangBan, IsDaXuLy, ThoiGianLam, KhachTip, KhachDanhGia, GhiNo,DienThoaiKH) values('$ngay','','$giothuchien','$giothuchien','$manv',N'$tennv','$magiuong','$mahangban',N'$tenhangban','$makhach','$tenkhach','1','0','$id','$bill',0,1,1,'$thoigianlam','$tientip','1',1,'$dienthoai')";
				//echo $sql;
			}
			else
			{
				$sql = "Update tblTheoDoiPhucVuSpa_ChiTiet set KhachTip = '$tientip', KhachDanhGia = '1', MaBanPhong = '$magiuong',	MaNV = '$manv', TenNV = N'$tennv',MaHangBan = '$mahangban',TenHangBan = N'$tenhangban',MaKhachHang = '$makhach',TenKhachHang = N'$tenkhach',DienThoaiKH = '$dienthoai',ThoiGianLam ='$thoigianlam', IsDaXuLy = 1 Where MaBanPhong = '$magiuong' and IsDaXuLy = 0";
				//echo $sql;
			}

			$rs4=sqlsrv_query($conn,$sql);
			//
			//	lấy số thứ tự để lưu vào session -> xử lý cho phần đánh giá tiếp theo
			//
			$sql = "Select Top 1 * from tblTheoDoiPhucVuSpa_ChiTiet Where MaBanPhong = '$magiuong' Order by GioThucHien Desc";
			try
			{
				$rs5=sqlsrv_query($conn,$sql);
				while($r5=sqlsrv_fetch_array($rs5))
				{
					$stt = $r5['Stt'];
				}
				
				sqlsrv_free_stmt( $rs5);
			}
			catch (Exception $e) {
				//echo $e->getMessage();
			}
		}
		catch (Exception $e) {
			//echo $e->getMessage();
		}
	//}//end if check rad post tien tip

	if($stt != "")
	{
		$_SESSION['Stt'] = $stt;
		$_SESSION['TenKTV'] = $tennv;
?>
<script>
		setTimeout('window.location="evaluate_admin1.php"',0);
</script>
<?php
	}
	else
	{
?>
<script>
		setTimeout('window.location="home_admin.php"',0);
</script>
<?php
	}//end else check stt
}//end if click update
else if (isset($_POST['btn_cancel'])) 
{
?>
<script>
		setTimeout('window.location="home_admin.php"',0);
</script>
<?php
}
?>
