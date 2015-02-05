<?php
include "config.php";

for($i = 0; $i <= count($_POST['code']); $i++)
{
 if($_POST['code'][$i] <> '' && $_POST['stdcost'][$i] > 0)
 {
   $fromdate = date("Y-m-d",strtotime($_POST['fromdate'][$i]));
   $todate = date("Y-m-d",strtotime($_POST['todate'][$i]));
   $cat = $_POST['cat'][$i];
   $temp = explode('@',$_POST['code'][$i]);
   $code = $temp[0];
   $desc = $temp[1];
   $stdcost = $_POST['stdcost'][$i];
   

   
 $query1 = "SELECT id FROM ims_standardcosts WHERE code = '$code' AND ('$fromdate' BETWEEN fromdate AND todate or '$todate' BETWEEN fromdate AND todate)";
   $result1 = mysql_query($query1,$conn) or die(mysql_error());
   $rows1 = mysql_num_rows($result1);
   

    
 if($rows1 > 0)
   {
   $alertmsg .= "Standard Cost has already been entered for item code $code - $desc for the selected span  ";
   }
   else
   {
    $query2 = "INSERT INTO ims_standardcosts (fromdate,todate,cat,code,description,stdcost,client) VALUES ('$fromdate','$todate','$cat','$code','$desc','$stdcost','$client')";
	$result2 = mysql_query($query2,$conn) or die(mysql_error());
   }
 }
}

echo "<script type='text/javascript'>";
if($alertmsg <> '')
 echo "alert('$alertmsg');";
echo "document.location='dashboardsub.php?page=ims_standardcosts'";
echo "</script>";
?>