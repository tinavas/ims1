<?php
//echo print_r($_POST);
include "config.php";
$emp=$_SESSION['valid_user'];

$fsector=$_POST['fromwarehouse'];
$tsector=$_POST['towarehouse'];
$employee=explode('/',$_POST['emp']);
$ldate=date("Y-m-d",strtotime($_POST['ldate']));
$jdate=date("Y-m-d",strtotime($_POST['jdate']));
$date=date("Y-m-d");


if($_POST[edit]==1)
{


}

$q1="insert into hr_emptransfer(date,fromsector,employeename,employeeid,tosector,leavingdate,joiningdate,empname) 
			  values('$date','$fsector','$employee[0]','$employee[1]','$tsector','$ldate','$jdate','$emp')";
	mysql_query($q1,$conn) or die(mysql_error());

 $q2="update hr_employee set sector='$tsector' where sector='$fsector' and name='$employee[0]' and employeeid='$employee[1]'";
mysql_query($q2,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_emptransfer';"; 
echo "</script>";
?>