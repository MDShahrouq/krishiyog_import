<?php
session_start();


if($_SESSION['krishi_login']==1){
}else{
 echo "<script>location='index.php'</script>";	
}


/** Set default timezone (will throw a notice otherwise) */
date_default_timezone_set('Asia/Kolkata');

include 'PHPExcel/IOFactory.php';

if(isset($_FILES['file']['name'])){
		
	$file_name = $_FILES['file']['name'];
	$ext = pathinfo($file_name, PATHINFO_EXTENSION);
	
	//Checking the file extension
	if($ext == "xlsx"){
			
			$file_name = $_FILES['file']['tmp_name'];
			$inputFileName = $file_name;

		//  Read your Excel workbook
		try {
			$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($inputFileName);
		} catch (Exception $e) {
			die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) 
			. '": ' . $e->getMessage());
		}

		//Table used to display the contents of the file
		echo '<center><table style="width:50%;" border=1>';
		
		//  Get worksheet dimensions
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();
		$highestColumn = "L";
		/*echo $highestColumn;*/
		

		
		//  Loop through each row of the worksheet in turn
		for ($row = 2; $row <= $highestRow; $row++) {
			//  Read a row of data into an array
			$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, 
			NULL, TRUE, FALSE);
			/*echo "<tr>";*/
			//echoing every cell in the selected row for simplicity. You can save the data in database too.
			$stack = ""; 
	
			foreach($rowData[0] as $k=>$v)
				/*echo "<td>".$v."</td>";*/
			    $stack=$stack.";".$v;
			/*echo "</tr>";*/
            echo "</br>";
            $stack = ltrim($stack, ';');
			print_r($stack);
            
           
           /* $url_search = 'http://127.0.0.1:8000/import_multiple_produce/?access_token=Mj4hcB7gEF9DZeeHw7XMUcfwfj4n6c';
			$options_search = array(
			  'http' => array(
			    'header'  => array(
			                  'STRING: '.$stack,
			                  'USER-ID: '.$_POST['id_field'],
			                  'SUB-CATEGORY: '.$_POST['sub_category'],
			                ),
			    'method'  => 'GET',
			  ),
			);
			$context_search = stream_context_create($options_search);
			$output_search = file_get_contents($url_search, false,$context_search);
			
			$arr_search = json_decode($output_search,true);*/
           
            	  
           


		}
		
		echo '</table></center>';
        header("Location: home.php");
        
       
		
	}

	else{
		echo '<p style="color:red;">Please upload file with xlsx extension only</p>'; 
	}	
		
}
?>