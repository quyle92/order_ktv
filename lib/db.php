<?php
$serverName = "DELL-PC\SQLEXPRESS";
$connectionInfo = array( "Database"=>"MASSAGE_VL","CharacterSet" => "UTF-8", "UID"=>"sa", "PWD"=>"123");
$conn = sqlsrv_connect( $serverName, $connectionInfo);
?>