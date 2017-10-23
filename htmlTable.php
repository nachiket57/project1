//new class htmlTable that extends the page class
//gets the filename (ie. csv file) from the server and opens it for processing
//loads the file into an array
//puts the datasets ($data) form the array into the table class object
//
<?php 
class htmlTable extends page{

	public function get(){
	
		$filename = $_REQUEST('filename');
		$file = fopen("uploads/".$filename,"r");
 $data=new array();
 $tablehtml ='<table>';
			while(! feof($file))
			 {
			   $data= fgetcsv($file));
                    echo "test";
          $tablehtml . ='<tr><td>'.$data[0].'</td>'; 
          $tablehtml . ='<td>'.$data[1].'</td>';
          $tablehtml . ='<td>'.$data[2].'</td></tr>';         
                    
			 }
          $tablehtml . ='</table>';

fclose($file);
	print($tablehtml);
	
	}

}
?>
