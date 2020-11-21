<?php
require('../lib/db.php');
require('../lib/ORDER_KTV.php');
require('../functions/lichsuphieu.php');
$order_ktv = new ORDER_KTV();

if(isset($_POST['submit'])){ 
 
	$maktv = $_POST['ktv'];
    $fileNames = array_filter($_FILES['files']['name']);
    $pictures = $order_ktv->insertPics( $maktv, $fileNames );
    header('location:' . $img_upload_page );
     
}