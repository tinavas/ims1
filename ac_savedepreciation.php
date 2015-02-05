<?php
include "config.php";

$fromdate = date("Y-m-d",strtotime($_POST['from']));
$todate = date("Y-m-d",strtotime($_POST['to']));

$query = "select mode from ac_mode where ('$fromdate' BETWEEN fromdate AND todate OR '$todate' BETWEEN fromdate AND todate)";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
$mode = $rows['mode'];
}

$oldid = $_POST['oldid'];

for($i = 0; $i < count($_POST['code']); $i++)
{
 if($_POST['code'][$i] <> "" && $_POST['amount'][$i] <> "" && $_POST['amount'][$i] <> "0" && $_POST['ecode'][$i] <> "")
 {
  $temp = explode('@',$_POST['code'][$i]);
  $code = $temp[0];
  $desc = $temp[1];
  $temp = explode('@',$_POST['ecode'][$i]);
  $ecode = $temp[0];
  $edesc = $temp[1];
  $next = $i + 1;
  $type = $_POST['type'.$next];
  $amount = $_POST['amount'][$i];
  if($_POST['saed'] == 1)
   $query = "SELECT id FROM ac_depreciation WHERE ('$fromdate' BETWEEN fromdate AND todate OR '$todate' BETWEEN fromdate AND todate) AND code = '$code' AND id <> '$oldid'";
  else  
   $query = "SELECT id FROM ac_depreciation WHERE ('$fromdate' BETWEEN fromdate AND todate OR '$todate' BETWEEN fromdate AND todate) AND code = '$code'";
  $result = mysql_query($query,$conn) or die(mysql_error());
  if( ! mysql_num_rows($result))
  {
    if($_POST['saed'] == 1)
     $query2 = "UPDATE ac_depreciation SET fromdate = '$fromdate',todate = '$todate', code = '$code', description = '$desc', ecode = '$ecode', edescription = '$edesc', type = '$type', amount = '$amount', mode = '$mode' WHERE id = '$oldid'";
	else 
	$query2 = "INSERT INTO ac_depreciation (id,fromdate,todate,code,description,ecode,edescription,type,amount,flag,mode) VALUES (NULL,'$fromdate','$todate','$code','$desc','$ecode','$edesc','$type','$amount','0','$mode')";
	mysql_query($query2,$conn) or die(mysql_error());
  }
  else
   $alertmsg .= "The depreciation for the code \"$code\" for this date range is already entered in the software        ";
 }
}

echo "<script type='text/javascript'>";
if($alertmsg <> "")
echo "alert('$alertmsg');"; 
echo "document.location='dashboardsub.php?page=ac_depreciation'";
echo "</script>";
?>