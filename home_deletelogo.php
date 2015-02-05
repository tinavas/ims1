<?php 
include "config.php";
$id = $_GET['id'];
$query = "delete from home_logo where id = '$id'";
$result = mysql_query($query,$conn) or die(mysql_error());
header('Location:dashboardsub.php?page=home_logo');
?>