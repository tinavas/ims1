<?php 
include "config.php";
session_start(); 
$user = $_SESSION['valid_user'];

$fromdate = date("Y-m-d",strtotime($_POST['from']));
$todate = date("Y-m-d",strtotime($_POST['to']));
$mode = $_POST['mode'];

$id = $_POST['id'];

if($_POST['saed'] == 1)
$query = "SELECT id FROM ac_mode WHERE ('$fromdate' BETWEEN fromdate AND todate OR '$todate' BETWEEN fromdate AND todate) AND id <> '$id'";
else 
$query = "select id from ac_mode where ('$fromdate' BETWEEN fromdate AND todate OR '$todate' BETWEEN fromdate AND todate)";
$result = mysql_query($query,$conn) or die(mysql_error());
if( ! mysql_num_rows($result))
{
 if($_POST['saed'] == 1)
$query1 = "UPDATE ac_mode SET fromdate = '$fromdate',todate = '$todate', mode = '$mode' WHERE id = '$id'";
 else 
$query1 = "insert into ac_mode (fromdate,todate,mode) values('$fromdate','$todate','$mode')";
mysql_query($query1,$conn) or die(mysql_error());
}
else
   $alertmsg .= "The depreciation for the mode \"$mode\" for this date range is already entered in the software";
   
   
   
echo "<script type='text/javascript'>";
if($alertmsg <> "")
echo "alert('$alertmsg');"; 
echo "document.location='dashboardsub.php?page=ac_mode'";
echo "</script>";

?>
