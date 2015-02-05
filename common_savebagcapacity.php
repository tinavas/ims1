<?php

include "config.php";

$fromdate = $_POST['date1'];
$fromdate = date("Y-m-d",strtotime($fromdate));
$todate = $_POST['date2'];
$todate = date("Y-m-d",strtotime($todate));
$query = "SELECT bagcode FROM ims_itemcodes WHERE description = '".$_POST[bagdesc][$i]."'";
for($i=0;$i<count($_POST['capacity']);$i++)
{
  if($_POST['capacity'][$i] != "0" && $_POST['capacity'][$i] != "")
  {
   
    $query = "SELECT code FROM ims_itemcodes WHERE description = '".$_POST[bagdesc][$i]."'";
	$result = mysql_query($query,$conn) or die(mysql_error());
	$rows = mysql_fetch_array($result);
	$bagcode = $rows['code'];   
   
   $q = "insert into bagcapacity(fromdate,todate,bagcode,bagdescription,weight,capacity,units,client) values('".$fromdate."','".$todate."','".$bagcode."','".$_POST[bagdesc][$i]."','".$_POST[weight][$i]."','".$_POST[capacity][$i]."','".$_POST[units][$i]."','$client')";
   $qrs = mysql_query($q,$conn) or die(mysql_error());

  }
}

header('Location:dashboardsub.php?page=common_bagcapacity');
?>

