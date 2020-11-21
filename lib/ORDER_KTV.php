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

	public function insertPics( &$maktv, $fileNames ) {

		$targetDir = dirname(__FILE__, 2) . '\images\ktv\\'; //echo dirname(__FILE__, 2);
		$targetUrl = 'images/ktv/';
    	$allowTypes = array('jpg','png','jpeg','gif');

		$statusMsg = $errorMsg =  $errorUpload = $errorUploadType = ''; 
	    //var_dump ($_FILES['files']);
	   var_dump ( $_FILES['files']['name'] );

    	$uploaded_img = array();
		if(!empty($fileNames))
		{
			foreach( $fileNames as $key => $value )
			{

				 // File upload path 
				$fileName =  basename( $fileNames[$key] ); 
				$targetFilePath = $targetDir . $fileName;
				$targetFileUrl =  $targetUrl . $fileName;			
				
				 // Check whether file type is valid 
	            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 

	            if( !in_array($fileType, $allowTypes) )
	            { 
	            	$errorUploadType .= '<li>' . $_FILES['files']['name'][$key].' </li>'; 	
				}
				// Upload file to server 
				elseif( !move_uploaded_file( $_FILES["files"]["tmp_name"][$key], $targetFilePath ) )
				{
					$errorUpload .= '<li>' . $_FILES['files']['name'][$key].' </li>'; 
				}
				else
				{
					
					$uploaded_img[] = $targetFileUrl;
				}
	                
	        }
			
	 		

	 	 	$img_files = serialize( $uploaded_img );//var_dump($uploaded_img);

		 	if ( !empty( $uploaded_img ) )
		 	{
		 		$sql = "UPDATE [MASSAGE_VL].[dbo].[tblDMNhanVien] SET SourceHinhAnh = '$img_files' WHERE MaNV = '$maktv'";
 			 	$rs = sqlsrv_query($this->conn, $sql);
 	
 				if ( $rs ) 
 				{
 					$errorUpload = !empty( $errorUpload ) ? 'Upload Error: <ul>' . trim( $errorUpload, ' | ' ) . '</ul>' : ''; 
 					$errorUploadType = !empty( $errorUploadType ) ? 'File Type Error: <ul>'.trim($errorUploadType, ' | ') . '</ul>' : '';
 					$errorMsg = !empty($errorUpload)?'<br/>' . $errorUpload.'<br/>' . $errorUploadType:'<br/>'.$errorUploadType; 
 					
 					if ( !empty($errorUpload) || !empty($errorUploadType) )
 					 	$statusMsg = $errorMsg; 
 					if( empty($errorUpload) && empty($errorUploadType) )
 					 	$_SESSION['img_response_success'] = "All files are uploaded successfully.";
 				}
 				else
 				{ 
 		                $statusMsg = "Sorry, Pictures cannot be inserted into the database."; 
 		        }
		 	}	
		 	else
		 	{	
		 		$errorUpload = !empty( $errorUpload ) ? 'Upload Error: ' . trim( $errorUpload, ' | ' ) : ''; 
 				$errorUploadType = !empty( $errorUploadType ) ? 'File Type Error: '.trim($errorUploadType, ' | ') : '';
		 		$errorMsg = !empty($errorUpload)?'<br/>' . $errorUpload.'<br/>' . $errorUploadType:'<br/>'.$errorUploadType;
		 		$statusMsg = $errorMsg;
		 	}
		}
		else
		{ 
	        $statusMsg = 'Please select a file to upload.'; 
	    }

		 $_SESSION['img_response_err'] =  $statusMsg;

	}

	public function getKTVPicsByID( $maktv ){
		$sql = "SELECT  [MaNV]  ,[TenNV] ,[SourceHinhAnh] FROM [MASSAGE_VL].[dbo].[tblDMNhanVien] where [MaNV] = '$maktv'";
		try
			{
				$rs = sqlsrv_query( $this->conn,  $sql );
				$r = sqlsrv_fetch_array( $rs ); //var_dump (unserialize($r['SourceHinhAnh']));
				if( $rs != false) 
					return $r['SourceHinhAnh'];
				else die(print_r(sqlsrv_errors(), true));
			}

			catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	



}