

<?php
// new class htmlTable that extends the page class
// gets the filename (ie. csv file) from the server and opens it for processing
// loads the file into an array
// puts the datasets ($data) form the array into the table class object
class htmlTable extends page{

	public function get(){
	
		$fname = $_REQUEST('filename');
		$file = fopen("uploads/".$fname,"r");
 $arr=new array();
 $table ='<table>';
			while(! feof($file))
			 {
			   $arr= fgetcsv($file));
                    echo "test";
          	$table . ='<tr><td>'.$arr[0].'</td>'; 
          	$table . ='<td>'.$arr[1].'</td>';
          	$table . ='<td>'.$arr[2].'</td></tr>';         
                    
			 }
          	$table . ='</table>';

fclose($file);
	print($table);
	
	}

}
?>
