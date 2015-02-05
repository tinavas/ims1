<?php
include "config.php";
$client = $_SESSION['client'];
$date1 = date("d.m.o"); 
$date1 = date("Y-m-j",strtotime($date1));
$month = $_POST['month'];
$year = $_POST['year'];
$wdays = $_POST['wdays'];

for($i=0;$i<count($_POST['days']);$i++) 
{
if ($_POST['days'][$i] != "0" && $_POST['days'][$i] != "") 
{
$eid = $_POST['employeeid'][$i];
$name = $_POST['employeename'][$i];
$sector = $_POST['sect'][$i];
$desig  = $_POST['designation'][$i];
$days = $_POST['days'][$i];
$ext = $_POST['ext'][$i];
$leav=$_POST['leav'][$i];
if($ext == "")
{
$ext =0;
}
if($leav=="")
{
$leav=0;
}

 $q1 = "insert into hr_mnthattendance(date,eid,employeename,sector,designation,month,year,dayspresent,workingdays,extra,leaves,client) values('".$date1."','".$eid."','".$name."','".$sector."','".$desig."','".$month."','".$year."','".$days."','".$wdays."','".$ext."','".$leav."','".$client."')";
 $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
}
}
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_mnthattendance';"; 
echo "</script>";

?>