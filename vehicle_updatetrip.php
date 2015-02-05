<?php
include "config.php";
$id = $_POST['id'];
$q1 = "SELECT enteredby FROM vehicle_tripdetails WHERE id = '$id'"; 
$r1 = mysql_query($q1,$conn);
      while($row1 = mysql_fetch_assoc($r1))
      {
	  $user = $row1['enteredby'];
	  $empname=$row1['empname'];
	  }

$query3 = "delete from vehicle_tripdetails where id = '$id'";
$result3 = mysql_query($query3,$conn) or die(mysql_error());


$vtype = ($_POST['vt']);
$vnumber =($_POST['vnum']);

$sdate = date("Y-m-d",strtotime($_POST['sdate']));
$edate = date("Y-m-d",strtotime($_POST['edate']));
$stime = ($_POST['stime']);
$splace = ($_POST['splace']);
$sread = ($_POST['sread']);
$etime = ($_POST['etime']);
$eplace = ($_POST['eplace']);
$eread = ($_POST['eread']);



$exp = ($_POST['exp']);
$remarks = ($_POST['remarks']);



$driver = "";
for($i=0;$i<count($_POST['driver']);$i++)
{

if($driver == "")
{
$driver = $_POST['driver'][$i];
}
else
{
$driver = $driver . "/". $_POST['driver'][$i] ;
}
}




$q = "insert into vehicle_tripdetails(vehicletype,vehiclenumber,driver,startdate,starttime,startplace,startreading,enddate,endtime,endplace,expensesincurred,endreading,wload,remarks,client,enteredby,empname)
values('$vtype','$vnumber','$driver','$sdate','$stime','$splace','$sread','$edate','$etime','$eplace','$exp','$eread','".htmlentities($_POST['load'], ENT_QUOTES)."','$remarks','$client','$user','$empname')"; 
$qrs = mysql_query($q,$conn);









echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=vehicle_tripdetails'";
echo "</script>";

?>







