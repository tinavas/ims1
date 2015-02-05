<?php
include "config.php";
if($_POST['vt'])
 $vtype = $_POST['vt'];
else
{
 $vtype = $_POST['newvt'];
 $q1 = "insert into vehicle_type(vtype) values('".$vtype."')";
 $qrs1 = mysql_query($q1,$conn);
}

$vnumber =($_POST['vnum']);

$sdate = date("Y-m-d",strtotime($_POST['sdate']));
$edate = date("Y-m-d",strtotime($_POST['edate']));
$stime = date("H:i:s",strtotime($_POST['stime']));
$splace = ($_POST['splace']);
$sread = ($_POST['sread']);
$etime = date("H:i:s",strtotime($_POST['etime']));
$eplace = ($_POST['eplace']);
$eread = ($_POST['eread']);
$empname=$_SESSION['valid_user'];



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
 $user=$_SESSION['valid_user'];
 $q = "insert into vehicle_tripdetails(vehicletype,vehiclenumber,driver,startdate,starttime,startplace,startreading,enddate,endtime,endplace,expensesincurred,endreading,wload,remarks,client,enteredby,empname)
values('$vtype','$vnumber','$driver','$sdate','$stime','$splace','$sread','$edate','$etime','$eplace','$exp','$eread','".htmlentities($_POST['load'], ENT_QUOTES)."','$remarks','$client','$user','$empname')"; 
$qrs = mysql_query($q,$conn) or die(mysql_error());


 
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=vehicle_tripdetails'";
echo "</script>";

?>







