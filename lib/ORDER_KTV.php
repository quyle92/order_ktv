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
 					$errorMsg = !empty($errorUpload)? $errorUpload.'<br/>' . $errorUploadType : $errorUploadType; 
 					
 					if ( !empty($errorUpload) || !empty($errorUploadType) )
 					 	$statusMsg = $errorMsg; 
 				
 				 	$_SESSION['img_response_success'] = "Files are uploaded successfully.";
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
		 		$errorMsg = !empty( $errorUpload ) ? $errorUpload .'<br/>' . $errorUploadType : $errorUploadType;
		 		$statusMsg = $errorMsg;
		 	}
		}
		else
		{ 
	        $statusMsg = 'Please select a file to upload.'; 
	    }

		 $_SESSION['img_response_err'] =  $statusMsg;

	}

	public function updatePics( $maktv, $fileNames )
	{
		$targetDir = dirname(__FILE__, 2) . '\images\ktv\\'; //echo dirname(__FILE__, 2);
		$targetUrl = 'images/ktv/';
    	$allowTypes = array('jpg','png','jpeg','gif');

		$statusMsg = $errorMsg =  $errorUpload = $errorUploadType = $errorUploadDuplicate = ''; 
	    //var_dump ($_FILES['files']);
	   //var_dump ( $_FILES['files']['name'] );

    	$uploaded_img = array();
		if(!empty($fileNames))
		{	$i = 0;
			foreach( $fileNames as $key => $value )
			{
				 $i++; //echo $i. "\n";
				 // File upload path 
				$fileName =  basename( $fileNames[$key] ); 
				$targetFilePath = $targetDir . $fileName; //var_dump($targetFilePath );	
				$current_img_arr = unserialize( $this->getKTVPicsByID( $maktv ) ); //var_dump($current_img_arr );	
				$targetFileUrl =  $targetUrl . $fileName;	
				 // Check whether file type is valid 
	            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 

	            if( !in_array($fileType, $allowTypes) )
	            { 
	            	$errorUploadType .= '<li>' . $_FILES['files']['name'][$key].' </li>'; 	
				}
				elseif( in_array( $targetFileUrl, $current_img_arr ) )
				{
					$errorUploadDuplicate .= '<li>' . $_FILES['files']['name'][$key].' </li>'; 
				}
				// Upload file to server 
				elseif( !move_uploaded_file( $_FILES["files"]["tmp_name"][$key], $targetFilePath ) )
				{
					$errorUpload .= '<li>' . $_FILES['files']['name'][$key].' </li>'; 
				}
				else
				{
					//$targetFileUrl =  $targetUrl . $fileName;	
					$uploaded_img[] = $targetFileUrl;
				}
	                
	        }
	      
	       	$updated_img_arr = serialize( array_merge( $current_img_arr, $uploaded_img )   ); 
	        var_dump($updated_img_arr );

	 	 	//return; 

		 	if ( !empty( $uploaded_img )  )
		 	{
		 		$sql = "UPDATE [MASSAGE_VL].[dbo].[tblDMNhanVien] SET SourceHinhAnh = '$updated_img_arr' WHERE MaNV = '$maktv'";
 			 	$rs = sqlsrv_query($this->conn, $sql);
 	
 				if ( $rs ) 
 				{
 					$errorUpload = !empty( $errorUpload ) ? 'Upload Error: <ul>' . trim( $errorUpload, ' | ' ) . '</ul>' : ''; 
 					$errorUploadType = !empty( $errorUploadType ) ? 'File Type Error: <ul>'.trim($errorUploadType, ' | ') . '</ul>' : '';
 					$errorUploadDuplicate = !empty( $errorUploadDuplicate ) ? 'File Already Existed: '.trim($errorUploadDuplicate, ' | ') : '';
 					$errorMsg =  ( !empty($errorUpload) ) ? (  $errorUpload.'<br/>' . $errorUploadType .'<br/>' . $errorUploadDuplicate) : ( $errorUploadType . '<br/>' . $errorUploadDuplicate ); 
 					
 					
 					if ( !empty($errorUpload) || !empty($errorUploadType) || !empty($errorUploadDuplicate) ){
 					 	$statusMsg = $errorMsg; var_dump($statusMsg);
 					}
 				
 				 	$_SESSION['img_response_success'] = "Files are uploaded successfully.";
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
 				$errorUploadDuplicate = !empty( $errorUploadDuplicate ) ? 'File Already Existed: '.trim($errorUploadDuplicate, ' | ') : '';
		 		$errorMsg =  ( !empty($errorUpload) ) ? (  $errorUpload.'<br/>' . $errorUploadType .'<br/>' . $errorUploadDuplicate) : ( $errorUploadType . '<br/>' . $errorUploadDuplicate ); 
		 		$statusMsg = $errorMsg;//var_dump($statusMsg);
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

	public function deletePics( $maktv,  $pic_item_arr )
	{

		$img_arr = unserialize( $this->getKTVPicsByID( $maktv ) );
		$targetDir = dirname(__FILE__, 2) . '\images\ktv\\';

		foreach( $img_arr as $k => $v ){

			if( in_array($k, $pic_item_arr) )
			{
				$img_to_be_deleted = basename( $img_arr[$k] );
				$file_name = $targetDir . $img_to_be_deleted;
				
				if ( file_exists( $file_name  ) ) {
			        unlink( $file_name );
			        echo 'File ' . $img_to_be_deleted . ' has been deleted';
			    } 
			    else {

			        echo 'Could not delete "' . $img_to_be_deleted . '", file does not exist';
			    }

				unset( $img_arr[$k] );
				
			}
		}

		$img_arr_updated = serialize( $img_arr );
		var_dump( $img_to_be_deleted);

		//return; 

		$sql = "UPDATE [MASSAGE_VL].[dbo].[tblDMNhanVien] SET [SourceHinhAnh] = '$img_arr_updated' where MaNV ='$maktv'";
		try
		{
			$rs = sqlsrv_query($this->conn, $sql);

			if( $rs ) 	
			{
				return  unserialize( $this->getKTVPicsByID( $maktv ) );
			}
			else
			{
				return "Items cannot be deleted";
			}
			
		}

		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	

	



}