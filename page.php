//displays the form to user to upload the csv file
//then posts the file to the server
//checks that file uploaded is in compliance
//
<?php
class homepage extends page {
   public function get() {
       $form = '<form action="index.php" method="post" enctype="multipart/form-data">';
       $form .= '<input type="file" name="fileToUpload" id="fileToUpload">';
       $form .= '<input type="submit" value="Upload " name="submit">';
       $form .= '</form> ';
       $this->html .= '<h1>Upload Form</h1>';
       $this->html .= $form;
   }
	public function post() {
		//Path of the directory where the csv file has to be saved
		$target_dir = "./uploads/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
		$fileName=pathinfo($target_file,PATHINFO_BASENAME);
  
/move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
  header('Location: index.php?page=htmlTable&filename='.$fileName);
		//Allow csv file formats
      if($fileType != "csv" ) {
             echo "Sorry, only CSV files are allowed. ";
        }
		
		else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
               //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
               header('Location: index.php?page=htmlTable&filename='.$fileName);
			      else 
               echo "Sorry, there was an error uploading your file.";
				
		}
  }
}
?>