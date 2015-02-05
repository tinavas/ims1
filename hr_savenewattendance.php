<?php

include "config.php";

$empname=$_SESSION['valid_user'];

$sector=$_POST['sector'];
$desg=$_POST['desg'];
$date=date('Y-m-d',strtotime($_POST['date']));
$status=$_POST['status'];
$emp=$_POST['emp'];
$remarks=$_POST['remarks'];
if($status=='On Leave')
{
$q1="insert into hr_newattendance (date,employee,sector,designation,leavestaken,fromdate,todate,flag,empname,narration) values('$date','$emp','$sector','$desg','0','$date','$date','0','$empname','$remarks')";
mysql_query($q1,$conn) or die(mysql_error());
/*
$q1="insert into t1 (date,employee,onleave,onwork,noofdays,empname) values('$date','$emp','YES','NO','0','$empname')";
mysql_query($q1,$conn) or die(mysql_error());*/
}

if($status=='On Work')
{
$q="select date from hr_newattendance where employee='$emp' and flag='0' and sector='$sector' and designation='$desg' order by date desc limit 1";
$r=mysql_query($q,$conn) or die(mysql_error());
$rr=mysql_fetch_array($r);

$q2=mysql_query("select datediff('$date','$rr[date]') as days",$conn) or die(mysql_error());
$r2=mysql_fetch_array($q2);

$q1="update hr_newattendance set leavestaken='$r2[days]',flag='1',todate='$date',empname='$empname',date='$date' where employee='$emp' and flag='0' and date='$rr[date]' and sector='$sector' and designation='$desg'";
mysql_query($q1,$conn) or die(mysql_error());

/*
 (date,employee,leavestaken,fromdate,todate,flag,empname) values('$date','$emp','$r2[days]','$rr[date]','$date','1','$empname')
$q3="update t1 set noofdays='$r2[days]'  and onleave='NO'  and onwork='YES' where employee='$emp' and onleave='YES' and date='$rr[date]'";
mysql_query($q3,$conn) or die(mysql_error());*/

}

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_newattendance';"; 
echo "</script>";

?>
