<?php 
include "config.php";

$query = "delete from vehicle_spareparts where id = '$_GET[id]'";
$result = mysql_query($query,$conn) or die(mysql_error());
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=vehicle_spareparts';";
echo "</script>";
?>