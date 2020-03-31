<?php 
require('lib/db.php');
require('functions/lichsuphieu.php');
@session_start();

date_default_timezone_set('Asia/Bangkok');

if(!isset($_SESSION['MaNV'])) 
{
?>
<script>
		setTimeout('window.location="login.php"',0);
</script>
<?php
}

$id=$_SESSION['MaNV'];
$tenktv = $_SESSION['TenNV'];
$trungtam = "TOKYO MASSAGE";
//
//---set tình trang nhân viên đang login
//
$sql="UPDATE tblDMNhanVien SET IsLogInWeb = 1 WHERE MaNV like '$id'";
$rs=sqlsrv_query($conn,$sql);

//---insert lich su ra vao
InsertLichSuRaVao($conn,$id);

//--09/12/2018: tam thoi bo phan loc tu ngay -> den ngay
$tungay=@$_POST['tungay'];
$denngay=@$_POST['denngay'];
if($tungay == "")
{
	$tungay = date('Y-m-d');
}
if($denngay == "")
{
	$denngay = date('Y-m-d');
}
//
//---láy thông tin điều tour gần nhất chưa xử lý
//
$sql = "select top 1 * from tblTheoDoiPhucVuSPA_chitiet where MaNV like '$id' and ISNULL(IsDaXuLy,0) = 0  
and MaPhieuDieuTour in (Select MaLichSuPhieu from tblLichSuPhieu where DangNgoi = 1 and PhieuHuy = 0) Order by MaPhieuDieuTour"; 
$rs1=sqlsrv_query($conn,$sql);
$r1=sqlsrv_fetch_array($rs1);

$phong = "";

$hoadon = $r1['MaPhieuDieuTour'];
$phong = $r1['MaBanPhong'];
$ngaythuchien = $r1['Ngay'];
$giothuchien = $r1['GioThucHien'];
$gioketthuc = $r1['GioKetThuc'];
$madichvu = $r1['MaHangBan'];
$tendichvu = $r1['TenHangBan'];
$khachhang = $r1['TenKhachHang'];
$sokey = $r1['KeyString'];
$ghichu = $r1['GhiChu'];
$thoigianlam = $r1['ThoiGianLam'];

if(!isset($r1['ThoiGianLam']))
{
	$thoigianlam = 0;
}

sqlsrv_free_stmt( $rs1);

$nhantour = "0";
if(@$_POST['nhantour'] != null)
{
	$nhantour = @$_POST['nhantour'];
}
else if(isset($_SESSION['NhanTour']))
{
	$nhantour = $_SESSION['NhanTour'];
}
else 
{
	$nhantour = "0";
}

if($nhantour == "1")
{
	//echo "da nhan tour"; -- update lại giờ vào làm
	//	$date = date('Y-m-j');
	//$newdate = strtotime ( '-10 minute' , strtotime ( $date ) ) ;
	//$newdate = date ( 'Y-m-j' , $newdate );
	$thoigianbatdau = date("Y-m-d H:i:s"); //echo "thoi gian dau: ".$thoigianbatdau;
	$sophut = "+".$thoigianlam." minute"; //echo "so phut: ".$sophut;
	$thoigianketthuc = strtotime($sophut,strtotime($thoigianbatdau));
	$thoigianketthuc = date('Y-m-d H:i:s', $thoigianketthuc); //echo "thoi gian ket thuc: ".$thoigianketthuc;
	
	UpdateThoiGianLam($conn,$id,$hoadon,$madichvu, $thoigianbatdau, $thoigianketthuc, $thoigianlam);
}

$ketthuctour = "0";
if(@$_POST['ketthuctour'] != null)
{
	$ketthuctour = @$_POST['ketthuctour'];
}
else if(isset($_SESSION['KetThucTour']))
{
	$ketthuctour = $_SESSION['KetThucTour'];
}
else
{
	$ketthuctour = "0";
}

if($nhantour == "0")
{
	$ketthuctour = "0";
}

//echo 'ketthuctour:'.$ketthuctour;
//echo 'nhan tour:'.$nhantour;
	
if($ketthuctour == "1")
{
	UpdateKetThucTour($conn,$id,$hoadon,$madichvu);
	$phong = "";
	$hoadon = "";
	$nhantour = "0";
}

$_SESSION['NhanTour'] = $nhantour;
$_SESSION['KetThucTour'] = $ketthuctour;
$_SESSION['MaLichSuPhieu'] = $hoadon;
$_SESSION['MaDichVu'] = $madichvu;

//echo 'ketthuctour2:'.$ketthuctour;

?>

<!DOCTYPE HTML>
<html>
<head>
<title>Giải pháp quản lý SPA toàn diện - ZinSPA</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Phần mềm quản lý SPA ZinSpa" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

 <!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style1.css" rel='stylesheet' type='text/css' />
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- jQuery -->

