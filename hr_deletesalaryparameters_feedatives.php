<?php
include "config.php";
$id = $_GET['id'];
  $q1 = "delete from hr_salaryparameters where id = '$id'";
  $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
  
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_salaryparameters_feedatives';"; 
echo "</script>";

?>