<?php 
require('lib/db.php');
require('lib/ORDER_KTV.php');
require('functions/lichsuphieu.php');
$order_ktv = new ORDER_KTV();

@session_start();	//session_destroy();
//error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
date_default_timezone_set('Asia/Bangkok');
$_SESSION['previous'] = basename($_SERVER['PHP_SELF']);
//
//------------xử lý session của user ---------------//
//
if(!isset($_SESSION['TenSD'])) 
{
?>
<script>
	setTimeout('window.location="login.php"',0);
</script>
<?php
}

$_SESSION['NhapMon'] = 1;

$matrungtam = $_SESSION['MaTrungTam'];
$tentrungtam = $_SESSION['TenTrungTam'];
//
//----------------------lấy các thông tin post, get -------------------//
//
//----------------------mã lịch sử phiếu, mã bàn --------------------------------------//
//
$malichsuphieu = ""; 
if(isset($_GET['malichsuphieu']))						//---trường hợp xử lý theo link phân trang hoặc từ home
{
	$malichsuphieu= $_GET['malichsuphieu'];
}

if(isset($_POST['malichsuphieu']) && $malichsuphieu == "") //trường hợp xử lý theo submit form chọn món
{
	$malichsuphieu= $_POST['malichsuphieu'];
}

if(isset($_SESSION['MaLichSuPhieu']) && $malichsuphieu == "") //lấy từ session nếu chưa có mã lịch sử phiếu
{
	$malichsuphieu = $_SESSION['MaLichSuPhieu'];
}

if($malichsuphieu != "")
{
	$_SESSION['MaLichSuPhieu']= $malichsuphieu;			//-----luu lai session mới nhất MaLichSuPhieu
}
//
//
$maban = "";
if(isset($_GET['maban']))								//----get gia tri tu home.php
{
	$maban = $_GET['maban'];
}
if(isset($_POST['maban']) && $maban == "")				//----lấy từ submit form
{
	$maban = $_POST['maban'];
} 
if(isset($_SESSION['MaBan']) && $maban == "") 			// lấy từ session nếu chưa có mã bàn
{
	$maban = $_SESSION['MaBan'];
}

if($maban != "")
{
	$_SESSION['MaBan'] = $maban;						//-----lưu lai session ma ban mới nhất
}

if($maban==null or $maban=="")
{ 
?> 
<!-- 	<script> 
		alert('chưa có mã bàn');
		setTimeout('window.location="home.php"',0);
	</script> -->
<?php
}
//
//--------------mã nhóm ktv, ktv -----------------------//
//
$manhomktvmoi =  ""; $manhomktvcu = ""; $maktv = ""; 
//
//
if(isset($_GET['manhomnv']))
{
	$manhomktvmoi = $_GET['manhomnv']; //có click chọn nhóm hàng bán
}
if(isset($_POST['manhomnv']))
{
	$manhomktvmoi = $_POST['manhomnv']; //có click chọn nhóm hàng bán
}
if(isset($_SESSION['MaNhomNhanVien']))
{
	$manhomktvcu = $_SESSION['MaNhomNhanVien'];
}
if($manhomktvmoi != "")
{
	$_SESSION['MaNhomNhanVien'] = $manhomktvmoi;
}
else
{
	$manhomktvmoi = $manhomktvcu;		// không thay đổi mã nhóm hàng bán
}
//
//----------------check có nhan vien-------------------//
//
if(isset($_GET['maktv']))			//-----lay ma ktv bang phuong thuc get
{
	$maktv = $_GET['maktv'];
	
	$l_sql = "Select * from tblDMNhanVien WHERE manv like '$maktv'";
	$rs7=sqlsrv_query($conn,$l_sql);
	while($r7=sqlsrv_fetch_array($rs7))
	{
		$manhomktvmoi = $r7['NhomNhanVien'];
	}
	sqlsrv_free_stmt( $rs7);
}

if(isset($_POST['maktv']))			//-----lay ma hang ban bang phuong thuc post
{
	$maktv = $_POST['maktv'];
	
	$l_sql = "Select * from tblDMNhanVien WHERE manv like '$maktv'";
	$rs7=sqlsrv_query($conn,$l_sql);
	while($r7=sqlsrv_fetch_array($rs7))
	{
		$manhomktvmoi = $r7['NhomNhanVien'];
	}
	sqlsrv_free_stmt( $rs7);
}
//
//	lưu lại session khi có click chon ktv
//
if($maktv != null && $maktv != "")
{
	$_SESSION['MaNhomNhanVien'] = $manhomktvmoi;
	$_SESSION['MaNV'] = $maktv;
}
//
//--------------xu ly action cho viec xu ly trong page order.php ------------//
//				action: add, update, delete
$action = "";
if(isset($_GET['action']))
{
	$action=$_GET['action'];
}

