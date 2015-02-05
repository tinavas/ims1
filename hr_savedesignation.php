<?php 
include "config.php";
$name = $_POST['designation'];
$query1 = "insert into hr_designation(name,client) values ( '$name','$client')";
$result1 = mysql_query($query1,$conn) or die(mysql_error());


echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_designation';";
echo "</script>";