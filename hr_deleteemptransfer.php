<?php 

include "config.php";

$emp=$_GET['emp'];
$eid=$_GET['eid'];
$tsector=$_GET['tsector'];
$fsector=$_GET['fsector'];


$q1="delete from hr_emptransfer where employeename='$emp' and employeeid='$eid' and tosector='$tsector'";
$r1=mysql_query($q1,$conn) or die(mysql_error());

$q2="update hr_employee set sector='$fsector' where sector='$tsector' and name='$emp' and employeeid='$eid'";
mysql_query($q2,$conn) or die(mysql_error());


echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_emptransfer';"; 
echo "</script>";
?>