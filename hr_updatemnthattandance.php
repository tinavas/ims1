<?php
include "config.php";
$id = $_POST['rid'];
$date1 = date("d.m.o"); 
$date1 = date("Y-m-j",strtotime($date1));
$days = $_POST['days'];
$ext = $_POST['extra'];
$leav=$_POST['leave'];
 
  $q2 = "update hr_mnthattendance set date='$date1' , dayspresent = '$days', extra = '$ext',leaves='$leav' where id = '$id'";
  $qrs2 = mysql_query($q2,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_mnthattendance';"; 
echo "</script>";

?>