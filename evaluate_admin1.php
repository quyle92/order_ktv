<?php 
require('lib/db.php');
@session_start();

date_default_timezone_set('Asia/Bangkok');

if(!isset($_SESSION['MaNV'])) //ten user đăng nhập
{
?>
<script>
        setTimeout('window.location="login.php"',0);
</script>
<?php
}

if(!isset($_SESSION['TenKTV']) || !isset($_SESSION['Stt']))  //phải có điều tour và tên ktv đã được lưu
{
?>
<script>
        setTimeout('window.location="home_admin.php"',0);
</script>
<?php
}

$stt = $_SESSION['Stt'];
$tennv = $_SESSION['TenKTV'];

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
 <div class="col-md-5">
     <div class="hinhanh">
        <img src="images/hinhthe.jpg" style="width:100%">
        <h4 style="text-align: center; font-weight:700"><?php echo $tennv; ?></h4>
     </div>
</div>

<div class="col-md-7">
 <form action="question_admin1.php" method="post">
 <input type="text" name="question1" value="1" hidden="">
     <div class="camnhan">
     <button type="submit" style="width:100%; ">
            <div class="r3_counter_box">
            <i class="pull-left fa fa-dollar icon-rounded">
            <img src="images/veryhappy.gif" style="width:100%">
            </i>
            <div>
              <h5><strong>Rất hài lòng với dịch vụ</strong></h5>
            </div>
            </div>
        </button>
     </div>
     
     </form>
     <form action="question_admin1.php" method="post">
 	<input type="text" name="question2" value="2" hidden="">
     <div class="camnhan">
     <button type="submit" style="width:100%; ">
            <div class="r3_counter_box">
            <i class="pull-left fa fa-dollar icon-rounded">
            <img src="images/happy.gif" style="width:100%">
            </i>
            <div>
              <h5><strong>Hài lòng với dịch vụ</strong></h5>
            </div>
            </div>
      </button>
     </div>
     </form>
     <form action="question_admin1.php" method="post">
 	<input type="text" name="question3" value="3" hidden="">
     <div class="camnhan">
     <button type="submit" style="width:100%; ">
            <div class="r3_counter_box">
            <i class="pull-left fa fa-dollar icon-rounded">
            <img src="images/normal.gif" style="width:100%">
            </i>
            <div>
              <h5><strong>Bình thường</strong></h5>
             
            </div>
            </div>
      </button>
     </div>
     </form>
     <form action="question_admin1.php" method="post">
 	<input type="text" name="question4" value="4" hidden="">
     <div class="camnhan">
      <button type="submit" style="width:100%; ">
            <div class="r3_counter_box">
            <i class="pull-left fa fa-dollar icon-rounded">
            <img src="images/unhappy.gif" style="width:100%">
            </i>
            <div>
              <h5><strong>Không hài lòng với dịch vụ</strong></h5>
            </div>
            </div>
        </button>
     </div>
     </form>
 </div>
 </div>
<div class="clear20"></div>
</body>
</html>