<!---//webfonts--->  
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
<style> 
#myDIV {
    margin: 10px; /*original: 25px */
    width: 100%; /*original: 550px */
    background: orange;
    position: relative;
    font-size: 20px; /*original: 20px */
    text-align: center;
    -webkit-animation: mymove 3s infinite; /* Chrome, Safari, Opera 4s */
    animation: mymove 3s infinite;
}

@media (min-width:768px){	
.titledieutour {
  font-size: 2em;
}
}

/* Chrome, Safari, Opera from {top: 0px;}
    to {top: 200px;}*/
@-webkit-keyframes mymove {
    from {top: 0px;}
    to {top: 0px;}
}

@keyframes mymove {
    from {top: 0px;}
    to {top: 0px;}
}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
}

/* The Close Button */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
</style>
</head>
<body>
<div id="wrapper">
     <!-- Navigation -->
        <nav class="top1 navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
                <a class="navbar-brand">CÔNG TY <?php echo $trungtam; ?></a>
            </div>
            <!-- /.navbar-header -->
			
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                         
                        <li>
                            <a href="home_ktv.php"><i class="fa fa-table nav_icon"></i>Yêu cầu điều tour<span class="fa arrow"></span></a> 
                        </li>
                        <li>
                            <a href="evaluate.php"><i class="fa fa-sitemap fa-fw nav_icon"></i>Khách hàng đánh giá<span class="fa arrow"></span></a>
                        </li>
						<li>
                            <a href="home_ktv2.php"><i class="fa fa-table nav_icon"></i>Danh sách tour đã làm<span class="fa arrow"></span></a> 
                        </li>
                         <li>
                            <a href="login.php"><i class="fa fa-user fa-fw nav_icon"></i>Đăng xuất<span class="fa arrow"></span></a>
                        </li>
                    </ul>
                </div>
               
            </div>
        </nav>
        <div id="page-wrapper">
        <div class="col-md-12 graphs">
	    <div class="xs">
       
            <div id="myDIV" class="titledieutour">THÔNG TIN ĐIỀU TOUR CHO <?php echo @$tenktv ?> - NGÀY <?php echo date('d-m-Y'); ?></div>
<!-- Trigger/Open The Modal 
<button id="myBtn">Open Modal</button>-->
<!-- The Modal -->
<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <h5>Bạn đang có tour</h5>
	<p>Phiếu : <?php echo $hoadon; ?></p>
	<p>Phòng : <?php echo $phong; ?></p>
	<p>Số Key : <?php echo $sokey; ?></p>
	<p>Giờ vào : <?php echo date_format($giothuchien,'H:i:s'); ?></p>
	<p>Dịch vụ : <?php echo $tendichvu; ?></p>
	<p>Khách hàng : <?php echo $khachhang; ?></p>
	<p>Ghi chú : <?php echo $ghichu; ?></p>	
	<form action="home_ktv.php" method="post" >
	<input id="nhantour" name="nhantour" type="hidden" value="1">
	<button type="submit" style="padding-left:20px; padding-right:20px; background:#0073aa; color:#fff; line-height:34px; border: 2px solid transparent;">Nhận Tour</button>
	</form>				
  </div>
</div>

<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
//var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
//btn.onclick = function() {
//    modal.style.display = "block";
//}

// When the user clicks on <span> (x), close the modal
//span.onclick = function() {
//    modal.style.display = "none";
//}
// When the user clicks anywhere outside of the modal, close it
//window.onclick = function(event) {
//    if (event.target == modal) {
//        modal.style.display = "none";
//    }
//}	
</script>

<?php
	if(isset($phong) && $phong != null && $phong != "" && $nhantour != "1" && $ketthuctour != "1")	// co thong tin phong 
	{
?>
<script>
//---09/12/2018 -> cai nay hay cung co the ap dung cho viec popup khung mau canh bao cho ky thuat vien
//<div id="myDIV">The animation has started</div>
var x = document.getElementById("myDIV");

// Code for Chrome, Safari and Opera
x.addEventListener("webkitAnimationIteration", myRepeatFunction);

// Standard syntax
x.addEventListener("animationiteration", myRepeatFunction);

function myRepeatFunction(event) {
    this.style.backgroundColor = "lightblue";
	modal.style.display = "block";
    //this.innerHTML = "Elapsed time: " + event.elapsedTime + " seconds";
}
</script>
<?php
	}
