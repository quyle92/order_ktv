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

	public function getKTVlist() {
		$sql = "SELECT [MaNV],[TenNV],[SourceHinhAnh] FROM [MASSAGE_VL].[dbo].[tblDMNhanVien] order by MaNV DESC";
			try
			{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die(print_r(sqlsrv_errors(), true));
			}

			catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function insertPics( $maktv, $fileNames ) {

		$targetDir = dirname(__FILE__, 2) . '\images\ktv\\'; //echo dirname(__FILE__, 2);
    	$allowTypes = array('jpg','png','jpeg','gif');

		$statusMsg = $errorMsg =  $errorUpload = $errorUploadType = ''; 
	    //var_dump ($_FILES['files']);
	   // var_dump ($fileNames);

    	$img_files = array();
		if(!empty($fileNames))
		{
			foreach( $fileNames as $key => $value )
			{

				 // File upload path 
				$fileName =  basename( $fileNames[$key] ); 
				$targetFilePath = $targetDir . $fileName; //var_dump ($targetFilePath);
				
				 // Check whether file type is valid 
	            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 

	            if( !in_array($fileType, $allowTypes) ){ 
	            	$errorUploadType .= $_FILES['files']['name'][$key].' | '; 	
				}
				else{ 
					// Upload file to server 
					if( !move_uploaded_file( $_FILES["files"]["tmp_name"][$key], $targetFilePath ) ){
						$errorUpload .= $_FILES['files']['name'][$key].' | '; 
					}
					else{
						$img_files[] = $targetFilePath;
					}
	                
	            } 

		 	}
		 	$img_files = serialize( $img_files );//var_dump($img_files);

		 	$sql = "UPDATE [MASSAGE_VL].[dbo].[tblDMNhanVien] SET SourceHinhAnh = '$img_files' WHERE MaNV = '$maktv'";
		 	$rs = sqlsrv_query($this->conn, $sql);

			if ( $rs ) 
			{
				$errorUpload = !empty( $errorUpload ) ? 'Upload Error: ' . trim( $errorUpload, ' | ' ) : ''; 
				$errorUploadType = !empty( $errorUploadType ) ? 'File Type Error: '.trim($errorUploadType, ' | ') : '';
				$errorMsg = !empty($errorUpload)?'<br/>' . $errorUpload.'<br/>' . $errorUploadType:'<br/>'.$errorUploadType; 
				
				if ( !empty($errorUpload) )
				 	$statusMsg = $errorMsg; 
				elseif( empty($errorUpload) && empty($errorUploadType) )
				 	$statusMsg = "Files are uploaded successfully.";
			}
			else
			{ 
	                $statusMsg = "Sorry, Pictures cannot be inserted into the database."; 
	        }
		}
		else
		{ 
	        $statusMsg = 'Please select a file to upload.'; 
	    }

		echo $statusMsg;  
	}



}