if ($action=="remove") 
{ 
	unset($_SESSION['TenKTV']);
	unset($_SESSION['MaKTV']);
	unset($_SESSION['HinhAnh']);
}
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Giải pháp quản lý Spa chuyên nghiệp - ZinRES</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Phần mềm quản lý Spa ZinSpa" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		
<!-- Bootstrap Core CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<!-- Custom CSS -->
<link href="css/style1.css" rel='stylesheet' type='text/css' />
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- Nav CSS -->
<link href="css/custom.css" rel="stylesheet">
<!-- jQuery -->
<script
src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
crossorigin="anonymous">
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!---//webfonts--->  
<!-- Bootstrap Core JavaScript -->
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<style> 
/*--new menu 19042020 ---*/
.li-level1
{
  padding: 8px 8px 8px 5px;
}

.menu-level1 {
  font-size: 14px;
  color: #818181;
}

.menu-level1:hover {
  color: #f1f1f1;
}

.menu-level2 {
  padding: 8px 8px 8px 15px;
  font-size: 14px;
  color: #818181;
}

.menu-level2:hover {
  color: #f1f1f1;
}

.sidenav {
  height: 100%;
  width: 200px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  padding-top: 20px;
}

/* Style the sidenav links and the dropdown button */
.sidenav a, .dropdown-btn {
  padding: 8px 8px 8px 5px; /*top right bottom left*/
  text-decoration: none;
  font-size: 14px;
  color: #818181;
  display: block;
  border: none;
  background: none;
  width: 100%;
  text-align: left;
  cursor: pointer;
  outline: none;
}

/* On mouse-over */
.sidenav a:hover, .dropdown-btn:hover {
  color: #f1f1f1;
}

/* Main content */
.main {
  margin-left: 200px; /* Same as the width of the sidenav */
  font-size: 20px; /* Increased text to enable scrolling */
  padding: 0px 10px;
}

/* Add an active class to the active dropdown button */
.active {
  background-color: green;
  color: white;
}

/* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
.dropdown-container {
  display: none;
  background-color: #262626;
  padding-left: 12px;
  line-height: 2em;
}

/* Optional: Style the caret down icon */
.fa-caret-down {
  float: right;
  padding-right: 8px;
}

/* Some media queries for responsiveness */
@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 12px;}
}

/*-----end style new menu 19042020*/

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


.nhomhb_active {
    background: #F9B703;
    color: #fff;
    font-size: 0.8em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 135px;
    height: 50px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0 0;
    margin-top: 1em;
    margin-right: 8px;
    margin-bottom: 0px;
	}

	.nhomhb {
    background: #A9FFD0; /*#0073aa;*/
    color: #000; /* #fff;*/
    font-size: 0.8em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 135px;
    height: 50px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0 0;
    margin-top: 1em;
    margin-right: 8px;
    margin-bottom: 0px;
	}

.hangban_active {
    background: #F9B703;
    color: #fff;
    font-size: 0.8em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 112px;
    height: 100px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0.5em 0;
    margin-top: 0em;
    margin-left: 5px;
    margin-bottom: 5px;
	}

	.hangban {
    background: #0073aa;
    color: #fff;
    font-size: 0.8em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 112px;
    height: 100px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0.5em 0;
    margin-top: 0em;
    margin-left: 5px;
    margin-bottom: 5px;
	}

#page-wrapper {
	margin: 0 0 0 0px !important;
}

/*
Light Box
 */
.product_view .modal-dialog{
	max-width: 800px; 
	width: 100%;

}

.product_view .modal-dialog .modal-content .modal-body .has-img .product_img{
	display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden
}

