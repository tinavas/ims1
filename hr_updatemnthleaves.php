<?php
include "config.php";
$id = $_POST['id'];

$leaves = $_POST['leaves'];
$mnth = $_POST['month'];

 
  $q2 = "update hr_mnthleaves set allowedleaves='$leaves' , forwardmnths = '$mnth' where id = '$id'";
  $qrs2 = mysql_query($q2,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_mnthleaves';"; 
echo "</script>";

?>