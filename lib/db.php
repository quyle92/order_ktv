<?php
$serverName = "DELL-PC\SQLEXPRESS";
$connectionInfo = array( "Database"=>"GOLDENLOTUS_Q3","CharacterSet" => "UTF-8", "UID"=>"sa", "PWD"=>"123");
$conn = sqlsrv_connect( $serverName, $connectionInfo);
?>