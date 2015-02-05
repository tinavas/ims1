<?php 
include "config.php"; 
$date = date("Y-m-j", strtotime($_POST['rdate']));
$mode = "Relieve";
$q = "update hr_employee set releaved = '1' where employeeid = '$_GET[id]'";
$r = mysql_query($q,$conn) or die(mysql_error());

$sq = "select * from hr_employee where employeeid = '$_GET[id]'";
$rq = mysql_query($sq);
while($rr = mysql_fetch_assoc($rq))
{
$qq = "insert into hr_releave values(NULL,'".$_GET['id'] ."','".$rr['joiningdate'] ."','".$rr['sector'] ."','".$rr['reportingto'] ."','".$rr['name'] ."','".$date ."','".$_POST['remark'] ."','".$mode ."')";
$rqq = mysql_query($qq,$conn) or die(mysql_error());
$sec = $rr['sector'];
$des = $rr['designation'];

$qqq = "insert into hr_relrej (eid,name,ldate) values('" . $_GET['id'] ."','". $rr['name'] ."','". $date ."')";
$rqqq = mysql_query($qqq,$conn) or die(mysql_error());

}


$url = "top.location = 'dashboard.php?page=employee.php&ss=".$sec."&dd=".$des."';";
echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=hr_employee';";
echo "</script>";


?>