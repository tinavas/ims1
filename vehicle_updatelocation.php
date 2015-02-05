<?php 
include "config.php";

$id = $_POST['id'];
$location = $_POST['location'];


$query = "UPDATE vehicle_location set location='$location' where id='$id'";
$result = mysql_query($query,$conn) or die(mysql_error());
echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=vehicle_location'";
echo "</script>";
?>


