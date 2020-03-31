<?php 
require('lib/db.php');
require('functions/lichsuphieu.php');

@session_start();//session_destroy();
//error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
date_default_timezone_set('Asia/Bangkok');

if(!isset($_SESSION['MaNV'])) 
{
?>
<script>
		//setTimeout('window.location="login.php"',0);
</script>
<?php
}
if(isset($_POST['maphieu']))
{
	 $maphieu = $_POST['maphieu'];
}
if(isset($_GET['maphieu']))
{
	 $maphieu = $_GET['maphieu'];
}
if(isset($_SESSION['maphieu']))
{
	 $maphieu = $_SESSION['maphieu'];
}
var_dump ($maphieu);
var_dump ($magiuong = $_POST['magiuong']);
 ($makhu = $_SESSION['makhu'] );
if ($maphieu == NULL OR $maphieu == "") {
/*MaLichSuPhieu: 03-1-20150823-0456 [tblLichSuPhieu]*/
	$maphieu = "03-1-".date("Ymd")."-";
	$l_sql = "Select MAX(Right(MaLichSuPhieu,4)) as iBooking from tblLichSuPhieu ";
			$l_index = 0;	
			try
			{
				$result_mabooking = sqlsrv_query($conn,$l_sql);
				while($rbk=sqlsrv_fetch_array($result_mabooking))
				{
						$l_index = intval($rbk['iBooking'])."<Br>";
				}

				sqlsrv_free_stmt( $result_mabooking);
			}
			catch(Exception $e) { $l_index = 0; }
		 
			$l_index = $l_index + 1;
			$maphieu = $maphieu.$l_index;
			$giovao=date('Y-m-d  H:i:s');
			 "<br>".$tongtien=$_SESSION['tongtien'];
/*End MaLichSuPhieu: 03-1-20150823-0456 [tblLichSuPhieu]*/

	/*[tblOrder] OrderID: 03-150819-0001*/
	$orderID = "03-".date("ymd")."-0";
	$l_sql_order = "Select MAX(Right(OrderID,3)) as iBooking from [tblOrder] ";
			$l_index = 0;	
			try
			{
				$result_mabooking = sqlsrv_query($conn,$l_sql_order);
				while($rbk=sqlsrv_fetch_array($result_mabooking))
				{
						$l_index = intval($rbk['iBooking'])."<Br>";
				}

				sqlsrv_free_stmt( $result_mabooking);
			}
			catch(Exception $e) { $l_index = 0; }
		 
			$l_index = $l_index + 1;
			 $orderID = $orderID.$l_index;
			
	/*End [tblOrder] OrderID: 03-150819-0001*/
	$makh = "KH-00";
	$l_sql_makh = "Select MAX(Right(MaKhachHang,3)) as iBooking from [tblLichSuPhieu] ";
			$l_index = 0;	
			try
			{
				$result_mabooking = sqlsrv_query($conn,$l_sql_makh);
				while($rbk=sqlsrv_fetch_array($result_mabooking))
				{
						$l_index = intval($rbk['iBooking'])."<Br>";
				}

				sqlsrv_free_stmt( $result_mabooking);
			}
			catch(Exception $e) { $l_index = 0; }
		 
			$l_index = $l_index + 1;
			 echo $makh = $makh.$l_index;
	/*tạo makhachhang*/
	
	/*End tạo makhachhang*/
	 $thoigian=date('Y-m-d  H:i:s');
	echo  $sql = "
	INSERT INTO  tblLichSuPhieu (MaLichSuPhieu,MaBan,GioVao,DangNgoi,MaKhachHang, TongTien,TienThucTra,TienDichVu,NVTaoMaNV,MaKhu,KeyString) 
	VALUES ('$maphieu','$magiuong','$giovao',1,'$makh','$tongtien','$tongtien','$tongtien','cashierspa1','$makhu','$magiuong');
	INSERT INTO  tblOrder 	(OrderID,MaNV,MaLichSuPhieu,ThoiGian,TrangThai,TenNV,OrderKey)
	VALUES ('$orderID','cashierspa2','$maphieu','$thoigian','1','cashierspa2','$magiuong');
		";
		$stmt = sqlsrv_query($conn, $sql);
/*End [tblOrder] OrderID: 03-150819-0001*/

/*[tblOrderChiTiet] */
	reset($_SESSION['TenHangBan']);
	reset($_SESSION['Gia']);
	reset($_SESSION['SoLuong']);
	for ($i = 0; $i< count( $_SESSION['TenHangBan']) ; $i++)
	{
			( $mahangban=key($_SESSION['TenHangBan']) );
			( $tenHB=current($_SESSION['TenHangBan']) );
			( $giaHB=current($_SESSION['Gia']) );
			$soluong=current($_SESSION['SoLuong']);
			$tien=$soluong*$giaHB;
	  $sql_order_chitiet = "
	 INSERT INTO  [tblOrderChiTiet] (OrderID,MaHangBan,MaDVT,SoLuong,DonGia,ThoiGian,TenHangBan)
	 VALUES ('$orderID','$mahangban','s','$soluong','$giaHB','$thoigian','$tenHB')
	 ";	
	 $stmt = sqlsrv_query($conn, $sql_order_chitiet);
		next($_SESSION['TenHangBan']);
		next($_SESSION['Gia']);
		next($_SESSION['SoLuong']);
	}
/*End [tblOrderChiTiet] */

/*[tblLSPhieu_HangBan]*/
	reset($_SESSION['TenHangBan']);
	reset($_SESSION['Gia']);
	reset($_SESSION['SoLuong']);
	for ($i = 0; $i< count( $_SESSION['TenHangBan']) ; $i++)
	{
		/*lấy id*/
		$id = "03-1-".date("Ymd")."-0276-20144027-";
		$l_sql_phieu_bh_id = "Select MAX(Right(id,9)) as iBooking from [tblLSPhieu_HangBan] ";
		$l_index = 0;	
		try
			{
				$result_mabooking = sqlsrv_query($conn,$l_sql_phieu_bh_id);
				while($rbk=sqlsrv_fetch_array($result_mabooking))
				{
					$l_index = intval($rbk['iBooking'])."<Br>";
				}

				sqlsrv_free_stmt( $result_mabooking);
			}
		 catch(Exception $e) { $l_index = 0; }
		 /*End lấy id*/
		 
		 /*tạo id mới*/
		$l_index = $l_index + 1;
		$id = $id.$l_index;
		/*End tạo id mới*/	
		
			( $mahangban=key($_SESSION['TenHangBan']) );
			( $tenHB=current($_SESSION['TenHangBan']) );
			( $giaHB=current($_SESSION['Gia']) );
			$soluong=current($_SESSION['SoLuong']);
			$tien=$soluong*$giaHB;
	echo"<br>". $sql_phieu_hb = "
	INSERT INTO [tblLSPhieu_HangBan]
	(ID,MaLichSuPhieu,MaHangBan,TenHangBan,SoLuong,MaDVT,DonGia
		  ,ThanhTien
		  ,MaNhanVien
		  ,ThoiGianBan 
		  ,DaTruKho
		  ,DaXuLy
		  ,OrderID
		  ,DonGiaTT
		  ,MaTienTe
		  ,ThanhTienTT 
		  ,DaThanhToan)
	VALUES ('$id','$maphieu','$mahangban','$tenHB','$soluong','s',$giaHB,$tien,'cashierspa1','$thoigian',0,0,'$orderID','$tien','VND','$tien',1)
	";
	 $stmt = sqlsrv_query($conn, $sql_phieu_hb);
		next($_SESSION['TenHangBan']);
		next($_SESSION['Gia']);
		next($_SESSION['SoLuong']);
	}
	$xongroi="ok";
/*End [tblLSPhieu_HangBan]*/
}
######################################
if ( $xongroi!="ok") {
	if ($maphieu != NULL OR $maphieu != "" )
	{	
	/*[tblLichSuPhieu] MaLichSuPhieu: 03-1-20150823-0456 */
		echo "<br>".$tongtien=$_SESSION['tongtien'];
		$sql_tong_tien = "SELECT TongTien FROM [tblLichSuPhieu] WHERE  MaLichSuPhieu = '$maphieu' ";
		try
		{
			$result_tong_tien = sqlsrv_query($conn,$sql_tong_tien);
			echo $r_tong_tien = sqlsrv_fetch_array($result_tong_tien)[0];echo "<Br>";
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
		$tongtien=$tongtien+$r_tong_tien;
	/* End [tblLichSuPhieu] MaLichSuPhieu: 03-1-20150823-0456 */

	/*[tblOrder] OrderID: 03-150819-0001*/
		$orderID = "03-".date("ymd")."-0";
		$l_sql_order = "Select MAX(Right(OrderID,3)) as iBooking from [tblOrder] ";
				$l_index = 0;	
				try
				{
					$result_mabooking = sqlsrv_query($conn,$l_sql_order);
					while($rbk=sqlsrv_fetch_array($result_mabooking))
					{
							$l_index = intval($rbk['iBooking'])."<Br>";
					}

					sqlsrv_free_stmt( $result_mabooking);
				}
				catch(Exception $e) { $l_index = 0; }
			 
				$l_index = $l_index + 1;
				echo $orderID = $orderID.$l_index;
				$thoigian=date('Y-m-d  H:i:s');
				$giovao=date('Y-m-d  H:i:s');
		echo"<br>". $sql = "
		UPDATE  tblLichSuPhieu SET TongTien = '$tongtien', TienThucTra = '$tongtien', TienDichVu = '$tongtien' WHERE MaLichSuPhieu = '$maphieu';
		INSERT INTO  tblOrder 	(OrderID,MaNV,MaLichSuPhieu,ThoiGian,TrangThai,TenNV,OrderKey)VALUES ('$orderID','cashierspa2','$maphieu','$thoigian','1','cashierspa2','$magiuong') ;
		 ";//	
		 $stmt = sqlsrv_query($conn, $sql);
	/* End [tblOrder] OrderID: 03-150819-0001*/

	/*[tblOrderChiTiet] */
		reset($_SESSION['TenHangBan']);
		reset($_SESSION['Gia']);
		reset($_SESSION['SoLuong']);
		for ($i = 0; $i< count( $_SESSION['TenHangBan']) ; $i++)
		{
				( $mahangban=key($_SESSION['TenHangBan']) );
				( $tenHB=current($_SESSION['TenHangBan']) );
				( $giaHB=current($_SESSION['Gia']) );
				$soluong=current($_SESSION['SoLuong']);
				$tien=$soluong*$giaHB;
		  $sql_order_chitiet = "
		 INSERT INTO  [tblOrderChiTiet] (OrderID,MaHangBan,MaDVT,SoLuong,DonGia,ThoiGian,TenHangBan)
		 VALUES ('$orderID','$mahangban','s','$soluong','$giaHB','$thoigian','$tenHB')
		 ";	
		 $stmt = sqlsrv_query($conn, $sql_order_chitiet);
			next($_SESSION['TenHangBan']);
			next($_SESSION['Gia']);
			next($_SESSION['SoLuong']);
		}
	/*End [tblOrderChiTiet] */	

	/*[tblLSPhieu_HangBan]*/
		reset($_SESSION['TenHangBan']);
		reset($_SESSION['Gia']);
		reset($_SESSION['SoLuong']);
		for ($i = 0; $i< count( $_SESSION['TenHangBan']) ; $i++)
		{
			/*lấy id*/
			$id = "03-1-".date("Ymd")."-0276-20144027-";
			$l_sql_phieu_bh_id = "Select MAX(Right(id,9)) as iBooking from [tblLSPhieu_HangBan] ";
			$l_index = 0;	
			try
				{
					$result_mabooking = sqlsrv_query($conn,$l_sql_phieu_bh_id);
					while($rbk=sqlsrv_fetch_array($result_mabooking))
					{
						$l_index = intval($rbk['iBooking'])."<Br>";
					}

					sqlsrv_free_stmt( $result_mabooking);
				}
			 catch(Exception $e) { $l_index = 0; }
			 /*End lấy id*/
			 
			 /*tạo id mới*/
			$l_index = $l_index + 1;
			$id = $id.$l_index;
			/*End tạo id mới*/	
			
				( $mahangban=key($_SESSION['TenHangBan']) );
				( $tenHB=current($_SESSION['TenHangBan']) );
				( $giaHB=current($_SESSION['Gia']) );
				$soluong=current($_SESSION['SoLuong']);
				$tien=$soluong*$giaHB;
		 $sql_phieu_hb = "
		INSERT INTO [tblLSPhieu_HangBan]
		(ID,MaLichSuPhieu,MaHangBan,TenHangBan,SoLuong,MaDVT,DonGia
			  ,ThanhTien
			  ,MaNhanVien
			  ,ThoiGianBan 
			  ,DaTruKho
			  ,DaXuLy
			  ,OrderID
			  ,DonGiaTT
			  ,MaTienTe
			  ,ThanhTienTT 
			  ,DaThanhToan)
		VALUES ('$id','$maphieu','$mahangban','$tenHB','$soluong','s',$giaHB,$tien,'cashierspa1','$thoigian',0,0,'$orderID','$tien','VND','$tien',1)
		";
		 $stmt = sqlsrv_query($conn, $sql_phieu_hb);
			next($_SESSION['TenHangBan']);
			next($_SESSION['Gia']);
			next($_SESSION['SoLuong']);
		}
	/*End [tblLSPhieu_HangBan]*/
	}
}
########################

echo $_SESSION['maphieu'] = $maphieu ;//để lưu lại mã phiếu khi quay lại trang order.php
echo $_SESSION['magiuong'] = $magiuong ;
?>
<button type="submit" class="btn" style="color:red"><a href="order.php">back</a></button>