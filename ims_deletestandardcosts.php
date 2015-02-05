<?php
include "config.php";

$id = $_GET['id'];
$query = "DELETE FROM ims_standardcosts WHERE id = '$id'";
$result = mysql_query($query,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=ims_standardcosts'";
echo "</script>";
?>