.product_view .modal-dialog img{
	flex-shrink: 0;
    min-width: 100%;
    min-height: 100%
}
.pre-cost{text-decoration: line-through; color: #a5a5a5;}
.space-ten{padding: 10px 0;}

</style>

</head>
<body>
<div id="wrapper">
    <div id="page-wrapper">
    <div class="col-md-12 graphs">
	<div class="xs">
       	<div class="row">
       		<div class="col-sm-6 col-md-10 col-md-offset-1" style="margin-bottom:5px">
<?php
			if($malichsuphieu != null && $malichsuphieu != "")
			{
?>			
			<h4>Bàn: <?=$maban?> - Hóa đơn: <?=$malichsuphieu?></h4>
<?php
			}
			else
			{
?>
			<h4>NHÓM KTV</h4>
<?php 
			}
?>
			<form action="order.php" method="post">
				<div class="grid">
<?php 
/*code để lấy total page*/
	if (isset($_GET['pageno_nhb'])) {
	   $pageno_nhb = $_GET['pageno_nhb'];
	} else {
		$pageno_nhb = 1;
	}
	$no_of_records_per_page = 12;//6;
	$startRowNhomHB = ($pageno_nhb-1) * $no_of_records_per_page;
	$endpoint = $startRowNhomHB + $no_of_records_per_page;
	$total_pages = 3;
/*End code để lấy total page*/
	//
	//------------------------------danh sách nhóm hàng ----------------------//
	//
	$l_sql="select * from (SELECT *, ROW_NUMBER() OVER (ORDER BY Ma) as rowNum FROM tblDMNhomNhanVien) sub WHERE IsDieuTour = 1 and rowNum >  '$startRowNhomHB' and rowNum <= '$endpoint'"; 
	try
	{
		$rsnhomhb=sqlsrv_query($conn, $l_sql);
		if(sqlsrv_has_rows($rsnhomhb) != false)
		{
			while ($r1 = sqlsrv_fetch_array($rsnhomhb))
			{
				if($manhomktvmoi == "")
				 	$manhomktvmoi = $r1['Ma'];

				if($manhomktvmoi == $r1['Ma'])
				{
?>			
					<button type="submit" name="manhomnv" value="<?php echo $r1['Ma']; ?>" class="nhomhb_active"><?php echo $r1['Ten']; ?></button>
<?php
				}
				else
				{
?>				
					<button type="submit" name="manhomnv" value="<?php echo $r1['Ma']; ?>" class="nhomhb"><?php echo $r1['Ten']; ?></button>
<?php
				}
			}
		}//end if co ds nhom hang ban
	}
	catch (Exception $e) {
		echo $e->getMessage();
	}
?>
				</div>
				</form>
<!-- ---------------------NHÓM HÀNG BÁN Pagination -------------------------->
		<ul class="pagination">
        	<li><a href="?pageno_nhb=1&manhomnv=<?=$manhomktvmoi?>">First</a></li>
        	<li class="<?php if($pageno_nhb <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno_nhb <= 1){ echo '#'; } else { echo '?pageno_nhb='.($pageno_nhb - 1).'&manhomnv='.$manhomktvmoi; } ?>">Prev</a>
        	</li>
		
<?php
	$from=$pageno_nhb-3;
	$to=$pageno_nhb+3;
	if ($from<=0) $from=1;  $to=3*4;
	if ($to>$total_pages)	$to=$total_pages;
	for ($j=$from;$j<=$to;$j++) 
	{
		if ($j==$pageno_nhb) 
		{ 
?>
			<li class='active'><a href='order.php?pageno_nhb=<?=$j?>&manhomnv=<?=$manhomktvmoi?>'><?=$j?></a></li>
<?php 
		} 
		else 
		{ 
?>
			<li class=''><a href='order.php?pageno_nhb=<?=$j?>&manhomnv=<?=$manhomktvmoi?>'><?=$j?></a></li>
<?php 
		}
	}
?>		
        	<li class="<?php if($pageno_nhb >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno_nhb >= $total_pages){ echo '#'; } else { echo "?pageno_nhb=".($pageno_nhb + 1).'&manhomnv='.$manhomktvmoi; } ?>">Next</a>
        	</li>
        	<li><a href="?pageno_nhb=<?php echo $total_pages.'&manhomnv='.$manhomktvmoi ?>">Last</a></li>
    	</ul>
<!--------------------- NHÓM HÀNG BÁN Pagination End--------------------------->

<!----------------------HÀNG BÁN ---------------------------------------------->
<?php include('order/ktv.php');?>

		</div>
<!-------------------Xu ly form Order Review ------------------------------>
<?php //include('order/order-review-form.php');?>
	    </div>
	</div>   
	<!-- /div class="xs" -->
  	</div>
	<!-- /div class="col-md-12 graphs"-->
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->

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
<script type="text/javascript">
//plugin bootstrap minus and plus
//http://jsfiddle.net/laelitenetwork/puJ6G/
  $(".btn-number").on("click", function() {

    var $button = $(this);
    var maktv = $button.parent().find(".input-maktv").val();
    //alert("ma hang" + maktv); //ok
    var soluong_oldValue =  $button.parent().find(".input-number").val();
    var thanhtien_oldValue_str = $button.parent().find(".input-thanhtien-number").val();
    thanhtien_oldValue_str = thanhtien_oldValue_str.replace('.','');
    var thanhtien_oldValue = parseFloat(thanhtien_oldValue_str);

    if  ($button.val() == "+" ) {
  	  var soluong_newVal = parseFloat(soluong_oldValue) + 1;
  	} else {
     
        var soluong_newVal = parseFloat(soluong_oldValue) - 1;
	   
	 }
	if(soluong_newVal < 1)
    	var soluong_newVal = 1;

    var dongia = parseFloat(thanhtien_oldValue/soluong_oldValue);
    var thanhtien_newVal = parseFloat(soluong_newVal)*dongia;
    var thanhtien_newVal_str = thanhtien_newVal.toString();
    //
    // ---------convert to string with thousand seperator
    //var len = newVal_ThanhTien_str.length; 
    //var c = parseInt(len/3);
    //if(c == 1)
    //	newVal_ThanhTien_str = newVal_ThanhTien_str.substring(0,len-3) + '.' + newVal_ThanhTien_str.substring(len-3,3);
    //----------tong tien--------//
    var tongtienObj = document.getElementById("tongtien");
    var tongtien_oldvalue_str = document.getElementById("tongtien").value; //--ok
    var tongtien_oldvalue = parseFloat(tongtien_oldvalue_str.replace('.',''));
    var tongTien_newvalue = tongtien_oldvalue + thanhtien_newVal - thanhtien_oldValue;
    //alert(newTongTien); //--ok
    //----------so luong --------//
    var tongsoluongObj = document.getElementById("tongsoluong");
    var tongsoluong_oldvalue_str = document.getElementById("tongsoluong").value; //--ok
    var tongsoluong_oldvalue = parseFloat(tongsoluong_oldvalue_str.replace('.',''));
    var tongsoluong_newvalue = tongsoluong_oldvalue + soluong_newVal - soluong_oldValue;

    //
    //----------set value to html object ----------//
    //
    $button.parent().find(".input-number").val(soluong_newVal);
    $button.parent().find(".input-thanhtien-number").val(thanhtien_newVal);
    tongtienObj.value = tongTien_newvalue; 	//--ok
    tongsoluongObj.value = tongsoluong_newvalue;
    //
    // ajax: ok
    //
    var ajaxurl = 'order_update.php',
        data =  {'maktv': maktv, 'soluong': soluong_newVal};
        $.post(ajaxurl, data, function (response) {
            // Response div goes here.
            document.getElementById("ketqua").innerHTML=response;
            //alert("Cap nhat Order Thanh Cong !");
        });
  });
</script>
<script>
		$("#checkAll").click(function () {
     $('input:checkbox').prop('checked', this.checked);
 });
</script>
<script>
	$("#checkThemMonSetMenu").click(function () {
		var themsetmenu = 0;
		if($('input:checkbox').is(':checked'))
		{
			themsetmenu = 1;
			//alert("checked"); //ok
		}
		else
		{
			themsetmenu =0;
			//alert("uncheck"); //ok
		}

    //
    // ajax: ok
    //
    var ajaxurl = 'order_setmenu.php',
        data =  {'themsetmenu': themsetmenu};
        $.post(ajaxurl, data, function (response) {
            // Response div goes here.
            //document.getElementById("ketqua").innerHTML=response;
            //alert("Cap nhat Order Thanh Cong !");
        });
 });
</script>
<script>
	/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
  	this.classList.toggle("active");
  	var dropdownContent = this.nextElementSibling;
  	if (dropdownContent.style.display === "block") {
  		dropdownContent.style.display = "none";
  	} else {
  		dropdownContent.style.display = "block";
  	}
  });
}
</script>
<script>
$('.navbar-toggle').on('click', function() {
  $('.sidebar-nav').toggleClass('block');  
   
});
</script>
</body>
</html>
