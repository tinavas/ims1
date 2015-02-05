<?php 
include "config.php";

$location = $_POST['location'];

$query = "insert into vehicle_location (location) values('$location')";
mysql_query($query,$conn) or die(mysql_error());
echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=vehicle_location'";
echo "</script>";
?>