<?php
class DbConnection {

	protected $serverName = "DELL-PC\SQLEXPRESS";
	protected $connectionInfo = array( "Database"=>"MASSAGE_VL","CharacterSet" => "UTF-8", "UID"=>"sa", "PWD"=>"123");
	protected $conn;

	function __construct() {
			$this->conn =  sqlsrv_connect( $this->serverName, $this->connectionInfo) or die("Database Connection Error"."<br>". mssql_get_last_message()); 
    }
}

class ORDER_KTV extends DbConnection{

	public function getTenKTV( $maktv ){
		$sql = "select MaNV, TenNV FROM [MASSAGE_VL].[dbo].tblDMNhanVien  Where MaNV = '$maktv'";
		try 
		{
			$rs = sqlsrv_query($this->conn, $sql, array(), array( "Scrollable" => 'static' ));
			$r = sqlsrv_fetch_array( $rs );

			if( sqlsrv_fetch( $rs ) === false) {
			     die( print_r( sqlsrv_errors(), true));
			}

			$ten_KTV = $r['TenNV'];//var_dump($r);

			return $ten_KTV;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function updateKTVtoOrderID( $ten_KTV, $malichsuphieu  ) {
		$sql = "UPDATE [MASSAGE_VL].[dbo].[tblLichSuPhieu] SET NVPhucVu = N'$ten_KTV' where MaLichSuphieu like '$malichsuphieu'";
			try
			{
				$rs = sqlsrv_query($this->conn, $sql);
				
			}

			catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}



}