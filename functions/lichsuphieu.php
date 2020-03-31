<?php

function TaoOrder($conn,$orderid,$manv,$malichsuphieu,$mahangban,$madvt,$soluong,$dongia,$thanhtien,$tenhangban)
{
	try {
	$sql = "Insert into tblOrder(OrderID,MaNV,MaLichSuPhieu,ThoiGian,TrangThai,TenNV) values('";
	$sql = $sql.$orderid."','".$manv."','".$malichsuphieu."',GETDATE(),'1','')";
	$rs=sqlsrv_query($conn,$sql);
	
	$sql = "Insert into tblOrderChiTiet(OrderID,MaHangBan,MaDVT,SoLuong,DonGia,YeuCauThem,ThoiGian,MaSuCo,TenHangBan,LyDo,MaNVLienQuan,GhiChuKMHB,KeyString) values('";
	$sql = $sql.$orderid."','".$mahangban."','".$madvt."','".$soluong."','".$dongia."','',GETDATE(),'','".$tenhangban."','','".$manv."','','')";
	$rs=sqlsrv_query($conn,$sql);
	
	$sql = "Insert into tblLSPhieu_HangBan(ID,MaLichSuPhieu,MaHangBan,TenHangBan,SoLuong,MaDVT,DonGia,ThanhTien,MaNhanVien,ThoiGianBan,MaSuCo,LyDo,
		DaXuLy,OrderID,DonGiaTT,MaTienTe,ThanhTienTT,GhiChuKMHB) values('";
	$id_hangban = $malichsuphieu."-".$mahangban."-".(string)date('His');
	$sql = $sql.$id_hangban."','".$malichsuphieu."','".$mahangban."','".$tenhangban."','".$soluong."','".$madvt."','".$dongia."','".$thanhtien."','".$manv."',GETDATE(),'','','1','".$orderid."','".$dongia."','VND','".$thanhtien."','')";
	$rs=sqlsrv_query($conn,$sql);
	} 
	catch (Exception $e) 
	{
    echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
}

function UpdateThoiGianLam($conn,$manv,$maphieudieutour,$mahangban, $thoigianbatdau, $thoigianketthuc, $thoigianlam)
{
	try 
	{
		//$sql = "Update tblLichSuPhieu Set GioVao =  '".$thoigianbatdau."', GioTra = '".$thoigianketthuc."', ThoiGianLam = '".$thoigianlam."' where MaLichSuPhieu like '".$maphieudieutour."'";
		//$rs=sqlsrv_query($conn,$sql);
			
		$sql = "Update tblTheoDoiPhucVuSpa_ChiTiet Set GioThucHien = '".$thoigianbatdau."', GioKetThuc = '".$thoigianketthuc."' Where MaNV like '".$manv."' and MaHangBan like '".$mahangban."' and MaPhieuDieuTour like '".$maphieudieutour."'";
		$rs=sqlsrv_query($conn,$sql);
	} 
	catch (Exception $e) 
	{
    echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
}

function UpdateKetThucTour($conn,$manv,$maphieudieutour,$mahangban)
{
	try 
	{
		//$sql = "Update tblLichSuPhieu Set GioVao =  '".$thoigianbatdau."', GioTra = '".$thoigianketthuc."', ThoiGianLam = '".$thoigianlam."' where MaLichSuPhieu like '".$maphieudieutour."'";
		//$rs=sqlsrv_query($conn,$sql);
			
		$sql = "Update tblTheoDoiPhucVuSpa_ChiTiet Set IsDaXuLy = '1' Where MaNV like '".$manv."' and MaHangBan like '".$mahangban."' and MaPhieuDieuTour like '".$maphieudieutour."'";
		$rs=sqlsrv_query($conn,$sql); 
		
		$sql = "Update tblTheoDoiPhucVuSpa Set TinhTrang = '0' Where MaNV like '".$manv."'";
		
		$rs=sqlsrv_query($conn,$sql);
	} 
	catch (Exception $e) 
	{
    echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
}

function InsertLichSuRaVao($conn,$id)
{
	try 
	{	
		//echo date('Y/m/d');
			
		$sql = "Select * from tblHR_QuetTheChamCong Where MaNhanVien like '".$id."' and Convert(varchar,GioVao,111) = '".date('Y/m/d')."'";
		$rs1=sqlsrv_query($conn,$sql);
		$r1=sqlsrv_fetch_array($rs1);
		if(is_null($rs1) || !isset($r1["MaNhanVien"]))
		{
				$sql = "Insert into tblHR_QuetTheChamCong(MaThe,GioVao,GioRa,MaNhanVien,DacBiet,MaSoTram) values('";
				$sql = $sql.$id."',GETDATE(),GETDATE(),'".$id."','0','1')";
				$rs=sqlsrv_query($conn,$sql);
		}
		else
		{
			$sql = "Update tblHR_QuetTheChamCong set GioRa = GETDATE(),ThoiGianLamViec = DATEDIFF(minute,GioVao,GETDATE()) where MaNhanVien like '".$id."' and Convert(varchar,GioVao,111) = '".date('Y/m/d')."'";
			$rs=sqlsrv_query($conn,$sql);
		}
	} 
	catch (Exception $e) 
	{
    echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
}
	
?>
	
		
	