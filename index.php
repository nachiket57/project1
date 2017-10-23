<?php
// debugging messages
ini_set('display_errors', 'On');
error_reporting(E_ALL);
//instantiate the program object
//Class to load classes it finds the file when the program starts to fail for calling a missing class
class Manage {
   public static function autoload($class) {
       //you can put any file name or directory here
       include $class . '.php';
   }
}

spl_autoload_register(array('Manage', 'autoload'));
//instantiate the program object

$obj = new main();
class main {
   public function __construct()
   {
       //print_r($_REQUEST);
       //set default page request when no parameters are in URL
       $pageRequest = 'homepage';
       //check if there are parameters
       if(isset($_REQUEST['page'])) {
           //load the type of page the request wants into page request
           $pageRequest = $_REQUEST['page'];
       }
       //instantiate the class that is being requested
        $page = new $pageRequest;
       if($_SERVER['REQUEST_METHOD'] == 'GET') {
           $page->get();
       } else {
           $page->post();
       }
   }
}

//
//creates abstract class for the page object
//
abstract class page {
   protected $html;
   public function __construct()
   {
       $this->html .= '<html>';
       $this->html .= '<link rel="stylesheet" href="styles.css">';
       $this->html .= '<body>';
   }
   public function __destruct()
   {
       $this->html .= '</body></html>';
       stringFunctions::printThis($this->html);
   }
   public function get() {
       echo 'default get message';
   }
   public function post() {
       print_r($_POST);
   }
}

//
//displays the form to user to upload the csv file
//then posts the file to the server
//checks that file uploaded is in compliance
//
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

//
//table rendering of the csv data sets
//loads into array
//renders the datasets into a table stepwise
//

class htmlTable extends page{
  public function get(){
  
    $filename = $_REQUEST['filename'];
    $file = fopen("uploads/".$filename,"r");
  $tablehtml="";
//$data = array();
$i=0;
 $tablehtml .='<table border= "1">';
      while(! feof($file))
       {
         $data= fgetcsv($file);
         $count=count($data);
         $tablehtml .='<tr>';
         for($i=0;$i<$count;$i++){
           $tablehtml .='<td>'.$data[$i].'</td>';
         }
         $tablehtml .='</tr>';        
                    
       }
          $tablehtml .='</table>';
fclose($file);
  stringFunctions::printThis($tablehtml);
  
  }
}
?>
