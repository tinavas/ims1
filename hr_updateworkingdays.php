<?php
include "config.php";
$month = $_POST['monthno'];
$year = $_POST['year'];
$nodays = $_POST['nodays'];
$id = $_POST['id'];
$date1 = $_POST['date1'];
$date1 = date("Y-m-j",strtotime($date1));


  $q1 = "update hr_workingdays set date='$date1',  noofdays = '$nodays' where id = '$id'";
  $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
  
  $q2 = "update hr_mnthattendance set workingdays = '$nodays' where month = '$month' and year='$year'";
  $qrs2 = mysql_query($q2,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_workingdays';"; 
echo "</script>";

?>