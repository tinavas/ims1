<?php
include "config.php";
$id = $_GET['id'];
$month = $_GET['mon'];
$year = $_GET['year'];


  $q1 = "delete from hr_workingdays where id = '$id'";
  $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
  
  $q2 = "update hr_mnthattendance set workingdays = '0' where month = '$month' and year='$year'";
  $qrs2 = mysql_query($q2,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_workingdays';"; 
echo "</script>";

?>