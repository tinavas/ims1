<?php 
include "config.php"; 
$date = date("Y-m-j", strtotime($_POST['rdate']));
$date1 =NULL;
$mode = "Rejoin";
$q = "update hr_employee set releaved = '0',joiningdate = '$date' where employeeid = '$_GET[id]'";
$r = mysql_query($q,$conn) or die(mysql_error());

$sq = "select * from hr_employee where employeeid = '$_GET[id]'";
$rq = mysql_query($sq);
while($rr = mysql_fetch_assoc($rq))
{

$qq = "insert into hr_releave values(NULL,'".$_GET['id'] ."','".$date."','".$rr['sector'] ."','".$rr['reportingto'] ."','".$rr['name'] ."','".$date1 ."','".$_POST['remark'] ."','".$mode ."')";
$rqq = mysql_query($qq,$conn) or die(mysql_error());

$qqq = "update hr_relrej set jdate = '$date' where eid = '$_GET[id]' and ldate = '$_POST[oldrdate]' ";
$rqqq = mysql_query($qqq,$conn) or die(mysql_error());


}
echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=hr_employee';";
echo "</script>";


?>