?>
<!-- 09/12/2018: tam thoi bo phan loc tu ngay den ngay
            <form action="" method="post" >
            <input type="date" name="tungay" value="<?php //echo @$tungay ?>">
            <input type="date" name="denngay" value="<?php //echo @$denngay ?>">
            <button style="background:#0073aa; color:#fff; line-height:34px; border: 2px solid transparent;">Lọc</button>
            </form> -->
			<div class="col-md-12">
			<table class="table">
      			<thead>
        			<tr>
          				<th>Hóa đơn</th>
		  				<th>Giờ</th>
          				<th>Phòng</th>
		  				<th>Dịch vụ</th>
          				<th>Số Key</th>
						<th>Khách</th>
          				<th>Ghi chú</th>
        			</tr>
      			</thead>
      			<tbody>
        		<?Php 
       				$sql="SELECT * FROM tblTheoDoiPhucVuSPA_ChiTiet WHERE MaNV like '$id' and ISNULL(IsDaXuLy,0) = 0 and Ngay >= '$tungay' and Ngay <= '$denngay' and MaPhieuDieuTour in (Select MaLichSuPhieu from tblLichSuPhieu where DaTinhTien = 0 and PhieuHuy = 0) Order by MaPhieuDieuTour Desc";
					$rs=sqlsrv_query($conn,$sql);
					$i=1;
					while($r=sqlsrv_fetch_array($rs))
					{
						//$MaNV=$r['MaNV'];
				?>
    				<tr class="success">
						<td><?php echo $r['MaPhieuDieuTour'];?></td>
          				<td><?php echo date_format($r['GioThucHien'],'H:i:s');?></td>
          				<td><?php echo $r['MaBanPhong'];?></td>
          				<td><?php echo $r['TenHangBan'];?></td>
						<td><?php echo $r['KeyString'];?></td>
          				<td><?php echo $r['TenKhachHang'];?></td>
          				<td><?php echo $r['GhiChu'];?></td>
        			</tr>

  	 			<?php
						$i=$i+1;
					}
					
					sqlsrv_free_stmt( $rs);
				?>
				</tbody>
		</table> 
	<form action="home_ktv.php" method="post" >
	<input id="ketthuctour" name="ketthuctour" type="hidden" value="1">
	<button type="submit" style="padding-left:20px; padding-right:20px; background:#0073aa; color:#fff; line-height:34px; border: 2px solid transparent;">Kết thúc Tour</button>
	</form>	
		</div>
		<!-- /#col-md-12 -->
		<div class="col-md-12" style="margin-top:20px; color:orange" align="center"><h4><b>THÔNG BÁO MỚI CHO <?php echo @$tenktv ?></b></h4></div>
  		<div class="col-md-12">
		<table class="table">
      			<thead>
        			<tr>
					    <th class="col-md-2">Ngày</th>
          				<th class="col-md-10">Nội dung</th>
        			</tr>
      			</thead>
      			<tbody>
        		<?Php 
					$date_converted = date('Y-m-d');
					$date_converted = substr($date_converted,0,4) . "/" . substr($date_converted,5,2) . "/" . substr($date_converted,8,2);
					
       				$sql="SELECT * FROM tblLichSuThongBaoNoiBo WHERE MaNVNhanTB like '$id' and IsTatThongBao = 0 and IsHienThiWebNhanVien = 1 and convert(varchar(20),NgayHienThi,111) >= '".$date_converted."' and convert(varchar(20),ISNULL(NgayKetThuc,Getdate()),111) >= '".$date_converted."' Order by ThuTuHienThi";
					//echo $sql;
					$rs=sqlsrv_query($conn,$sql);
					while($r=sqlsrv_fetch_array($rs))
					{
						//$MaNV=$r['MaNV'];
				?>
    				<tr class="success">
          				<td><?php echo date_format($r['NgayHienThi'],'d-m-Y H:i:s');?></td>
          				<td><?php echo $r['NoiDung'];?></td>
        			</tr>

  	 			<?php
					}
					
					sqlsrv_free_stmt( $rs);
				?>
				</tbody>
		</table> 
		</div>
		</div>   
	    <!-- /div class="xs" -->
  		</div>
		<!-- /div class="col-md-12 graphs"-->
      	</div>
      <!-- /#page-wrapper -->
   </div>
    <!-- /#wrapper -->
<!-- Nav CSS -->
<link href="css/custom.css" rel="stylesheet">
<!-- Metis Menu Plugin JavaScript -->
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<link href="js/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" /> 
<script>
$('.navbar-toggle').on('click', function() {
  $('.sidebar-nav').toggleClass('block');  
   
});
</script>
<?php
	if(!isset($phong) || $phong == "" || $phong == null || $nhantour == "0")	// ko co thong tin phong -> thiết lập set timeout tự refresh lại
	{
?>
<script>
     var time = new Date().getTime();
     $(document.body).bind("mousemove keypress", function(e) {
         time = new Date().getTime();
     });

     function refresh() {
         if(new Date().getTime() - time >= 5000) //5s 1 phut: 60000
             window.location.reload(true);
         else 
             setTimeout(refresh, 2000);
     }

     setTimeout(refresh, 2000);
</script>
<?php 
	}
?>
</body>
</html>
