<?php
include "config.php";
$id = $_POST['rid'];
$date1 = date("d.m.o"); 
$date1 = date("Y-m-j",strtotime($date1));
$days = $_POST['days'];

 
  $q2 = "update hr_mnth_attendance set date='$date1' , dayspresent = '$days' where id = '$id'";
  $qrs2 = mysql_query($q2,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_mnth_attendance';"; 
echo "</script>";

?>