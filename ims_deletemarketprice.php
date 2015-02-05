<?php
include "config.php";
$id = $_GET['id'];
$query = "Delete from ims_marketprice where id = '$id'";
$result = mysql_query($query,$conn) or die(mysql_error());
header('Location:dashboardsub.php?page=ims_marketprice');
?>