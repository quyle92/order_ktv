<?php
require('../lib/db.php');
require('../lib/ORDER_KTV.php');
require('../functions/lichsuphieu.php');
session_start();

$order_ktv = new ORDER_KTV();

if(isset($_POST['submit'])){ 
 
	$maktv = $_POST['ktv'];
	$_SESSION['maktv'] = $maktv;
    $fileNames = array_filter($_FILES['files']['name']);
    $pictures = $order_ktv->insertPics( $maktv, $fileNames );

    if ( strlen( $_SESSION['back'] ) > 0 ){
		$back= $_SESSION['back']; 
		unset($_SESSION['back']);
		header("location:$back");
	} 
	else header("location: ../index.php");

     
}