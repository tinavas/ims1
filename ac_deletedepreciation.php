<?php
include "config.php";

$id = $_GET['id'];

$query = "DELETE FROM ac_depreciation WHERE id = '$id'";
$result = mysql_query($query,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=ac_depreciation'";
echo "</script>";

?>