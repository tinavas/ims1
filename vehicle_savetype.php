<?php 
include "config.php";
$vt= $_POST['vt'];
$query1 = "insert into vehicle_type(vtype,client) values ( '$vt','$client')";
$result1 = mysql_query($query1,$conn) or die(mysql_error());


echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=vehicle_type';";
echo "</script>";