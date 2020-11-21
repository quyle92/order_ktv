<?php
require('lib/db.php');
require('lib/ORDER_KTV.php');
require('functions/lichsuphieu.php');
$order_ktv = new ORDER_KTV();

@session_start();

date_default_timezone_set('Asia/Bangkok');

if(!isset($_SESSION['MaNV'])) 
{
?>
<script>
		//setTimeout('window.location="login.php"',0);
</script>
<?php
}

$id= isset( $_SESSION['MaNV'] ) ?: "";
$tenktv = isset( $_SESSION['TenNV'] ) ?: "";
$trungtam = "GIẢI PHÁP QUẢN LÝ BÁN HÀNG CHUYÊN NGHIỆP";
echo $img_upload_page = $_SERVER['PHP_SELF'];
$makhu =  ""; $magiuong = "";
if(isset($_GET['makhu']))
{
	$makhu = $_GET['makhu'];
}
//
//---xử lý có nhập món ko ?
//
$nhapmon = "0";
if(@$_GET['nhapmon'] != null)
{
	$nhapmon = @$_GET['nhapmon'];
}
else 
{
	$nhapmon = "0";
}
//	lấy giá trị get khác
//
$maphieu = ""; 
if(isset($_GET['maphieu']))
{
	$maphieu = $_GET['maphieu'];
}
if(isset($_GET['magiuong']))
{
	$magiuong = $_GET['magiuong'];
}
//
//	lưu lại session khi click khu
//
if($makhu != null && $magiuong != "")
{
	$_SESSION['MaKhu'] = $makhu;
	$_SESSION['MaGiuong'] = $magiuong;
}

if(isset($_SESSION['MaGiuong'])) 
{
	$magiuong = $_SESSION['MaGiuong'];
	//
	//	lay cac gia tri tu lich su phieus
	//
	$l_sql = "Select * from tblLichSuPhieu Where MaBan = '$magiuong' and DaTinhTien = 0 and PhieuHuy = 0";
	$rs3=sqlsrv_query($conn,$l_sql);
	while($r3=sqlsrv_fetch_array($rs3))
	{
		$maphieu = $r3['MaLichSuPhieu'];
		$makhach = $r3['MaKhachHang'];
		$tenkhach = $r3['TenKhachHang'];
	}
	sqlsrv_free_stmt( $rs3);
}
?>
<html>
<head>
<title>Giải pháp quản lý SPA toàn diện - ZinSPA</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Phần mềm quản lý SPA ZinSpa" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<!-- Bootstrap Core CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" rel="stylesheet" id="bootstrap-css">

<!-- Custom CSS -->
<!-- <link href="css/style1.css" rel='stylesheet' type='text/css' /> -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<link href="css/search-form-home.css" rel='stylesheet' type='text/css' />
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<!---//webfonts--->  
<!-- Bootstrap Core JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<!-- Search and Select plugin --> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

<style>
/*basic settings */

a:focus {
	outline: none !important;
	outline-offset: none !important;
}

body {
	background: #f5f6f5;
	color: #333;
}

/* helper classses */

.margin-top-20 {
	margin-top: 20px;
}

.margin-bottom-20 {
	margin-top: 20px;
}

.no-margin {
	margin: 0px;
}

/* box component */

.box {
	border-color: #e6e6e6;
	background: #FFF;
	border-radius: 6px;
	box-shadow: 0 2px 4px rgba(0, 0, 0, 0.25);
	padding: 10px;
	margin-bottom: 40px;
}

.box-center {
	margin: 20px auto;
}

/* input [type = file]
----------------------------------------------- */

input[type=file] {
	display: block !important;
	right: 1px;
	top: 1px;
	height: 34px;
	opacity: 0;
  width: 100%;
	background: none;
	position: absolute;
  overflow: hidden;
  z-index: 2;
}

.control-fileupload {
	display: block;
	border: 1px solid #d6d7d6;
	background: #FFF;
	border-radius: 4px;
	width: 100%;
	height: 36px;
	line-height: 36px;
	padding: 0px 10px 2px 10px;
  overflow: hidden;
  position: relative;
  
  &:before, input, label {
    cursor: pointer !important;
  }
  /* File upload button */
  &:before {
    /* inherit from boostrap btn styles */
    padding: 4px 12px;
    margin-bottom: 0;
    font-size: 14px;
    line-height: 20px;
    color: #333333;
    text-align: center;
    text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
    vertical-align: middle;
    cursor: pointer;
    background-color: #f5f5f5;
    background-image: linear-gradient(to bottom, #ffffff, #e6e6e6);
    background-repeat: repeat-x;
    border: 1px solid #cccccc;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    border-bottom-color: #b3b3b3;
    border-radius: 4px;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
    transition: color 0.2s ease;

    /* add more custom styles*/
    content: 'Browse';
    display: block;
    position: absolute;
    z-index: 1;
    top: 2px;
    right: 2px;
    line-height: 20px;
    text-align: center;
  }
  &:hover, &:focus {
    &:before {
      color: #333333;
      background-color: #e6e6e6;
      color: #333333;
      text-decoration: none;
      background-position: 0 -15px;
      transition: background-position 0.2s ease-out;
    }
  }
  
  label {
    line-height: 24px;
    color: #999999;
    font-size: 14px;
    font-weight: normal;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    position: relative;
    z-index: 1;
    margin-right: 90px;
    margin-bottom: 0px;
    cursor: text;
  }
}
</style>

<script>
$(function() {
  $('input[type=file]').change(function(){
    var t = $(this).val();
    var labelText = 'File : ' + t.substr(12, t.length);
    $(this).prev('label').text(labelText);
  });


	//$.noConflict();
	 $('select').selectize({
	    sortField: 'text'
	 });
});

</script>
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
					<a class="navbar-brand"> <?php echo $trungtam; ?></a>
				</div>

	 </nav>
 <!-- End Navigation -->
 	<div id="page-wrapper">
    <div class="col-md-12 graphs">
	<div class="xs">
		
		  <article id="main-content" role="main">  
    <section class="container">
       <div class="row">
          <div class="col-md-4">
            <header>
              <h1>Thêm hình ảnh KTV vào phần bên phải</h1>
            </header>
    
          </div>
      <div class="col-md-8">
        <p>&nbsp;</p>
        <h3 class="text-info">Upload hình KTV</h3>
        <form action="img-upload/process.php" method="post" enctype="multipart/form-data">
        	<label for="select-state">Chọn KTV:</label>
        	<select id="select-state" placeholder="KTV..." name="ktv">
        		<?php
		        	$ktv_list = $order_ktv->getKTVlist(); var_dump($ktv_list);
		        	for( $i = 0; $i < sqlsrv_num_rows($ktv_list); $i++ )
		        	{ 
		        		$r = sqlsrv_fetch_array($ktv_list);
		        	?>
				    <option value="<?=$r['MaNV']?>"><?=$r['TenNV']?></option>
				    <?php
					}
				?>
			</select>
			<br>
	        <!--file input example -->
	        <span class="control-fileupload">
	          <label for="file">Chọn ảnh từ máy tính:</label>
	          <input type="file" id="file" name="files[]" multiple >
	        </span>
	        <br>
	        <button type="submit" class="btn btn-info" value="UPLOAD" name="submit">Upload</button>
	        <!--./file input example -->
	    </form>
        <p>&nbsp;</p>
        <hr>


      </div>
    </div>
  </section>
</article>


	</div>   
	<!-- /div class="xs" -->
  	</div>
	<!-- /div class="col-md-12 graphs"-->
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
</body>
</html>