<?php
include "config.php";
 
$vt  = $_POST['vt'];
$id = ($_POST['id']);

$query = "update vehicle_type set vtype = '$vt' where id = '$id'";
$result = mysql_query($query,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=vehicle_type';";
echo "</script>";
?>








