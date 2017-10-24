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
       $frm = '<form action="index.php" method="post" enctype="multipart/form-data">';
       $frm .= '<input type="file" name="fileToUpload" id="fileToUpload">';
       $frm .= '<input type="submit" value="Upload " name="submit">';
       $frm .= '</form> ';
       $this->html .= '<h1 align="center"> <u> Upload Form </u> </h1>';
       $this->html .= $frm;
   }
  public function post() {
    //Path of the directory where the csv file has to be saved
    $targetdir = "./uploads/";
    $targetfile = $targetdir . basename($_FILES["fileToUpload"]["name"]);
    $fileType = pathinfo($targetfile,PATHINFO_EXTENSION);
    $fileName=pathinfo($targetfile,PATHINFO_BASENAME);

  move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetfile);
  header('Location: index.php?page=htmlTable&filename='.$fileName);
    
  }
}


//table rendering of the csv data sets
//loads into array
//renders the datasets into a table stepwise

class htmlTable extends page{
  public function get(){
  
    $fname = $_REQUEST['filename'];
    $file = fopen("uploads/".$fname,"r");
  $table="";
//$data = array();
$i=0;
 $table .='<table border : 3 px solid black; border-collapse :collapse; table style="width :80%" ; table>';
      while(! feof($file))
       {
         $data= fgetcsv($file);
         $count=count($data);
         $table .='<tr>';
         for($i=0;$i<$count;$i++){
           $table .='<td>'.$data[$i].'</td>';
         }
         $table .='</tr>';        
                    
       }
          $table .='</table>';
fclose($file);
  stringFunctions::printThis($table);
  
  }
}
?>
