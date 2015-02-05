<?php
include "config.php";

$full = $_POST['code'];
$temp = explode("@",$full);
$fstock = $_POST['fstock'];
$code = $temp[0];
$warehouse = $temp[2];

$query = "UPDATE ims_stock SET quantity = '$fstock' WHERE itemcode = '$code' AND warehouse = '$warehouse' AND client = '$client'";
$result = mysql_query($query,$conn) or die(mysql_error());

header('location:dashboardsub.php?page=ims_addstock');
?>