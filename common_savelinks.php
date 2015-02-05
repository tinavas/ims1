<?php
$refid = $_POST['refid'];
$icon = $_POST['icon'];
$name = $_POST['name'];
$title = $_POST['title'];
$pid = $_POST['pid'];
$step = $_POST['step'];
$link = $_POST['link'];
$sorder = $_POST['sorder'];
$active = $_POST['active'];
$target = $_POST['target'];

$data = "";
$temp = time() + ((5 * 60 * 60) + ( 30 * 60 ));	// It is to calculate the present time
$temp2 = date("d-m-Y_H:i:s",$temp);	
$data .= "Data as on ".$temp2."\n\n";

$databases = $_POST['databases'];
$bims = explode('*',$databases);

$count = count($bims);
if($count == 0)
 echo "No Databases selected";
else
{
for($i = 0; $i < count($bims); $i++)
{
 $value = $bims[$i];
 $temp = explode('@',$value);
 $db = $temp[0];
 $client = $temp[1];
 //$db = $_SESSION['db'];
 
 $db_host = "localhost";

 $db_user = "poultry";

 $db_pass = "4(vQLs+#-b";

 $db_name = $db;

//$client = $_SESSION['client'];

 $conn=mysql_connect($db_host,$db_user,$db_pass)or die(mysql_error());
 mysql_select_db($db_name);

 $query0 = "SELECT * FROM common_links WHERE refid = '$refid' AND client = '$client'";
 $result0 = mysql_query($query0,$conn) or die(mysql_error());
 $rows0 = mysql_num_rows($result0);
 if($rows0 == 0)
 {
  $query1 = "SELECT * FROM common_links WHERE refid = '$pid' AND client = '$client' AND active = 1";
  $result1 = mysql_query($query1,$conn) or die(mysql_error());
  $rows1 = mysql_num_rows($result1);
  if($rows1 <> 0 or $step == 1)
  { 
   $query = "INSERT INTO common_links (refid,icon,name,title,parentid,step,link,sortorder,active,target,client) VALUES ('$refid','$icon','$name','$title','$pid','$step','$link','$sorder','$active','$target','$client')";
   $result = mysql_query($query,$conn) or die(mysql_error());
 
   if($result) echo $db."--";
   else echo $db." FAILED   ";

	 $data .= $db."\n";
	 $query2 = "SELECT id,view,username FROM common_useraccess WHERE client = '$client' ORDER BY id";
	 $result2 = mysql_query($query2,$conn) or die(mysql_error());
	 while($rows2 = mysql_fetch_assoc($result2))
	 {
	  $id = $rows2['id'];
	  $username = $rows2['username'];
	  $view = $rows2['view'];
	  if(strlen(strstr(",".$view,",".$pid.","))	> 0 or $step == 1)//If the parent id is present, then only insert
	  {
		  $viewnew = $view . $refid . ",";
		  $data .= $username . ":: " . $view . "\n";
		  
		  $query3 = "UPDATE common_useraccess SET view = '$viewnew' WHERE client = '$client' AND id = '$id'";
		  $result3 = mysql_query($query3,$conn) or die(mysql_error());
		  
		  if($result3) echo $username." SUCESS   ";
		  else echo $username." FAILED   ";
	  }
	 }
   }
   else
   {
    echo "<br><font style='color:#FF0000'>The parent id ".$pid." is not there(or inactive) in the database \"".$db."\"</font><br>";
   } 
 }
 else
 {
  echo "<br><font style='color:#FF0000'>The reference id ".$refid." is already existing in the database \"".$db."\"</font><br>";
 }
 $data .= "\n\n";
}

$fp = fopen("production/useraccess.sql","a");
if(! $fp)
 echo "<br><font style='color:#FF0000'>Backup file not Opened</font><br>";
else
 echo "<br>Backup file Created Successfully<br>";
fwrite ($fp,$data);
fclose ($fp);

}
?>
<strong><input type="button" value="Back" onClick="document.location='dashboardsub.php?page=common_addlinks'"></strong>