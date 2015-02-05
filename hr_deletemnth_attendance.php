<?php
include "config.php";
$id = $_GET['id'];
$month = $_GET['mon'];
$year = $_GET['year'];

  $q1 = "delete from hr_mnth_attendance where id = '$id'";
  $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
  
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_mnth_attendance';"; 
echo "</script>";

?>