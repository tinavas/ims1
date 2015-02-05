<?php
include "config.php";
$id = $_GET['id'];
$month = $_GET['mon'];
$year = $_GET['year'];
$sector=$_GET['sector'];


  $q1 = "delete from hr_working_days where id = '$id'";
  $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
  
  $q2 = "update hr_mnth_attendance set workingdays = '0' where month = '$month' and year='$year' and sector='$sector'";
  $qrs2 = mysql_query($q2,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_working_days';"; 
echo "</script>";

?>