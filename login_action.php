<?php
require('lib/db.php');
session_start();
	$user=$_POST['username'];
	$pass=$_POST['password'];
	
	//Truy van DB de kiem tra
	$sql = "";
	if($user != "admin" && $user != "Admin")
	{
		$sql="select * FROM tblDMNhanVien WHERE MaNV='$user' AND MaThe='$pass'";
	}
	else
	{
		$sql="select PWDCOMPARE('$pass',MatKhau) as IsDungMatKhau, TenSD, b.MaNV,b.TenNV, b.MaTrungTam, c.TenTrungTam  
from tblDSNguoiSD a, tblDMNhanVien b, tblDMTrungTam c where a.MaNhanVien = b.MaNV and b.MaTrungTam = c.MaTrungTam and a.TenSD='$user'";
	}
	$rs=sqlsrv_query($conn,$sql);
	if(sqlsrv_has_rows($rs)===false)
	{
?>
		<script>
			window.onload=function(){
		alert("Đăng nhập không thành công. Sai email hoặc mật khẩu");
			setTimeout('window.location="login.php"',0);
		}
		</script>
<?php
	}
	else
	{
		
	 	$r=sqlsrv_fetch_array($rs);
		$r['MaNV'];				
		$r['TenNV'];
		$r['IsLogInWeb'];
		
			$_SESSION['MaNV']=$r['MaNV'];
			$_SESSION['TenNV']=$r['TenNV'];
			$_SESSION['MaTrungTam']=$r['MaTrungTam'];
			//if($r['IsLogInWeb'] == '1')
			//{

			//	<script>
			//		window.onload=function(){
			//			alert("Tài khoản đang đăng nhập ở thiết bị khác. Vui lòng signout trước khi bạn có thể đăng nhập.");
			//			setTimeout('window.location="login.php"',0);
			//		}
			//	<script>
//<?php
			//}
			//else
			//{
				if($user=="admin" || $user=="Admin")
				{
					header('location:home.php');
				}
				else
				{
					header('location:home_ktv.php');
				}
			//}
	}
?>
	
		
	