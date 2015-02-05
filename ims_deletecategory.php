<?php
include "config.php";

$id = $_GET['id'];
$query = "DELETE FROM ims_itemtypes WHERE id = '$id' AND client = '$client'";
$result = mysql_query($query,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=ims_category'";
echo "</script>";

?>